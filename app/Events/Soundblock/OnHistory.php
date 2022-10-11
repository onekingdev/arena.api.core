<?php

namespace App\Events\Soundblock;

use Log;
use Auth;
use Util;
use App\Models\Users\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\Soundblock\Collections\Collection;
use Illuminate\Broadcasting\InteractsWithSockets;

class OnHistory {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public $arrHistoryFiles;
    /**
     * @var string
     */
    public string $fileAction;

    /**
     * @var Collection
     */
    public Collection $objCollection;

    /**
     * @var string
     */
    public string $category;

    /**
     * @var User|null
     */
    public ?User $objUser;

    /**
     * Create a new event instance.
     *
     * @param Collection $objCollection
     * @param string $fileAction
     * @param null $arrHistoryFiles
     * @param User|null $objUser
     * @param string $category
     */
    public function __construct(Collection $objCollection, $fileAction = "Created", $arrHistoryFiles = null, ?User $objUser = null, string $category = "Music") {
        $this->arrHistoryFiles = $arrHistoryFiles;
        $this->objCollection = $objCollection;
        $this->fileAction = Util::ucfLabel($fileAction);
        $this->category = Util::ucfLabel($category);

        if ($objUser) {
            $this->objUser = $objUser;
        } else {
            $this->objUser = Auth::user();
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return new PrivateChannel('channel-name');
    }
}
