<?php

namespace Database\Seeders;

use App\Models\Soundblock\Platform;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class SoundblockPlatformSeeder extends Seeder {
    const CATEGORIES = ["music", "video", "merchandising"];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();

        $platforms = [
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Apple Music",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Pandora",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Arena",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => true,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Spotify",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "iHeartRadio",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "YouTube",
                "flag_music"         => false,
                "flag_video"         => true,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Juno Download",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "SHAZAM",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Deezer",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Soundcloud",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Amazon Music",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Amazon",
                "flag_music"         => false,
                "flag_video"         => false,
                "flag_merchandising" => true,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Google Play",
                "flag_music"         => true,
                "flag_video"         => true,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Dubset",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Slacker Radio",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Uma Music",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Bandcamp",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Digital",
                "flag_music"         => true,
                "flag_video"         => true,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Akazoo",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Audible Magic",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Napster",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Shopify",
                "flag_music"         => false,
                "flag_video"         => false,
                "flag_merchandising" => true,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "TikTok",
                "flag_music"         => false,
                "flag_video"         => true,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Traxsource",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Anghami",
                "flag_music"         => true,
                "flag_video"         => true,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Boomplay",
                "flag_music"         => true,
                "flag_video"         => true,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Facebook",
                "flag_music"         => true,
                "flag_video"         => true,
                "flag_merchandising" => true,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "AWA",
                "flag_music"         => true,
                "flag_video"         => true,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "7digital",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "KKBOX",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "ROXI",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "JOOX",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Snapchat",
                "flag_music"         => true,
                "flag_video"         => true,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Peloton",
                "flag_music"         => false,
                "flag_video"         => false,
                "flag_merchandising" => true,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Mixcloud",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Triller",
                "flag_music"         => true,
                "flag_video"         => true,
                "flag_merchandising" => true,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "SberZvuk",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Tencent Music",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Vevo",
                "flag_music"         => true,
                "flag_video"         => true,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "NetEase",
                "flag_music"         => true,
                "flag_video"         => true,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Jio",
                "flag_music"         => true,
                "flag_video"         => true,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Jaxsta",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Yandex Music",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Soundtrack Your Brand",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ],
            [
                "platform_uuid"      => strtoupper((string)\Str::uuid()),
                "name"               => "Resso",
                "flag_music"         => true,
                "flag_video"         => false,
                "flag_merchandising" => false,
            ]
        ];

        foreach ($platforms as $platform) {
            $objPlatform = new Platform();
            $objPlatform->create($platform);
        }

        Model::reguard();
    }
}
