<?php

namespace Tests\Feature\Soundblock\Service\Reports;

use App\Models\Accounting\AccountingTransaction;
use App\Models\Accounting\AccountingType;
use App\Models\Soundblock\Accounts\Account;
use App\Models\Soundblock\Accounts\AccountTransaction;
use App\Models\Users\Contact\UserContactEmail;
use App\Models\Users\User;
use Illuminate\Support\Facades\Queue;
use Laravel\Passport\Passport;
use Tests\TestCase;

class MonthlyReportTest extends TestCase {
    private User $user;
    private Account $service;

    private array $transactionsByMonth = [];
    private $accountingType;

    public function setUp(): void {
        parent::setUp();
        Queue::fake();

        $_SERVER["HTTP_X_API"] = "v1.0";
        $_SERVER["HTTP_X_API_HOST"] = "app.arena.soundblock.web";

        $this->user = User::factory()->create();
        $this->user->emails()->save(UserContactEmail::factory()->make(["user_uuid" => $this->user->user_uuid]));
        $this->service = $this->user->service()->create(Account::factory()->make([
            "user_uuid" => $this->user->user_uuid,
        ])->setAppends([])->toArray());

        $begin = now()->subMonths(11);

        $this->accountingType = AccountingType::factory()->create();

        foreach ($begin->range(now(), 1, "month") as $date) {
            $this->transactionsByMonth[$date->month] = AccountTransaction::factory()->count(5)->dummyLedgerData()->create([
                "service_id"       => $this->service->service_id,
                "service_uuid"     => $this->service->service_uuid,
                "stamp_created_at" => $date,
                "stamp_updated_at" => $date,
            ])->makeVisible(["transaction_id", "ledger_id", "service_id"])->each(function ($transaction) {
                $accountingArray = AccountingTransaction::factory()->create([
                    "app_field"            => "row_id",
                    "app_table"            => "soundblock_services_transactions",
                    "app_field_id"         => $transaction->row_id,
                    "app_field_uuid"       => $transaction->row_uuid,
                    "accounting_type_id"   => $this->accountingType->accounting_type_id,
                    "accounting_type_uuid" => $this->accountingType->accounting_type_uuid,
                ])->makeVisible(["app_id", "app_field_id"]);
                /** @var AccountTransaction $transaction */
                $transaction->accountingTransaction()->associate($accountingArray);
                $transaction->transaction_uuid = $accountingArray->transaction_uuid;
                $transaction->save();
            });
        }

        Passport::actingAs($this->user);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testMonthlyReport() {
        $response = $this->get('/soundblock/reports/service/');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data" => [
                [
                    "month",
                    "amount"
                ]
            ],
            "status" => [
                "app",
                "code",
                "message"
            ]
        ]);

        $arrResponse = json_decode($response->getContent(), true);

        foreach ($arrResponse["data"] as $monthReport) {
            $monthTransactions = $this->transactionsByMonth[$monthReport["month"]];
            $monthAccountTransactions = $monthTransactions->pluck("accountingTransaction");
            $this->assertEquals($monthReport["amount"], $monthAccountTransactions->sum("transaction_amount"));
        }
    }
}
