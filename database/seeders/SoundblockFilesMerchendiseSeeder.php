<?php

namespace Database\Seeders;

use App\Helpers\Util;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Soundblock\{Collections\Collection, Files\File, Files\FileMerch};

class SoundblockFilesMerchendiseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();

        foreach (Collection::all() as $objCol) {
            $arrMerchFiles = File::whereHas("collections", function ($q) use ($objCol) {
                $q->where("soundblock_collections.collection_id", $objCol->collection_id);
            })->where("file_category", "merch")->get();

            foreach ($arrMerchFiles as $objFile) {
                $objMerch = new FileMerch();
                $objMerch->create([
                    "row_uuid"  => Util::uuid(),
                    "file_id"   => $objFile->file_id,
                    "file_uuid" => $objFile->file_uuid,
                    "file_sku"  => "4225-776-3234",
                ]);
            }
        }

        Model::reguard();
    }
}
