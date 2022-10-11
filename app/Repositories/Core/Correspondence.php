<?php

namespace App\Repositories\Core;

use App\Models\BaseModel;
use App\Models\Core\Correspondence as CorrespondenceModel;
use App\Repositories\BaseRepository;

class Correspondence extends BaseRepository {
    /**
     * CorrespondenceRepository constructor.
     * @param CorrespondenceModel $correspondence
     */
    public function __construct(CorrespondenceModel $correspondence){
        $this->model = $correspondence;
    }

    /**
     * @param int $per_page
     * @param array $arrFilters
     * @return array
     */
    public function findAll(int $per_page, array $arrFilters){
        $query = $this->model->newQuery()
            ->with("app")
            ->join("core_apps", "core_correspondence.app_id", "=", "core_apps.app_id")
            ->leftJoin("users_contact_emails", "users_contact_emails.row_id", "core_correspondence.email_id")
            ->select("core_correspondence.*", \DB::raw("IFNULL(core_correspondence.email_address, users_contact_emails.user_auth_email) as email_address"));

        if (isset($arrFilters["date_start"])) {
            $query = $query->whereDate("core_correspondence." . BaseModel::CREATED_AT, ">=", $arrFilters["date_start"]);
        }

        if (isset($arrFilters["date_end"])) {
            $query = $query->whereDate("core_correspondence." . BaseModel::CREATED_AT, "<=", $arrFilters["date_end"]);
        }

        if (!array_key_exists("sort", $arrFilters)) {
            $query = $query->orderBy(BaseModel::CREATED_AT, "desc");
        }

        [$query, $availableMetaData] = $this->applyMetaFilters($arrFilters, $query);

        $objCorrespondences = $query->paginate($per_page);

        return ([$objCorrespondences, $availableMetaData]);
    }

    /**
     * @param string $correspondenceUUID
     * @return mixed
     */
    public function findByUuid(string $correspondenceUUID){
        $objCorrespondence = $this->model->leftJoin("users_contact_emails", "users_contact_emails.row_id", "core_correspondence.email_id")
            ->select("core_correspondence.*", \DB::raw("IFNULL(core_correspondence.email_address, users_contact_emails.user_auth_email) as email_address"))
            ->where("correspondence_uuid", $correspondenceUUID)->first();

        return ($objCorrespondence);
    }

    public function checkDuplicate(string $strEmail, string $strSubject, string $strJson) {
        return $this->model->leftJoin("users_contact_emails", "users_contact_emails.row_id", "core_correspondence.email_id")
            ->where(\DB::raw("IFNULL(core_correspondence.email_address, users_contact_emails.user_auth_email)"), $strEmail)
            ->where("email_subject", $strSubject)->where("email_json", $strJson)->exists();
    }

    /**
     * @param array $insertData
     * @return mixed
     */
    public function create(array $insertData){
        $objCorrespondence = $this->model->create($insertData);

        return ($objCorrespondence);
    }

    /**
     * @param string $correspondenceUUID
     * @param array $updateData
     * @return mixed
     */
    public function updateByUuid(string $correspondenceUUID, array $updateData){
        $objCorrespondence = $this->model->where("correspondence_uuid", $correspondenceUUID)->update($updateData);

        return ($objCorrespondence);
    }
}
