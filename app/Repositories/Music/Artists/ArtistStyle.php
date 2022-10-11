<?php

namespace App\Repositories\Music\Artists;

use Util;
use Constant;
use App\Models\Music\Style;
use App\Repositories\BaseRepository;
use App\Models\Music\Artist\Artist as ArtistModel;
use App\Models\Music\Artist\ArtistStyle as ArtistStyleModel;

class ArtistStyle extends BaseRepository {
    /**
     * @var Style
     */
    private Style $styleModel;

    /**
     * ArtistStyle constructor.
     * @param ArtistStyleModel $model
     * @param Style $styleModel
     */
    public function __construct(ArtistStyleModel $model, Style $styleModel) {
        $this->model = $model;
        $this->styleModel = $styleModel;
    }

    /**
     * @param ArtistModel $artist
     * @param array $arrStyles
     * @return ArtistModel
     * @throws \Exception
     */
    public function createMultiple(ArtistModel $artist, array $arrStyles) {
        foreach ($arrStyles as $style) {
            $objStyle = $this->styleModel->where("style_uuid", $style)->first();

            if (is_null($objStyle)) {
                throw new \Exception("Style Not Found.");
            }

            $artist->styles()->attach($objStyle->style_id, [
                "row_uuid"    => Util::uuid(),
                "artist_uuid" => $artist->artist_uuid,
                "style_uuid"  => $objStyle->style_uuid,
                "stamp_epoch"  => time(),
                "stamp_date"   => time(),
                "stamp_time"   => time(),
                "stamp_source" => Constant::ARENA_SOURCE,
            ]);
        }

        return $artist;
    }
}
