<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Support\Ticket\SupportTicket;
use App\Models\Support\Ticket\SupportTicketAttachment;
use App\Models\Support\Ticket\SupportTicketMessage;
use App\Models\Users\User;
use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class SupportTicketMessageSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();

        $faker = Factory::create();
        $messageStatus = config("constant.support.message_status");

        foreach (SupportTicket::all() as $objTicket) {
            foreach (User::find(range(1, 6)) as $objUser) {
                SupportTicketMessage::create([
                    "message_uuid"     => Util::uuid(),
                    "ticket_id"        => $objTicket->ticket_id,
                    "ticket_uuid"      => $objTicket->ticket_uuid,
                    "user_id"          => $objUser->user_id,
                    "user_uuid"        => $objUser->user_uuid,
                    "message_text"     => $faker->text,
                    "flag_attachments" => $faker->boolean,
                    "flag_notified"    => $faker->boolean,
                    "flag_office"      => $faker->boolean,
                    "flag_officeonly"  => $faker->boolean,
                    "flag_status"      => $messageStatus[rand(0, count($messageStatus) - 1)],
                ]);
            }
        }

        foreach (SupportTicketMessage::all() as $objMessage) {
            SupportTicketAttachment::create([
                "row_uuid"        => Util::uuid(),
                "message_id"      => $objMessage->message_id,
                "message_uuid"    => $objMessage->message_uuid,
                "ticket_id"       => $objMessage->ticket->ticket_id,
                "ticket_uuid"     => $objMessage->ticket->ticket_uuid,
                "attachment_name" => $faker->name,
                "attachment_url"  => $faker->imageUrl(),
            ]);
        }

        Model::reguard();
    }
}
