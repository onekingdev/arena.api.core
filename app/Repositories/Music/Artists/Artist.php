<?php

namespace App\Repositories\Music\Artists;

use Util;
use App\Models\Music\Artist\Artist as ArtistModel;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class Artist extends BaseRepository {
    /**
     * Artist constructor.
     * @param ArtistModel $model
     */
    public function __construct(ArtistModel $model) {
        $this->model = $model;
    }

    public function findAll(?int $perPage = 10, array $arrFilters = []) {
        $objBuilder = $this->model->with("projects", "alias", "genres", "members", "styles", "projects.genres");

        if (isset($arrFilters["name"])) {
            $objBuilder = $objBuilder->whereRaw("lower(artist_name) like (?)", "%" . Util::lowerLabel($arrFilters["name"]) . "%");
        }


        if (isset($arrFilters["genres"])) {
            $objBuilder = $objBuilder->whereHas("genres", function (Builder $objQueryBuilder) use ($arrFilters) {
                if (is_array($arrFilters["genres"])) {
                    $objQueryBuilder->whereIn("genres.genre_uuid", $arrFilters["genres"]);
                }
            });
        }

        if (isset($arrFilters["styles"])) {
            $objBuilder = $objBuilder->whereHas("styles", function (Builder $objQueryBuilder) use ($arrFilters) {
                if (is_array($arrFilters["styles"])) {
                    $objQueryBuilder->whereIn("styles.style_uuid", $arrFilters["styles"]);
                }
            });
        }

        [$objBuilder, $availableMetaData] = $this->applyMetaFilters($arrFilters, $objBuilder);

        if (is_int($perPage)) {
            $objData = $objBuilder->paginate($perPage);
        } else {
            $objData = $objBuilder->get();
        }

        return ([$objData, $availableMetaData]);
    }

    /**
     * @param int|string $id
     * @param bool $bnFailure
     * @return mixed
     * @throws \Exception
     */
    public function find($id, bool $bnFailure = false) {
        $objProject = parent::find($id, $bnFailure);

        if (isset($objProject)) {
            $objProject->load("alias", "genres", "members", "styles", "themes", "influenced", "moods");
        }

        return $objProject;
    }

    /**
     * @param array $arrParams
     * @return ArtistModel
     */
    public function create(array $arrParams): ArtistModel {
        $arrArtistData = [
            "arena_id"      => "",
            "artist_name"   => $arrParams["name"],
            "artist_active" => $arrParams["active_date"],
            "artist_born"   => $arrParams["born"],
            "stamp_epoch"   => time(),
            "stamp_date"    => time(),
            "stamp_time"    => time(),
            "url_allmusic"  => $arrParams["allmusic_url"] ?? "",
            "url_amazon"    => $arrParams["amazon_url"] ?? "",
            "url_itunes"    => $arrParams["itunes_url"] ?? "",
            "url_lastfm"    => $arrParams["lastfm_url"] ?? "",
            "url_spotify"   => $arrParams["spotify_url"] ?? "",
            "url_wikipedia" => $arrParams["wikipedia_url"] ?? "",
        ];

        return parent::create($arrArtistData);
    }

    public function autocomplete(string $name, int $perPage = 10) {
        return $this->model->whereRaw("lower(artist_name) like (?)", "%" . Util::lowerLabel($name) . "%")
            ->with("alias", "genres", "members", "styles", "themes", "influenced", "moods")->paginate($perPage);
    }
}
