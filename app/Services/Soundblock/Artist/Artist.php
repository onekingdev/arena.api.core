<?php

namespace App\Services\Soundblock\Artist;

use App\Facades\Core\Converter;
use Exception;
use Illuminate\Support\Facades\Storage;
use Util;
use App\Helpers\Filesystem\Soundblock;
use App\Services\Common\Zip as ZipService;
use App\Models\Soundblock\Artist as ArtistModel;
use App\Models\Soundblock\Accounts\Account as AccountModel;
use App\Models\Soundblock\Projects\Project as ProjectModel;
use App\Repositories\Soundblock\Artist as ArtistRepository;
use App\Contracts\Soundblock\Artist\Artist as ArtistContract;
use App\Models\Soundblock\ArtistPublisher as ArtistPublisherModel;
use App\Repositories\Soundblock\ArtistPublisher as ArtistPublisherRepository;

class Artist implements ArtistContract {
    /** @var ArtistRepository */
    private ArtistRepository $artistRepo;
    /** @var ArtistPublisherRepository */
    private ArtistPublisherRepository $artistPublisherRepo;
    /** @var \Illuminate\Contracts\Filesystem\Filesystem|\Illuminate\Filesystem\FilesystemAdapter */
    private $soundblockAdapter;

    /**
     * Artist constructor.
     * @param ArtistRepository $artistRepo
     * @param ArtistPublisherRepository $artistPublisherRepo
     */
    public function __construct(ArtistRepository $artistRepo, ArtistPublisherRepository $artistPublisherRepo) {
        $this->artistRepo = $artistRepo;
        $this->artistPublisherRepo = $artistPublisherRepo;

        if (env("APP_ENV") == "local") {
            $this->soundblockAdapter = Storage::disk("local");
        } else {
            $this->soundblockAdapter = bucket_storage("soundblock");
        }
    }

    /**
     * @param string $account_uuid
     * @return mixed
     */
    public function findAllByAccount(string $account_uuid){
        $objArtists = $this->artistRepo->findAllByAccount($account_uuid);

        $objArtists->each(function ($objArtist) {
            $objArtist["avatar_url"] = $objArtist->avatar_url;
        });

        return ($objArtists);
    }

    /**
     * @param string $artist_uuid
     * @return mixed
     * @throws \Exception
     */
    public function findByUuid(string $artist_uuid){
        return ($this->artistRepo->find($artist_uuid));
    }

    public function find(string $strName) {
        return $this->artistRepo->findByName($strName);
    }

    public function findArtistPublisher(string $publisher){
        return ($this->artistPublisherRepo->find($publisher));
    }

    public function findAllPublisherByAccount(string $account){
        return ($this->artistPublisherRepo->findAllByAccount($account));
    }

    public function typeahead(array $arrData) {
        return $this->artistRepo->typeahead($arrData);
    }

    public function create(array $arrData, AccountModel $objAccount) {
        $objArtist = $this->artistRepo->findByAccountAndName($objAccount->account_uuid, $arrData["artist_name"]);

        if ($objArtist) {
            throw new Exception("You are already have this artist.");
        }

        $arrData["artist_uuid"] = Util::uuid();
        $arrData["account_id"] = $objAccount->account_id;
        $arrData["account_uuid"] = $objAccount->account_uuid;

        if (isset($arrData["url_apple"]) && $arrData["url_apple"] != "") {
            $arrParsedUrlApple = parse_url($arrData["url_apple"]);
            $arrData["url_apple"] = $arrParsedUrlApple["scheme"] . "://" . $arrParsedUrlApple["host"]  . $arrParsedUrlApple["path"];
        }

        if (isset($arrData["url_spotify"]) && $arrData["url_spotify"] != "") {
            $arrParsedUrlApple = parse_url($arrData["url_spotify"]);
            $arrData["url_spotify"] = $arrParsedUrlApple["scheme"] . "://" . $arrParsedUrlApple["host"]  . $arrParsedUrlApple["path"];
        }

        if (isset($arrData["url_soundcloud"]) && $arrData["url_soundcloud"] != "") {
            $arrParsedUrlApple = parse_url($arrData["url_soundcloud"]);
            $arrData["url_soundcloud"] = $arrParsedUrlApple["scheme"] . "://" . $arrParsedUrlApple["host"]  . $arrParsedUrlApple["path"];
        }

        return $this->artistRepo->create($arrData);
    }

