<?php

namespace App\Repositories\Music\Projects;

use Util;
use App\Helpers\Filesystem\Music;
use App\Repositories\BaseRepository;
use App\Models\Music\Project\Project;
use Illuminate\Database\Eloquent\Builder;

class Projects extends BaseRepository {
    /**
     * Projects constructor.
     * @param Project $model
     */
    public function __construct(Project $model) {
        $this->model = $model;
    }

    public function findAll(?int $perPage = 10, ?array $arrFilters = []) {
        $objBuilder = $this->model->with("artist", "genres", "moods", "styles", "themes");

        if (isset($arrFilters["genres"])) {
            $objBuilder = $objBuilder->whereHas("genres", function (Builder $objQueryBuilder) use ($arrFilters) {
                if (is_array($arrFilters["genres"])) {
                    $objQueryBuilder->whereIn("genres.genre_uuid", $arrFilters["genres"]);
                }
            });
        }

        if (isset($arrFilters["moods"])) {
            $objBuilder = $objBuilder->whereHas("moods", function (Builder $objQueryBuilder) use ($arrFilters) {
                if (is_array($arrFilters["moods"])) {
                    $objQueryBuilder->whereIn("moods.mood_uuid", $arrFilters["moods"]);
                }
            });
        }

        if (isset($arrFilters["themes"])) {
            $objBuilder = $objBuilder->whereHas("themes", function (Builder $objQueryBuilder) use ($arrFilters) {
                if (is_array($arrFilters["themes"])) {
                    $objQueryBuilder->whereIn("themes.theme_uuid", $arrFilters["themes"]);
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

        if (isset($arrFilters["artist_name"])) {
            $objBuilder = $objBuilder->whereHas("artist", function (Builder $objQueryBuilder) use ($arrFilters) {
                if (is_string($arrFilters["artist_name"])) {
                    $objQueryBuilder->whereRaw("lower(artist_name) like (?)", "%" . Util::lowerLabel($arrFilters["artist_name"]) . "%");
                }
            });
        }

        if (isset($arrFilters["artist"])) {
            $objBuilder = $objBuilder->where("artist_uuid", $arrFilters["artist"]);
        }

        if (isset($arrFilters["filter_year"])) {
            $objBuilder = $objBuilder->where("project_year", $arrFilters["filter_year"]);
        }

        if (isset($arrFilters["sort_by_year"])) {
            $objBuilder = $objBuilder->orderBy("project_year", $arrFilters["sort_by_year"]);
        }

        if (isset($arrFilters["popularity"])) {
            $objBuilder = $objBuilder->orderBy("rating_value", $arrFilters["popularity"]);
        }

        if (isset($arrFilters["has_file"])) {
            $arrDirNames = bucket_storage("music")->directories(Music::projects_path());
            $arrDirNames = array_map([Music::class, "cut_projects_path"], $arrDirNames);
            $arrDirNames = array_filter($arrDirNames, [Util::class, "is_uuid"]);

            if ($arrFilters["has_file"] == true) {
                $objBuilder = $objBuilder->whereIn("project_uuid", $arrDirNames);
            } else {
                $objBuilder = $objBuilder->whereNotIn("project_uuid", $arrDirNames);
            }
        }

        if (isset($arrFilters["rating"])) {
            $objBuilder = $objBuilder->where("rating_value", $arrFilters["rating"]);
        }

        if (isset($arrFilters["flag_office_hide"])) {
            $objBuilder = $objBuilder->where("flag_office_hide", $arrFilters["flag_office_hide"]);
        }

        if (isset($arrFilters["flag_office_complete"])) {
            $objBuilder = $objBuilder->where("flag_office_complete", $arrFilters["flag_office_complete"]);
        }

        [$objBuilder, $availableMetaData] = $this->applyMetaFilters($arrFilters, $objBuilder);

        if (is_int($perPage)) {
            $objData = $objBuilder->paginate($perPage);
        } else {
            $objData = $objBuilder->get();
        }

        return [$objData, $availableMetaData];
    }

    public function find($id, bool $bnFailure = false) {
        $objProject = parent::find($id, $bnFailure);

        if (isset($objProject)) {
            $objProject->load("genres", "moods", "styles", "themes", "tracks");
        }

        return $objProject;
    }
}
