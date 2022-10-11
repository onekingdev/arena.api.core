<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\BaseModel;
use App\Services\Soundblock\Collection as CollectionService;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Soundblock\{Collections\Collection, Files\File, Track};

class SoundblockFilesMusicSeeder extends Seeder {
    /**
     * @var CollectionService
     */
    private CollectionService $collectionService;

    /**
     * SoundblockFilesMusicSeeder constructor.
     * @param CollectionService $collectionService
     */
    public function __construct(CollectionService $collectionService) {
        $this->collectionService = $collectionService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();

        foreach (Collection::all() as $objCol) {
            $arrMusicFiles = File::whereHas("collections", function ($q) use ($objCol) {
                $q->where("soundblock_collections.collection_id", $objCol->collection_id);
            })->where("file_category", "music")->get();

            $idx = 0;

            foreach ($arrMusicFiles as $objFile) {
                $idx++;
                $objFileMusic = new Track();
                $objFileMusic->row_uuid = Util::uuid();
                $objFileMusic->file_id = $objFile->file_id;
                $objFileMusic->file_uuid = $objFile->file_uuid;
                $objFileMusic->track_number = $idx;
                $objFileMusic->track_duration = rand(180, 300);
                $objFileMusic->track_isrc = $this->collectionService->generateIsrc($idx);
                $objFileMusic->save();
            }
        }

        Model::reguard();
    }
}
