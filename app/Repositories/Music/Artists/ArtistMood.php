<?php

namespace App\Repositories\Music\Artists;

use Util;
use Constant;
use App\Models\Music\Mood;
use App\Repositories\BaseRepository;
use App\Models\Music\Artist\Artist as ArtistModel;
use App\Models\Music\Artist\ArtistMood as ArtistMoodModel;

class ArtistMood extends BaseRepository {
    /**
     * @var Mood
     */
    private Mood $moodModel;

    /**
     * ArtistMood constructor.
     * @param ArtistMoodModel $model
     * @param Mood $moodModel
     */
    public function __construct(ArtistMoodModel $model, Mood $moodModel) {
        $this->model = $model;
        $this->moodModel = $moodModel;
    }

    /**
     * @param ArtistModel $artist
     * @param array $arrMoods
     * @return ArtistModel
     * @throws \Exception
     */
    public function createMultiple(ArtistModel $artist, array $arrMoods) {
        foreach ($arrMoods as $mood) {
            $objMood = $this->moodModel->where("mood_uuid", $mood)->first();

            if (is_null($objMood)) {
                throw new \Exception("Mood Not Found.");
            }

            $artist->moods()->attach($objMood->mood_id, [
                "row_uuid"     => Util::uuid(),
                "artist_uuid"  => $artist->artist_uuid,
                "mood_uuid"    => $objMood->mood_uuid,
                "stamp_epoch"  => time(),
                "stamp_date"   => time(),
                "stamp_time"   => time(),
                "stamp_source" => Constant::ARENA_SOURCE,
            ]);
        }

        return $artist;
    }
}
