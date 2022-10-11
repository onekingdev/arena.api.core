<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\{
    BaseModel,
    Core\App,
    Accounting\AccountingTransactionType
};
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Collection;

class AccountingTransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        BaseModel::unguard();

        $arrTransactionType = config("constant.accounting.transaction.transaction_type");
        $arrApp = App::all();
        foreach ($arrTransactionType as $transactionType) {
            $objApp = $this->getAppForType($arrApp, $transactionType);
            AccountingTransactionType::create([
                "type_uuid"     => Util::uuid(),
                "type_name"     => $transactionType,
                "type_code"     => strtoupper(Util::random_str(5)),
                "app_id"        => $objApp->app_id,
                "app_uuid"      => $objApp->app_uuid
            ]);
        }

        BaseModel::reguard();
    }

    private function getAppForType(Collection $arrApp, string $typeName): App
    {
        $intKey = $arrApp->search(function ($item) use ($typeName) {
            return (strpos(strtolower($typeName), "arena.app.$item->app_name") !== false);
        });

        return ($arrApp[$intKey]);
    }
}
