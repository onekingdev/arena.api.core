<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Helpers\Util;
use App\Models\Users\User;
use Illuminate\Database\Seeder;
use App\Models\Support\Support;
use Illuminate\Database\Eloquent\Model;
use App\Models\Support\Ticket\SupportTicket;

class SupportTicketSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();

        $faker = Factory::create();
        $arrFlagStatus = config("constant.support.flag_status");
        $supportGroups = \App\Models\Core\Auth\AuthGroup::where('group_name', "like", "App.Office.Support.%")->get();

        foreach (Support::all() as $objSupport) {
            foreach (User::find(range(1, 6)) as $objUser) {
                /** @var SupportTicket $ticket */
                $ticket = SupportTicket::create([
                    "ticket_uuid"  => Util::uuid(),
                    "support_id"   => $objSupport->support_id,
                    "support_uuid" => $objSupport->support_uuid,
                    "user_id"      => $objUser->user_id,
                    "user_uuid"    => $objUser->user_uuid,
                    "ticket_title" => $faker->title,
                    "flag_status"  => $arrFlagStatus[rand(0, count($arrFlagStatus) - 1)],
                ]);

                $ticket->supportUser()->attach($objUser->user_id, [
                    "row_uuid"    => Util::uuid(),
                    "user_uuid"   => $objUser->user_uuid,
                    "ticket_uuid" => $ticket->ticket_uuid,
                    "flag_office" => true,
                ]);

                foreach ($supportGroups as $supportGroup) {
                    $ticket->supportGroup()->attach($supportGroup->group_id, [
                        "row_uuid"    => Util::uuid(),
                        "group_uuid"  => $supportGroup->group_uuid,
                        "ticket_uuid" => $ticket->ticket_uuid,
                    ]);
                }
            }
        }


        Model::reguard();
    }
}
