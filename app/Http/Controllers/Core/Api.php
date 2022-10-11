<?php

namespace App\Http\Controllers\Core;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Soundblock\Platform as PlatformRepository;

class Api extends Controller
{
    /**
     * @var PlatformRepository
     */
    private PlatformRepository $platformRepo;

    /**
     * Api constructor.
     * @param PlatformRepository $platformRepo
     */
    public function __construct(PlatformRepository $platformRepo){
        $this->platformRepo = $platformRepo;
    }

    public function addPlatforms(){
        $objUser = Auth::user();

        if ($objUser->user_id !== 3) {
            return ($this->apiReject(null, "", 400));
        }

        $newPlatforms = [
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

        foreach ($newPlatforms as $arrPlatform) {
            $objPlatform = $this->platformRepo->findByName($arrPlatform["name"]);

            if (is_null($objPlatform)) {
                $this->platformRepo->create($arrPlatform);
            }
        }

        return ($this->apiReply(null, "", 200));
    }
}