    public function uploadAvatar($objFile, ArtistModel $objArtist){
        $success = true;
        $avatarPath = Soundblock::artists_avatar_path($objArtist);

        if ($this->soundblockAdapter->exists("public/" . $avatarPath)) {
            $this->soundblockAdapter->delete("public/" . $avatarPath);
        }

        $ext = $objFile->getClientOriginalExtension();

        if (Util::lowerLabel($ext) !== "png") {
            $objFile = Converter::convertImageToPng($objFile->getPathname());
        }

        if (!$this->soundblockAdapter->putFile("public/" . $avatarPath, $objFile, "public")) {
            $success = false;
        }

        return ($success);
    }

    public function uploadDraftAvatar($objFile, ArtistModel $objArtist){
        $success = true;
        $avatarPath = Soundblock::artists_draft_avatar_path($objArtist);

        if ($this->soundblockAdapter->exists("public/" . $avatarPath)) {
            $this->soundblockAdapter->delete("public/" . $avatarPath);
        }

        $ext = $objFile->getClientOriginalExtension();

        if (Util::lowerLabel($ext) !== "png") {
            $objFile = Converter::convertImageToPng($objFile->getPathname());
        }

        if (!$this->soundblockAdapter->putFile("public/" . $avatarPath, $objFile, "public")) {
            $success = false;
        }

        return ($success);
    }

    public function storeArtistPublisher(string $strName, AccountModel $objAccount, ArtistModel $objArtist){
        $objPublisher = $this->artistPublisherRepo->findByAccountAndName($objAccount->account_uuid, $strName);

        if ($objPublisher) {
            throw new Exception("You are already have this publisher.");
        }

        $arrParams = [
            "publisher_uuid" => Util::uuid(),
            "account_id" => $objAccount->account_id,
            "account_uuid" => $objAccount->account_uuid,
            "artist_id" => $objArtist->artist_id,
            "artist_uuid" => $objArtist->artist_uuid,
            "publisher_name" => $strName
        ];

        return ($this->artistPublisherRepo->create($arrParams));
    }

    public function update(ArtistModel $objArtist, array $updateData){
        if (isset($updateData["url_apple"]) && $updateData["url_apple"] != "") {
            $arrParsedUrlApple = parse_url($updateData["url_apple"]);
            $updateData["url_apple"] = $arrParsedUrlApple["scheme"] . "://" . $arrParsedUrlApple["host"]  . $arrParsedUrlApple["path"];
        }

        if (isset($updateData["url_spotify"]) && $updateData["url_spotify"] != "") {
            $arrParsedUrlApple = parse_url($updateData["url_spotify"]);
            $updateData["url_spotify"] = $arrParsedUrlApple["scheme"] . "://" . $arrParsedUrlApple["host"]  . $arrParsedUrlApple["path"];
        }

        if (isset($updateData["url_soundcloud"]) && $updateData["url_soundcloud"] != "") {
            $arrParsedUrlApple = parse_url($updateData["url_soundcloud"]);
            $updateData["url_soundcloud"] = $arrParsedUrlApple["scheme"] . "://" . $arrParsedUrlApple["host"]  . $arrParsedUrlApple["path"];
        }

        return ($this->artistRepo->update($objArtist, $updateData));
    }

    public function updateArtistPublisher(ArtistPublisherModel $objPublisher, string $name){
        return ($this->artistPublisherRepo->update($objPublisher, ["publisher_name" => $name]));
    }

    public function delete(string $artist){
        return ($this->artistRepo->delete($artist));
    }

    public function deleteArtistPublisher(string $publisher){
        return ($this->artistPublisherRepo->destroy($publisher));
    }
}
