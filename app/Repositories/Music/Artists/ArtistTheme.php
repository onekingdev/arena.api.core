<?php

namespace App\Repositories\Music\Artists;

use Util;
use Constant;
use App\Models\Music\Theme;
use App\Repositories\BaseRepository;
use App\Models\Music\Artist\Artist as ArtistModel;
use App\Models\Music\Artist\ArtistTheme as ArtistThemeModel;

class ArtistTheme extends BaseRepository {
    /**
     * @var Theme
     */
    private Theme $themeModel;

    /**
     * ArtistTheme constructor.
     * @param ArtistThemeModel $model
     * @param Theme $themeModel
     */
    public function __construct(ArtistThemeModel $model, Theme $themeModel) {
        $this->model = $model;
        $this->themeModel = $themeModel;
    }

    /**
     * @param ArtistModel $artist
     * @param array $arrThemes
     * @return ArtistModel
     * @throws \Exception
     */
    public function createMultiple(ArtistModel $artist, array $arrThemes) {
        foreach ($arrThemes as $theme) {
            $objTheme = $this->themeModel->where("theme_uuid", $theme)->first();

            if (is_null($objTheme)) {
                throw new \Exception("Theme Not Found.");
            }

            $artist->themes()->attach($objTheme->theme_id, [
                "row_uuid"     => Util::uuid(),
                "artist_uuid"  => $artist->artist_uuid,
                "theme_uuid"   => $objTheme->theme_uuid,
                "stamp_epoch"  => time(),
                "stamp_date"   => time(),
                "stamp_time"   => time(),
                "stamp_source" => Constant::ARENA_SOURCE,
            ]);
        }

        return $artist;
    }
}
