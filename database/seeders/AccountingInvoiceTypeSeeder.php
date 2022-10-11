<?php

namespace Database\Seeders;

use App\Helpers\Util;
use Illuminate\Database\Seeder;
use App\Models\{
    BaseModel,
    Core\App,
    Accounting\AccountingInvoiceType
};
use Illuminate\Database\Eloquent\Collection;

class AccountingInvoiceTypeSeeder extends Seeder
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

        $arrInvoiceType = config("constant.accounting.invoice.invoice_type");
        $arrApp = App::all();
        foreach ($arrInvoiceType as $invoiceType) {
            $objApp = $this->getAppForType($arrApp, $invoiceType);
            AccountingInvoiceType::create([
                "type_uuid"         => Util::uuid(),
                "type_name"         => $invoiceType,
                "type_code"         => strtoupper(Util::random_str(5)),
                "app_id"            => $objApp->app_id,
                "app_uuid"          => $objApp->app_uuid,
            ]);
        }

        BaseModel::reguard();
    }

    private function getAppForType(Collection $arrApp, string $typeName): App
    {
        $intKey = $arrApp->search(function ($item, $key) use ($typeName) {
            return (strpos(strtolower($typeName), $item->app_name) !== false);
        });

        return ($arrApp[$intKey]);
    }
}
