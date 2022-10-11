<?php

namespace App\Console\Commands\Core\Social;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Faker\Provider\UserAgent;
use Illuminate\Console\Command;
use App\Models\Core\Social\Instagram;

class GetInstagramImages extends Command {
    const ACCOUNT_URL = "arenamerchandising";
    const DOMAIN = "https://www.instagram.com/";
    const GRAPHQL_QUERY_URI = "graphql/query";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'social:instagram:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Images From Instagram Account.';
    /**
     * @var Client
     */
    private Client $http;
    /**
     * @var Instagram
     */
    private Instagram $instagram;
    private string $userAgent;

    /**
     * Create a new command instance.
     *
     * @param Instagram $instagram
     */
    public function __construct(Instagram $instagram) {
        parent::__construct();

        $this->http = new Client([
            "base_uri" => self::DOMAIN,
        ]);
        $this->instagram = $instagram;
        $this->userAgent = UserAgent::chrome();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle() {
        $arrImagesInfo = null;
        $htmlResponse = $this->http->get(self::ACCOUNT_URL, [
            "headers" => [
                "user-agent" => $this->userAgent,
            ],
        ]);
        $strHtml = $htmlResponse->getBody()->getContents();

        if (preg_match("/<script type=\"text\/javascript\">window\._sharedData = (.+);<\/script>/", $strHtml, $arrMatches)) {
            $arrData = json_decode($arrMatches[1], true);

            if (!isset($arrData["entry_data"]["ProfilePage"])) {
                return;
            }

            $arrImagesInfo ??= $arrData["entry_data"]["ProfilePage"][0]["graphql"]["user"]["edge_owner_to_timeline_media"];

            if (is_null($arrImagesInfo)) {
                return;
            }

            foreach ($arrImagesInfo["edges"] as $arrImgInfo) {
                $this->saveImage($arrImgInfo["node"]["display_url"], $arrImgInfo["node"]["id"], $arrImgInfo["node"]["taken_at_timestamp"]);
            }

            preg_match('/"(\/static\/bundles\/metro\/ActivityFeedBox\.js.+?)"/', $strHtml, $arrJsMatches);

            if (empty($arrJsMatches)) {
                return;
            }

            $jsResponse = $this->http->get($arrJsMatches[1], [
                "headers" => [
                    "user-agent" => $this->userAgent,
                ],
            ]);
            $strJs = $jsResponse->getBody()->getContents();

            preg_match("/queryId:\"(.+)\"/", $strJs, $arrQueryIdMatch);

            if (empty($arrQueryIdMatch)) {
                return;
            }

            $strQueryId = $arrQueryIdMatch[1];

            $this->loadImages($arrData["entry_data"]["ProfilePage"][0]["graphql"]["user"]["id"], $strQueryId, $arrImagesInfo["page_info"]["end_cursor"]);
        }
    }

    private function loadImages(int $accountId, string $queryHash, string $lastCursor) {
        $pageInfo = null;

        $reqVariables = [
            "id" => $accountId,
            "first" => 12,
            "after" => $lastCursor
        ];

        $imgResponse = $this->http->get(self::GRAPHQL_QUERY_URI, [
            "query" => [
                "query_hash" => $queryHash,
                "variables" => json_encode($reqVariables)
            ],
            "headers" => [
                "user-agent" => $this->userAgent,
            ],
        ]);
        $imgJson = $imgResponse->getBody()->getContents();

        $arrResponse = json_decode($imgJson, true);

        $pageInfo ??= $arrResponse["data"]["user"]["edge_owner_to_timeline_media"]["page_info"];

        if (is_null($pageInfo)) {
            return;
        }

        foreach ($arrResponse["data"]["user"]["edge_owner_to_timeline_media"]["edges"] as $arrImageInfo) {
            $this->saveImage($arrImageInfo["node"]["display_url"], $arrImageInfo["node"]["id"], $arrImageInfo["node"]["taken_at_timestamp"]);
        }

        if ($pageInfo["has_next_page"]) {
            $this->loadImages($accountId, $queryHash, $pageInfo["end_cursor"]);
        }
    }

    protected function saveImage(string $url, int $instagramId, int $epoch) {
        $mediaRow = $this->instagram->where("instagram_id", $instagramId)->first();

        if (isset($mediaRow)) {
            return;
        }

        $mediaRow = $this->instagram->create([
            "instagram_id" => $instagramId,
            "photo_epoch" => Carbon::parse($epoch)
        ]);

        $filePath = config("constant.social.instagram.media_path.s3");
        $convertedFileName = $this->convertToPng($url);
        bucket_storage("core")->putFileAs($filePath, $convertedFileName, $mediaRow->photo_uuid . ".png", "public");
        unlink($convertedFileName);
    }

    private function convertToPng($url) {
        $tmpFileName = tempnam(null,null);
        $image = imagecreatefromjpeg($url);

        imagepng($image, $tmpFileName);

        return $tmpFileName;
    }
}
