<?php

namespace Database\Seeders;

use App\Helpers\Util;
use Illuminate\Database\Seeder;
use App\Models\Common\Vendors\Vendor;
use Illuminate\Database\Eloquent\Model;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Model::unguard();

        $vendors = [
            "7digital",
            "Akazoo",
            "Amazon",
            "Apple",
            "Arena",
            "Audible Magic",
            "Bandcamp",
            "Deezer",
            "Dubset",
            "Facebook",
            "Google",
            "iHeartRadio",
            "Juno",
            "Napster",
            "Pandora",
            "Shazam",
            "Shopify",
            "Slacker",
            "Soundcloud",
            "Spotify",
            "Tiktok",
            "Traxsource",
            "UMA"
        ];

        foreach ($vendors as $vendor)
        {

            Vendor::firstOrCreate([
               "name" => $vendor,
               "vendor_uuid" => Util::uuid()
            ]);

        }

        Model::reguard();

    }
}
