<?php

namespace App\Services\Office;

use Auth;
use Util;
use Exception;
use App\Models\Office\Contact as ContactModel;
use App\Repositories\{Core\Auth\AuthGroup, Office\Contact as ContactRepository, User\User};

class Contact {

    /** @var ContactRepository */
    protected ContactRepository $contactRepo;
    /** @var User */
    protected User $userRepo;
    /** @var AuthGroup */
    protected AuthGroup $groupRepo;

    /**
     * @param ContactRepository $contactRepo
     * @param User $userRepo
     * @param AuthGroup $groupRepo
     * @return void
     */
    public function __construct(ContactRepository $contactRepo, User $userRepo, AuthGroup $groupRepo) {
        $this->contactRepo = $contactRepo;
        $this->userRepo = $userRepo;
        $this->groupRepo = $groupRepo;
    }

    /**
     * @param string|int $id
     * @param bool $bnFailure
     * @return ContactModel
     * @throws Exception
     */
    public function find($id, ?bool $bnFailure = true): ContactModel {
        return ($this->contactRepo->find($id, $bnFailure));
    }

    /**
     * @param string $uuid
     * @return ContactModel
     * @throws Exception
     */
    public function show(string $uuid) {
        $contact = $this->contactRepo->find($uuid);
        return ($contact->with(["access_users:office_contact_users.user_uuid,name_first,name_last,flag_read,flag_archive,flag_delete",
            "access_groups:office_contact_groups.group_uuid,group_name,group_memo,flag_read,flag_archive,flag_delete"])
                        ->first());
    }

    /**
     * @param array $arrParams
     * @return array
     * @throws Exception
     */
    public function getContactsByAccessUser(array $arrParams): array
    {
        if (isset($arrParams["user"])) {
            $accessUser = $this->userRepo->find($arrParams["user"], true);
            $filters = collect($arrParams)->only("flag_read", "flag_archive", "flag_delete")->toArray();
            [$contacts, $availableMetaData] = $this->contactRepo->findAllByAccessUser($accessUser, $filters, $arrParams);
        } else {
            $accessGroup = $this->groupRepo->find($arrParams["group"], true);
            $filters = collect($arrParams)->only("flag_read", "flag_archive", "flag_delete")->toArray();
            [$contacts, $availableMetaData] = $this->contactRepo->findAllByAccessGroup($accessGroup, $filters, $arrParams);
        }

        return ([$contacts, $availableMetaData]);
    }

    /**
     * @param array $arrParams
     * @return ContactModel
     * @throws Exception
     */
    public function createContact(array $arrParams): ContactModel {
        $fieldAliases = config("constant.office.contact.field_alias");
        $arrContact = [];
        foreach ($fieldAliases as $key => $value) {
            if (isset($arrParams[$key])) {
                $arrContact[$value] = $arrParams[$key];
            }
        }

        return ($this->create($arrContact));
    }

    /**
     * @param array $arrParams
     * @return ContactModel
     * @throws Exception
     */
    public function create(array $arrParams): ContactModel {
        $reqFields = ["contact_name_first", "contact_name_last", "contact_email"];
        if (!Util::array_keys_exists($reqFields, $arrParams))
            throw new Exception(sprintf("Required following fields %s", implode(",", $reqFields)));
        $user = Auth::guard("api")->user();
        if ($user) {
            $arrParams["user_id"] = $user->user_id;
            $arrParams["user_uuid"] = $user->user_uuid;
        }

        return ($this->contactRepo->create($arrParams));
    }

    /**
     * @param ContactModel $contact
     * @param array $arrParams
     * @return ContactModel
     * @throws Exception
     */
    public function updateAccess(ContactModel $contact, array $arrParams): ContactModel {
        if (isset($arrParams["user"])) {
            $user = $this->userRepo->find($arrParams["user"], true);
            $accessUserParams = collect($arrParams)->only("flag_read", "flag_archive", "flag_delete")->toArray();
            $contact = $this->contactRepo->updateAccessUser($contact, $user, $accessUserParams);
        }
        if (isset($arrParams["group"])) {
            $group = $this->groupRepo->find($arrParams["group"], true);
            $accessGroupParams = collect($arrParams)->only("flag_read", "flag_archive", "flag_delete")->toArray();
            $contact = $this->contactRepo->updateAccessGroup($contact, $group, $accessGroupParams);
        }

        return ($contact);
    }

    /**
     * @param ContactModel $contact
     * @param array $arrParams
     * @return ContactModel
     */
    public function update(ContactModel $contact, array $arrParams): ContactModel {
        return ($this->contactRepo->update($contact, $arrParams));
    }
}
