<?php

namespace App\Helpers\Filesystem;

use App\Helpers\Util;
use App\Models\Soundblock\Collections\Collection;
use App\Models\Soundblock\Files\File;
use App\Models\Soundblock\Projects\Project;
use App\Models\Users\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Soundblock\Artist as ArtistModel;

abstract class Soundblock extends Filesystem {
    public static function default_project_artwork_path(): string {
        return "images/artwork.png";
    }

    public static function project_path(Project $objProject): string {
        return "accounts/{$objProject->account_uuid}/projects/{$objProject->project_uuid}/";
    }

    public static function project_files_path(Project $objProject): string {
        return self::project_path($objProject) . "files/";
    }

    public static function project_artwork_path(Project $objProject): string {
        $strPath = self::project_path($objProject) . "artwork.png";

        if (bucket_storage("soundblock")->exists("public/" . $strPath)) {
            return $strPath;
        }

        return self::default_project_artwork_path();
    }

    public static function upload_project_artwork_path(Project $objProject): string {
        return "public/" . self::project_path($objProject) . "artwork.png";
    }

    public static function old_upload_project_artwork_path(Project $objProject): string {
        return self::project_files_path($objProject) . "artwork.png";
    }

    public static function project_file_path(Project $objProject, File $objFile): string {
        $strExtension = Util::file_extension($objFile->file_name);

        return self::project_files_path($objProject) . $objFile->file_uuid . "." . $strExtension;
    }

    public static function project_track_artwork(Project $objProject, File $objFile): string {
        return  self::project_files_path($objProject) . "{$objFile->file_uuid}.png";
    }

    public static function upload_path(?string $fileName = null): string {
        $strPath = "public/uploads";

        if (is_null($fileName)) {
            return $strPath;
        }

        return $strPath . "/{$fileName}";
    }

    public static function unzip_path(?string $dirName = null): string {
        return self::upload_path() . "/" . is_null($dirName) ? Util::uuid() : $dirName;
    }

    public static function download_path() {
        return "download";
    }

    public static function download_zip_path(string $zipName, ?User $objUser = null) {
        if (is_object($objUser)) {
            return self::download_path() . "/{$objUser->user_uuid}/{$zipName}.zip";
        }

        if (Auth::check()) {
            $objUser = Auth::user();

            return  self::download_path() . "/{$objUser->user_uuid}/{$zipName}.zip";
        }

        return  self::download_path() . "/{$zipName}.zip";
    }

    public static function deployment_project_path(Project $objProject) {
        return self::project_path($objProject) . "deployments";
    }

    public static function deployment_project_old_zip_path(Collection $objCollection) {
        $fileName = "Music Deployment - " . trim($objCollection->project->project_title, "\n\r\t\v\0") .
            " - " . trim($objCollection->project->project_artist, "\n\r\t\v\0") .
            " - " . $objCollection->project->project_uuid .
            " - " . $objCollection->collection_uuid;

        return self::deployment_project_path($objCollection->project) . self::DS . $fileName . ".zip";
    }

    public static function deployment_project_zip_path(Collection $objCollection) {
        $fileName = "Music Deployment - " . trim($objCollection->project->project_title, "\n\r\t\v\0") .
            " - " . trim($objCollection->project->project_artist, "\n\r\t\v\0") .
            " - " . $objCollection->collection_uuid;

        return self::deployment_project_path($objCollection->project) . self::DS . $fileName . ".zip";
    }

    public static function office_deployment_project_zip_path(Collection $objCollection) {
        $fileName = "Music Deployment - " . trim($objCollection->project->project_title, "\n\r\t\v\0") .
            " - " . trim($objCollection->project->project_artist, "\n\r\t\v\0") .
            " - " . $objCollection->collection_uuid;

        return "soundblock" . self::DS . self::deployment_project_path($objCollection->project) . self::DS . $fileName . ".zip";
    }

    public static function artists_avatar_path(ArtistModel $objArtist){
        $avatarName = "Artist - " . $objArtist->artist_name . " - " . $objArtist->artist_uuid . ".png";

        return "accounts/{$objArtist->account_uuid}/artists/" . $avatarName;
    }

    public static function artists_draft_avatar_path(ArtistModel $objArtist){
        $avatarName = "Artist - " . $objArtist->artist_name . " - " . $objArtist->artist_uuid . ".png";

        return "upload" . self::DS . "artists" . self::DS . $avatarName;
    }
}
