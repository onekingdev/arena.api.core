<?php

namespace App\Repositories\Common;

use Util;
use Auth;
use Client;
use Exception;
use App\Models\{
    Core\App,
    BaseModel,
    Users\User,
    Notification\Notification as NotificationModel,
    Notification\NotificationSetting,
};
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Common\App as AppRepository;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class Notification extends BaseRepository {
    private \App\Repositories\Common\App $appRepo;

    /**
     * @param NotificationModel $notification
     * @return void
     */
    public function __construct(NotificationModel $notification, AppRepository $appRepo) {
        $this->model = $notification;
        $this->appRepo = $appRepo;
    }

    /**
     * @param User $user
     * @param array $reqParams
     * @param bool $isPaginator
     * @return \Illuminate\Contracts\Pagination\Paginator/SupportCollection
     */
    public function findAllByUser(User $user, array $reqParams = [], bool $isPaginator = true) {
        /** @var \Illuminate\Database\Query\Builder */
        $queryBuilder = $user->notifications();
        $objCurrentApp = Client::app();
        $objUserSetting = $user->notificationSettings()->where("app_id", $objCurrentApp->app_id)->firstOrFail();

        if (isset($reqParams["notification_state"])) {
            $queryBuilder->whereRaw("lower(notifications_users.notification_state) = ?", strtolower($reqParams["notification_state"]));
        } else {
            $queryBuilder->whereNotIn("notifications_users.notification_state", ["archived", "deleted"]);
        }

        if (isset($reqParams["apps"])) {
            $queryBuilder->whereHas("app", function (Builder $where) use ($reqParams) {
                $apps = explode(",", $reqParams["apps"]);

                foreach ($apps as $app) {
                    $where->orWhere("app_name", $app);
                }
            });
        } else {
            $queryBuilder->whereHas("app", function ($query) use ($objCurrentApp, $objUserSetting) {
                $query = $query->where("core_apps.app_id", $objCurrentApp->app_id);

                $allowedApps = $this->getAllowedAppsInstances($objUserSetting);

                foreach ($allowedApps as $objApp) {
                    if ($objApp->app_id !== $objCurrentApp->app_id) {
                        $query = $query->orWhere("core_apps.app_id", $objApp->app_id);
                    }
                }
            });
        }

        if ($isPaginator) {
            if (isset($reqParams["per_page"])) {
                $perPage = $reqParams["per_page"];
            } else {
                $perPage = config("constant.notification.setting.per_page");
            }

            $arrNotis = $queryBuilder->wherePivot("flag_candelete", true)->orderBy(BaseModel::STAMP_CREATED, "desc")
                                     ->paginate($perPage);
        } else {
            $arrNotis = $queryBuilder->wherePivot("flag_candelete", true)->orderBy(BaseModel::STAMP_CREATED, "desc")
                                     ->get();
        }

        return ($arrNotis);
    }

    /**
     * @param NotificationSetting $objSetting
     * @return App[]
     */
    public function getAllowedAppsInstances(NotificationSetting $objSetting): array {
        $arrayAllowedApps = [];
        $apps = $this->appRepo->findAll();

        foreach ($apps as $app) {
            if (isset($objSetting["flag_" . $app->app_name]) && $objSetting["flag_" . $app->app_name] == true) {
                $arrayAllowedApps[] = $app;
            }
        }

        return $arrayAllowedApps;
    }

    /**
     * @param string $status
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findAllByStatus(string $status, User $user): \Illuminate\Database\Eloquent\Collection {
        return ($user->notifications()
            ->whereRaw("lower(notifications_users.notification_state) = ?", strtolower($status))->get());
    }

    /**
     * @param array $arrParams
     * @return NotificationModel
     * @throws Exception
     */
    public function createModel(array $arrParams) {
        $model = new NotificationModel;
        if (!isset($arrParams[$model->uuid()])) {
            $arrParams[$model->uuid()] = Util::uuid();
        }
        if (!Util::array_keys_exists(["app_id", "app_uuid", "notification_name"], $arrParams)) {
            throw new Exception("Invalid Paramter", 400);
        }
        if (!isset($arrParams["notification_memo"])) {
            $arrParams["notification_memo"] = sprintf("Notification (%s)", $arrParams["notification_name"]);
        }
        if (!isset($arrParams["notification_action"])) {
            $arrParams["notification_action"] = "Default Action";
        }

        $model->fill($arrParams);
        $model->save();

        return ($model);
    }

    /**
     * @param NotificationModel $notification
     * @param User $user
     * @param array|null $arrParams
     * @return NotificationModel
     * @throws Exception
     */
    public function attachUser(NotificationModel $notification, User $user, ?array $arrParams = null) {
        $arrReqProperty = ["notification_state", "flag_canarchive", "flag_candelete", "flag_email"];
        if (is_null($arrParams)) {
            $arrParams = [
                "notification_state" => "unread",
                "flag_canarchive"    => true,
                "flag_candelete"     => true,
                "flag_email"         => false,
            ];
        } else if (!Util::array_keys_exists($arrReqProperty, $arrParams)) {
            abort(400, sprintf("Following properties (%s) are required.", implode(",", $arrReqProperty)));
        }

        $notification->users()->attach($user->user_id, [
            "row_uuid"                  => Util::uuid(),
            "notification_uuid"         => $notification->notification_uuid,
            "user_uuid"                 => $user->user_uuid,
            "notification_state"        => $arrParams["notification_state"],
            "flag_canarchive"           => $arrParams["flag_canarchive"],
            "flag_candelete"            => $arrParams["flag_candelete"],
            "flag_email"                => $arrParams["flag_email"],
            BaseModel::STAMP_CREATED    => Util::current_time(),
            BaseModel::STAMP_CREATED_BY => $user->user_id,
            BaseModel::STAMP_UPDATED    => Util::current_time(),
            BaseModel::STAMP_UPDATED_BY => $user->user_id,
        ]);

        return ($user->notifications()->find($notification->notification_id));
    }

    /**
     * @param NotificationModel $notification
     * @param array $arrParams
     * @param User $user
     * @return object
     */
    public function updateUserNotification(User $user, NotificationModel $notification, array $arrParams) {
        $arrStamp = [
            BaseModel::STAMP_UPDATED    => time(),
            BaseModel::STAMP_UPDATED_BY => $user->user_id,
        ];
        $arrParams = array_merge($arrParams, $arrStamp);

        return ($user->notifications()->updateExistingPivot($notification->notification_id, $arrParams));
    }

    /**
     * @param User $objUser
     * @param array|null $notifications
     *
     * @return int
     */
    public function archive(User $objUser, ?array $notifications = null): int {
        $objQuery = $objUser->notifications()->newPivotStatement()->where("flag_canarchive", true)
            ->where("user_id", $objUser->user_id)->whereNull(BaseModel::STAMP_DELETED);

        if (is_array($notifications)) {
            $objQuery = $objQuery->whereIn("notification_uuid", $notifications);
        }

        return $objQuery->update([
            "notification_state"         => "archived",
            BaseModel::UPDATED_AT       => now(),
            BaseModel::STAMP_UPDATED    => time(),
            BaseModel::STAMP_UPDATED_BY => Auth::id(),
        ]);
    }

    /**
     * @param User $objUser
     * @param array|null $notifications
     * @return int
     */
    public function delete(User $objUser, ?array $notifications = null): int {
        $objQuery = $objUser->notifications()->newPivotStatement()->where("user_id", $objUser->user_id)
            ->where("flag_candelete", true)->whereNull(BaseModel::STAMP_DELETED);

        if (is_array($notifications)) {
            $objQuery = $objQuery->whereIn("notification_uuid", $notifications);
        }

        return $objQuery->update([
            BaseModel::DELETED_AT       => now(),
            BaseModel::STAMP_DELETED    => time(),
            BaseModel::STAMP_DELETED_BY => Auth::id(),
        ]);
    }
}
