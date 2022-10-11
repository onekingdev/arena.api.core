<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Soundblock\Accounts\AccountTransaction;
use Illuminate\Database\Seeder;
use Faker\Factory;

class AccountingTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        AccountTransaction::all()->each(function ($transaction) {
//            /** @var AccountTransaction $transaction*/
//            $transaction->accountingTransaction()->create([
//                'transaction_uuid' => Util::uuid(),
//                'app_uuid' => $transaction->transaction_uuid,
//                'app_field' => 'transaction_id',
//                'app_field_id' => $transaction->transaction_id,
//                'app_field_uuid' => $transaction->transaction_uuid,
//                'transaction_amount' => floatval(rand(10, 1000) / 10),
//                'transaction_name' => 'transaction name',
//                'transaction_memo' => 'transaction memo',
//                'transaction_status' => 'not paid',
//            ]);
//        });
    }
}
