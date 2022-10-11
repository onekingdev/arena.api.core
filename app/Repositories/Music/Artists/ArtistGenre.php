<?php

namespace App\Repositories\Music\Artists;

use Util;
use Constant;
use App\Models\Music\Genre;
use App\Repositories\BaseRepository;
use App\Models\Music\Artist\Artist as ArtistModel;
use App\Models\Music\Artist\ArtistGenre as ArtistGenreModel;

class ArtistGenre extends BaseRepository {
    /**
     * @var Genre
     */
    private Genre $genreModel;

    /**
     * ArtistGenre constructor.
     * @param ArtistGenreModel $model
     * @param Genre $genreModel
     */
    public function __construct(ArtistGenreModel $model, Genre $genreModel) {
        $this->model = $model;
        $this->genreModel = $genreModel;
    }

    /**
     * @param ArtistModel $artist
     * @param array $arrData
     * @return ArtistModel
     * @throws \Exception
     */
    public function createMultiple(ArtistModel $artist, array $arrData) {
        foreach ($arrData as $genre) {
            $objGenre = $this->genreModel->where("genre_uuid", $genre)->first();

            if (is_null($objGenre)) {
                throw new \Exception("Genre Not Found.");
            }

            $artist->genres()->attach($objGenre->genre_id, [
                "row_uuid"     => Util::uuid(),
                "artist_uuid"  => $artist->artist_uuid,
                "genre_uuid"   => $objGenre->genre_uuid,
                "stamp_epoch"  => time(),
                "stamp_date"   => time(),
                "stamp_time"   => time(),
                "stamp_source" => Constant::ARENA_SOURCE,
            ]);
        }

        return $artist;
    }
}
