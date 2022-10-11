<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\BaseModel;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Soundblock\Files\Directory;
use App\Models\Soundblock\Collections\Collection;

class SoundblockDirectorySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();

        $directories = [
            [
                //1
                "directory_uuid"     => Util::uuid(),
                "directory_category" => "Merch",
                "directory_name"     => "Panic",
                "directory_path"     => "Merch",
                "directory_sortby"   => "Merch/Panic",
            ],
            [
                //2
                "directory_uuid"     => Util::uuid(),
                "directory_category" => "Merch",
                "directory_name"     => "Taylor",
                "directory_path"     => "Merch",
                "directory_sortby"   => "Merch/Taylor",
            ],
            [
                //3
                "directory_uuid"     => Util::uuid(),
                "directory_category" => "Merch",
                "directory_name"     => "Taylor-Clone",
                "directory_path"     => "Merch",
                "directory_sortby"   => "Merch/Taylor-Clone",
            ],
            [
                //4
                "directory_uuid"     => Util::uuid(),
                "directory_category" => "Other",
                "directory_name"     => "Files",
                "directory_path"     => "Other",
                "directory_sortby"   => "Other/Files",
            ],
            [
                //5
                "directory_uuid"     => Util::uuid(),
                "directory_category" => "Merch",
                "directory_name"     => "My Album",
                "directory_path"     => "Merch",
                "directory_sortby"   => "Merch/My Album",
            ],
            [
                //6
                "directory_uuid"     => Util::uuid(),
                "directory_category" => "Merch",
                "directory_name"     => "New Me",
                "directory_path"     => "Merch",
                "directory_sortby"   => "Merch/New Me",
            ],
        ];

        foreach ($directories as $directory) {
            Directory::create($directory);
        }

        for ($i = 1; $i <= 2; $i++) {
            $objDir = Directory::find($i);
            $objCol = Collection::find($i);
            $objDir->collections()->attach(
                $objCol->collection_id, [
                "row_uuid"                  => Util::uuid(),
                "collection_uuid"           => $objCol->collection_uuid,
                "directory_uuid"            => $objDir->directory_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);
        }

        $objDir3 = Directory::find(3);
        $objCol3 = Collection::find(3);
        $objDir3->collections()->attach(
            $objCol3->collection_id, [
            "row_uuid"                  => Util::uuid(),
            "collection_uuid"           => $objCol3->collection_uuid,
            "directory_uuid"            => $objDir3->directory_uuid,
            BaseModel::STAMP_CREATED    => time(),
            BaseModel::STAMP_CREATED_BY => 1,
            BaseModel::STAMP_UPDATED    => time(),
            BaseModel::STAMP_UPDATED_BY => 1,
        ]);

        for ($i = 4; $i <= 6; $i++) {
            $objDir = Directory::find($i);
            $objCol = Collection::find($i);
            $objDir->collections()->attach(
                $objCol->collection_id, [
                "row_uuid"                  => Util::uuid(),
                "collection_uuid"           => $objCol->collection_uuid,
                "directory_uuid"            => $objDir->directory_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);
        }

        Model::reguard();
    }
}
