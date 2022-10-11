<?php

namespace App\Events\Common;

use Util;
use Exception;
use App\Models\Users\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Notification\Notification as NotificationModel;
use Illuminate\Broadcasting\{InteractsWithSockets, PrivateChannel};

class UserNotification implements ShouldBroadcast {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var array
     */
    public array $contents;
    /**
     * @var User
     */
    public User $receiver;
    /**
     * @var array
     */
    public array $appNames;
    /**
     * @var NotificationModel|null
     */
    private ?NotificationModel $notification;
    private array $notificationDetails;

    /**
     * Create a new event instance.
     * @param array $contents
     * @param User $receiver
     * @param array $appNames
     * @param NotificationModel|null $notification
     * @param array $notificationDetails
     * @throws \Exception
     */
    public function __construct(array $contents, User $receiver, array $appNames, ?NotificationModel $notification = null, array $notificationDetails = []) {
        if (!Util::array_keys_exists(["notification_name"], $contents))
            throw new Exception("Invalid Parameter.", 400);

        $this->contents = $contents;
        $this->receiver = $receiver;
        $this->appNames = $appNames;
        $this->notification = $notification;
        $this->notificationDetails = $notificationDetails;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        // e.g channel.app.soundblock.user.{{user_uuid}}
        /** @var array */
        $channels = [];

        foreach ($this->appNames as $appName) {
            array_push($channels, new PrivateChannel(sprintf("channel.%s.user.%s", strtolower($appName), $this->receiver->user_uuid)));
        }

        return ($channels);
    }

    public function broadcastAs() {
        return ("Notify.User." . $this->receiver->user_uuid);
    }

    public function broadcastWith() {
        if (is_object($this->notification)) {
            $this->contents = array_merge($this->notification->toArray(), $this->contents);
        }

        $this->contents = array_merge($this->contents, [
            "autoClose" => true,
            "showTime"  => 5000,
        ], $this->notificationDetails);

        return ($this->contents);
    }
}
