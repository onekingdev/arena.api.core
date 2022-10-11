<?php

namespace Database\Seeders;

use App\Helpers\Util;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;
use App\Models\Soundblock\{Files\File, Files\FileVideo, Collections\Collection};

class SoundblockFilesVideoSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();
        $arrVideoFiles = File::where("file_category", "video")->get();
        foreach ($arrVideoFiles as $objFile) {
            $objCol = $objFile->collections()->orderBy("collection_id", "desc")->first();
            $arrMusicFiles = File::whereHas("collections", function ($q) use ($objCol) {
                $q->where("soundblock_collections_files.collection_id", $objCol->collection_id);
            })->where("file_category", "music")->get();
            $objFileVideo = new FileVideo();
            $objMusicFile = $arrMusicFiles->random();
            $arrVideoFiles = $arrMusicFiles->reject(function ($item) use ($objMusicFile) {
                return ($item->file_id == $objMusicFile->file_id);
            });
            $objFileVideo->create([
                "row_uuid"   => Util::uuid(),
                "file_id"    => $objFile->file_id,
                "file_uuid"  => $objFile->file_uuid,
                "music_id"   => $objMusicFile->file_id,
                "music_uuid" => $objMusicFile->file_uuid,
                "file_isrc"  => "NOX001212345",
            ]);
        }

        Model::reguard();
    }
}
