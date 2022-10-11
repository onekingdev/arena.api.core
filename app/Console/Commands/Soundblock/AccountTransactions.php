<?php

namespace App\Console\Commands\Soundblock;

use Carbon\Carbon;
use App\Facades\Exceptions\Disaster;
use App\Contracts\Soundblock\Accounting\Accounting;
use App\Exceptions\Core\Disaster\PaymentTaskException;
use Illuminate\{Console\Command, Database\Eloquent\Builder};
use App\Models\Soundblock\Accounts\AccountPlan;

class AccountTransactions extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "charge:transactions";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Charge user";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param AccountPlan $accountPlan
     * @param Accounting $accounting
     * @return void
     */
    public function handle(AccountPlan $accountPlan, Accounting $accounting): void {
        $today = Carbon::now()->day;

        $todayPlans = $accountPlan->whereHas("account", function (Builder $query) {
            $query->where("flag_status", "active");
        })->whereDay("service_date", $today)->latest()->get();

        $todayPlans = $todayPlans->unique("account_id");

        /** @var AccountPlan $plan */
        foreach ($todayPlans as $plan) {
            try {
                $successPayed = $accounting->makeCharge($plan->account);
            } catch (PaymentTaskException $e) {
                Disaster::handleDisaster($e);
            }

            if ($successPayed) {
                $plan->update(["flag_active" => true]);
                $plan->account->update([
                    "flag_status" => "active"
                ]);
            } else {
                $plan->update(["flag_active" => false]);
            }
        }
    }
}
