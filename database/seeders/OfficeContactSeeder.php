<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Core\Auth\AuthGroup;
use App\Models\BaseModel;
use App\Models\Office\Contact;
use App\Models\Users\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class OfficeContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Factory::create();

        foreach(User::all() as $user)
        {
            $randomVal = rand(0,1);
            Contact::create([
                "contact_uuid" => Util::uuid(),
                "user_id" => $randomVal == 0 ? null : $user->user_id,
                "user_uuid" => $randomVal == 0 ? null : $user->user_uuid,
                "contact_name_first" => $faker->firstName,
                "contact_name_last" => $faker->lastName,
                "contact_business" => $faker->company,
                "contact_subject" => $faker->jobTitle,
                "contact_email" => $faker->email,
                "contact_phone" => $faker->phoneNumber,
                // "contact_host" => $faker->ipv4,
                // "contact_agent" => $faker->userAgent,
                "contact_memo" => $faker->realText(),
                "contact_json" => [
                    "order_number" => $faker->numberBetween(1, 1000)
                ]
            ]);
        }

        $officeGroup = AuthGroup::where("group_name", "App.Office.Admin")->firstOrFail();
        foreach(Contact::all() as $contact) {
            $contact->access_groups()->attach($officeGroup->group_id, [
                "row_uuid" => Util::uuid(),
                "contact_uuid" => $contact->contact_uuid,
                "group_uuid" => $officeGroup->group_uuid,
                "flag_read" => rand(0, 1),
                "flag_archive" => rand(0, 1),
                "flag_delete" => false,
                BaseModel::STAMP_CREATED => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED => time(),
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);
        }

        foreach(Contact::all() as $contact) {
            $user = User::find($contact->contact_id);
            $contact->access_users()->attach($user->user_id, [
                "row_uuid" => Util::uuid(),
                "contact_uuid" => $contact->contact_uuid,
                "user_uuid" => $user->user_uuid,
                "flag_read" => rand(0, 1),
                "flag_archive" => rand(0, 1),
                "flag_delete" => false,
                BaseModel::STAMP_CREATED => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED => time(),
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);
        }
    }

}
