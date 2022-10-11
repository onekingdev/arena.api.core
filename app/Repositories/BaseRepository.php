<?php

namespace App\Repositories;

use Util;
use Exception;
use App\Models\BaseModel;
use App\Repositories\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository {
    use Sortable;

    public $sortBy = BaseModel::STAMP_CREATED;
    public $sortOrder = "asc";
    protected Model $model;

    public function all() {
        return ($this->model
            ->orderBy($this->sortBy, $this->sortOrder)
            ->get());
    }

    public function paginated(int $paginate) {
        return ($this->model
            ->orderBy($this->sortBy, $this->sortOrder)
            ->paginate($paginate));
    }

    public function create(array $arrParams) {
        $model = $this->model->newInstance();

        if (!isset($arrParams[$model->uuid()]))
            $arrParams[$model->uuid()] = Util::uuid();

        $model->fill($arrParams);
        $model->save();

        return ($model);
    }

    public function destroy($id) {
        return ($this->find($id)->delete());
    }

    /**
     * @param string|int $id
     * @param bool $bnFailure
     */
    public function find($id, bool $bnFailure = false) {
        if ($bnFailure) {
            if (is_int($id)) {
                return ($this->model->findOrFail($id));
            } else if (is_string($id)) {
                return ($this->model->where($this->model->uuid(), $id)->firstOrFail());
            } else {
                throw new Exception("Invalid Parameter.");
            }
        } else {
            if (is_int($id)) {
                return ($this->model->find($id));
            } else if (is_string($id)) {
                return ($this->model->where($this->model->uuid(), $id)->first());
            } else {
                throw new Exception("Invalid Parameter.");
            }
        }
    }

    public function update($model, array $arrParams) {
        $model->fill($arrParams);
        $model->save();

        return ($model);
    }

    public function applyMetaFilters(array $arrFilters, $query = null) {
        if (is_null($query)) {
            $query = $this->model->newQuery();
        }

        $availableMeta = $this->model->metaData;
        $modelFilters  = $availableMeta["filters"];
        $modelSearch   = $availableMeta["search"];
        $modelSort     = $availableMeta["sort"];

        if (!empty($arrFilters["filters"]) && is_array($arrFilters["filters"])) {
            [$query, $modelFilters] = $this->buildQueryWithMetaData($query, $arrFilters["filters"], $modelFilters);
        }

        if (!empty($arrFilters["search"]) && is_array($arrFilters["search"])) {
            [$query, $modelSearch] = $this->buildQueryWithMetaData($query, $arrFilters["search"], $modelSearch, true);
        }

        if (!empty($arrFilters["sort"]) && is_array($arrFilters["sort"])) {
            foreach ($arrFilters["sort"] as $field => $value) {
                if (!array_key_exists($field, $modelSort)) {
                    break;
                }

                $column = $modelSort[$field]["column"];

                if (isset($modelSort[$field]["relation_table"])) {
                    $column = $modelSort[$field]["relation_table"] . "." . $column;
                }

                $query = $query->orderBy($column, $value);

                break;
            }
        }

        $responseMetaData["filters"] = $this->updateAvailableMetaData($modelFilters, $query);
        $responseMetaData["search"] = array_keys($modelSearch);
        $responseMetaData["sort"] = array_keys($modelSort);

        return ([$query, $responseMetaData]);
    }

    private function buildQueryWithMetaData($query, array $arrData, array $modelData, bool $flag_like = false){
        foreach ($arrData as $field => $value) {
            if (!array_key_exists($field, $modelData)) {
                continue;
            }

            $column = $modelData[$field]["column"];

            if (isset($modelData[$field]["relation"])) {
                $relation = $modelData[$field]["relation"];
                $table =  $modelData[$field]["relation_table"];

                if (is_array($relation)) {
                    $relation = implode(".", $relation);
                    $query = $query->whereHas($relation, function ($query) use ($column, $value, $table, $flag_like) {
                        if ($flag_like) {
                            $query->where($table . "." . $column, "like", "%" . $value . "%");
                        } else {
                            if (is_array($value)) {
                                $query->whereIn($table . "." . $column, $value);
                            } else {
                                $query->where($table . "." . $column, $value);
                            }
                        }
                    });
                } else {
                    $query = $query->whereHas($relation, function ($query) use ($column, $value, $table, $flag_like) {
                        if ($flag_like) {
                            $query->where($table . "." . $column, "like", "%" . $value . "%");
                        } else {
                            if (is_array($value)) {
                                $query->whereIn($table . "." . $column, $value);
                            } else {
                                $query->where($table . "." . $column, $value);
                            }
                        }
                    });
                }
            } else {
                if ($flag_like) {
                    $query = $query->where($column,"like", "%" . $value . "%");
                } else {
                    if (is_array($value)) {
                        $query = $query->whereIn($column, $value);
                    } else {
                        $query = $query->where($column, $value);
                    }
                }
            }

            unset($modelData[$field]);
        }

        return ([$query, $modelData]);
    }

    private function updateAvailableMetaData(array $arrFilters, $query){
        $availableMetadata = [];
        $objRecords = $query->get();

        foreach ($arrFilters as $filter => $value) {
            $column = $value["column"];
            if (isset($value["relation"])) {
                $relation = $value["relation"];

                if (is_array($relation)) {
                    $relation = implode(".", $relation);
                }

                $availableMetadata[$filter] = array_values($objRecords->pluck($relation)->flatten()->pluck($column)->unique()->toArray());
            } else {
                $availableMetadata[$filter] = array_values($objRecords->pluck($column)->unique()->toArray());
            }
        }

        foreach ($availableMetadata as $key => $array) {
            $availableMetadata[$key] = array_values(array_filter($array, function ($val) {
                return $val !== null;
            }));
        }

        return ($availableMetadata);
    }
}
