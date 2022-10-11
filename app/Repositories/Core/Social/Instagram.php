<?php

namespace App\Repositories\Core\Social;

use App\Repositories\BaseRepository;
use App\Models\Core\Social\Instagram as InstagramModel;
use Illuminate\Database\Eloquent\Collection;

class Instagram extends BaseRepository {
    /**
     * Instagram Repository constructor.
     * @param InstagramModel $instagram
     */
    public function __construct(InstagramModel $instagram) {
        $this->model = $instagram;
    }

    /**
     * @param int $count
     * @return mixed
     */
    public function getLatest(int $count): Collection {
        return ($this->model->orderBy("photo_epoch", "desc")->limit($count)->get());
    }

    public function getRandom(int $count, array $exceptions = []): Collection {
        return ($this->model->inRandomOrder()->whereNotIn("photo_id", $exceptions)->limit($count)->get());
    }

    public function getMixed(int $latestCount, int $randomCount) {
        $latest = $this->getLatest($latestCount);
        $arrLatestIds = $latest->pluck("photo_id")->toArray();
        $random = $this->getRandom($randomCount, $arrLatestIds);

        return ($latest->mergeRecursive($random));
    }
}