<?php

namespace Database\Seeders;

use App\Helpers\Util;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use App\Models\Soundblock\{Files\File, Files\FileOther, Collections\Collection};

class SoundblockFilesOtherSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();

        foreach (Collection::all() as $objCol) {
            $arrOtherFiles = File::whereHas("collections", function ($q) use ($objCol) {
                $q->where("soundblock_collections.collection_id", $objCol->collection_id);
            })->where("file_category", "other")->get();

            foreach ($arrOtherFiles as $objFile) {
                $objOther = new FileOther();
                $objOther->create([
                    "row_uuid"  => Util::uuid(),
                    "file_id"   => $objFile->file_id,
                    "file_uuid" => $objFile->file_uuid,
                ]);
            }
        }

        Model::reguard();
    }
}
