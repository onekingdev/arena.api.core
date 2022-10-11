<?php

namespace App\Repositories\Office;

use App\Repositories\BaseRepository;
use App\Models\{Core\Auth\AuthGroup, Users\User, Office\Contact as ContactModel};

class Contact extends BaseRepository {

    /**
     * @param ContactModel $contact
     * @return void
     */
    public function __construct(ContactModel $contact) {
        $this->model = $contact;
    }

    /**
     * @param User $user
     * @param array $arrFilters
     * @param array $arrParams
     * @return array
     */
    public function findAllByAccessUser(User $user, array $arrFilters, array $arrParams): array
    {
        $query = $this->model->whereHas("access_users", function ($query) use ($user, $arrFilters) {
            $query->where("office_contact_users.user_id", $user->user_id);
            foreach ($arrFilters as $key => $value) {
                $query->where("office_contact_users.{$key}", $value);
            }
            $query->select("office_contact.contact_uuid", "office_contact.contact_email", "office_contact.contact_subject");
        })->with(["access_users:flag_read,flag_archive,flag_delete"]);

        [$query, $availableMetaData] = $this->applyMetaFilters($arrParams, $query);

        return ([
            $query->get()->makeHidden(["contact_name_first", "contact_name_last", "contact_business", "contact_memo", "contact_phone", "contact_json", "contact_host", "contact_agent"]),
            $availableMetaData
        ]);
    }

    /**
     * @param AuthGroup $group
     * @param array $arrFilters
     * @param array $arrParams
     * @return array
     */
    public function findAllByAccessGroup(AuthGroup $group, array $arrFilters, array $arrParams): array
    {
        $query = $this->model->whereHas("access_groups", function ($query) use ($group, $arrFilters) {
            $query->where("office_contact_groups.group_id", $group->group_id);
            foreach ($arrFilters as $key => $value) {
                $query->where("office_contact_groups.{$key}", $value);
            }
            $query->select("office_contact.contact_uuid", "office_contact.contact_email", "office_contact.contact_subject");
        })->with(["access_users:flag_read,flag_archive,flag_delete"]);

        [$query, $availableMetaData] = $this->applyMetaFilters($arrParams, $query);

        return ([
            $query->get()->makeHidden(["contact_name_first", "contact_name_last", "contact_business", "contact_memo", "contact_phone", "contact_json", "contact_host", "contact_agent"]),
            $availableMetaData
        ]);
    }

    /**
     * @param ContactModel $contact
     * @param User $user
     * @param array $arrParams
     * @return ContactModel
     */
    public function updateAccessUser(ContactModel $contact, User $user, array $arrParams): ContactModel {
        $contact->access_users()->updateExistingPivot($user->user_id, $arrParams);
        return ($contact);
    }

    /**
     * @param ContactModel $contact
     * @param AuthGroup $group
     * @param array $arrParams
     * @return ContactModel
     */
    public function updateAccessGroup(ContactModel $contact, AuthGroup $group, array $arrParams): ContactModel {
        $contact->access_users()->updateExistingPivot($group->group_id, $arrParams);
        return ($contact);
    }
}
