<?php

namespace App\Helpers\Filesystem;

use App\Helpers\Util;
use App\Models\Music\Project\Project;

class Music extends Filesystem {
    public static function project_track_path(Project $objProject, string $strTrackUuid): string {
        return "projects/{$objProject->project_uuid}/tracks/{$strTrackUuid}";
    }

    public static function track_bitrate_path(string $strTrackPath, string $strBitRate, string $strExtension): string {
        if (substr($strTrackPath, -1) !== self::DS) {
            $strTrackPath .= self::DS;
        }

        return $strTrackPath . $strBitRate . "." . $strExtension;
    }

    public static function project_zip_directory(Project $objProject): string {
        return "projects/{$objProject->project_uuid}/zip";
    }

    public static function project_zip_path(Project $objProject): string {
        return self::project_zip_directory($objProject) . self::DS . Util::uuid() . ".zip";
    }

    public static function project_original_tracks_path(Project $objProject): string {
        return "projects/{$objProject->project_uuid}/originals";
    }

    public static function projects_path(): string {
        return "projects/";
    }

    public static function cut_projects_path($strItem): string {
        return str_replace(self::projects_path(), "", $strItem);
    }
}
