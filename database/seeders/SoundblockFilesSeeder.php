<?php

namespace Database\Seeders;

use App\Helpers\Constant;
use App\Helpers\Util;
use App\Models\BaseModel;
use App\Services\Soundblock\Collection as CollectionService;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Soundblock\{Files\File, Collections\Collection, Collections\CollectionHistory, Files\FileHistory};
use Illuminate\Support\Str;

class SoundblockFilesSeeder extends Seeder {
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

        $isrcIncrement = 0;

        $files = [
            [   //1,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Stan.mp3",
                "file_size"     => rand(10000, 500000),
                "file_category" => "music",
                "file_title"    => "Stan",
                "file_path"     => "Music",
                "file_sortby"   => "Music/Stan.mp3",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //2,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Marshal Mathers.mp3",
                "file_size"     => rand(10000, 500000),
                "file_category" => "music",
                "file_title"    => "Marshal",
                "file_path"     => "Music",
                "file_sortby"   => "Music/Marshal Mathers.mp3",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //3,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "I'm Back.mp3",
                "file_size"     => rand(10000, 500000),
                "file_category" => "music",
                "file_title"    => "I'm Back",
                "file_path"     => "Music",
                "file_sortby"   => "Music/I'm Back.mp3",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //4,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "back.mp4",
                "file_size"     => rand(10000, 500000),
                "file_category" => "video",
                "file_title"    => "back",
                "file_path"     => "Video",
                "file_sortby"   => "Video/back.mp4",//3
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //5,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "video1.mp4",
                "file_size"     => rand(10000, 500000),
                "file_category" => "video",
                "file_title"    => "video1",
                "file_path"     => "Video",
                "file_sortby"   => "Video/back.mp4",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //6,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "video2.mp4",
                "file_size"     => rand(10000, 500000),
                "file_category" => "video",
                "file_title"    => "video2",
                "file_path"     => "Video",
                "file_sortby"   => "Video/video2.mp4",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //7,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "video2.mp4",
                "file_size"     => rand(10000, 500000),
                "file_category" => "video",
                "file_title"    => "video2",
                "file_path"     => "Video",
                "file_sortby"   => "Video/marshal.mp4", //2
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //8,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "video3.mp4",
                "file_size"     => rand(10000, 500000),
                "file_category" => "video",
                "file_title"    => "video3",
                "file_path"     => "Video",
                "file_sortby"   => "Video/video3.mp4",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //9,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Panic.ai",
                "file_size"     => rand(10000, 500000),
                "file_category" => "merch",
                "file_title"    => "Panic",
                "file_path"     => "Merch",
                "file_sortby"   => "Merch/Panic.ai",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //10,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Poster.ai",
                "file_size"     => rand(10000, 500000),
                "file_category" => "merch",
                "file_title"    => "Panic",
                "file_path"     => "Merch/Panic",
                "file_sortby"   => "Merch/Panic" . Constant::Separator . "Poster.ai",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //11,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "22.psd",
                "file_size"     => rand(10000, 500000),
                "file_category" => "merch",
                "file_title"    => "22",
                "file_path"     => "Merch",
                "file_sortby"   => "Merch/22.psd",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //12,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "22.psd",
                "file_size"     => rand(10000, 500000),
                "file_category" => "merch",
                "file_path"     => "Merch/Panic",
                "file_sortby"   => "Merch/Panic" . Constant::Separator . "22.psd",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //13,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Me!.psd",
                "file_size"     => rand(10000, 500000),
                "file_category" => "merch",
                "file_title"    => "merch",
                "file_path"     => "Merch",
                "file_sortby"   => "Merch/Me!.psd",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //14,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Me!.psd",
                "file_size"     => rand(10000, 500000),
                "file_category" => "merch",
                "file_title"    => "merch",
                "file_path"     => "Merch/Taylor",
                "file_sortby"   => "Merch/Taylor" . Constant::Separator . "Me!.psd",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //15,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Style.psd",
                "file_size"     => rand(10000, 500000),
                "file_category" => "merch",
                "file_title"    => "Style",
                "file_path"     => "Merch/Taylor",
                "file_sortby"   => "Merch/Taylor" . Constant::Separator . "Style.psd",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //16,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Shake_it_off.ai",
                "file_size"     => rand(10000, 500000),
                "file_category" => "merch",
                "file_title"    => "Shake_it_off",
                "file_path"     => "Merch/Taylor",
                "file_sortby"   => "Merch/Taylor" . Constant::Separator . "Shake_it_off.ai",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //17
                "file_uuid"     => Util::uuid(),
                "file_name"     => "file-1.doc",
                "file_size"     => rand(10000, 500000),
                "file_category" => "other",
                "file_title"    => "file-1",
                "file_path"     => "Other",
                "file_sortby"   => "Other/file-1.doc",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //18
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Files-2.doc",
                "file_size"     => rand(10000, 500000),
                "file_category" => "other",
                "file_title"    => "Files-2",
                "file_path"     => "Other",
                "file_sortby"   => "Other/Files-2.doc",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //19
                "file_uuid"     => Util::uuid(),
                "file_name"     => "files-4.docx",
                "file_size"     => rand(10000, 500000),
                "file_category" => "other",
                "file_title"    => "files-4",
                "file_path"     => "Other",
                "file_sortby"   => "Other/files-4.docx",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
        ];

        $swhiteFiles = [
            [   //,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Old Town Road.mp3",
                "file_size"     => rand(10000, 500000),
                "file_category" => "music",
                "file_title"    => "Old Town Road",
                "file_path"     => "Music",
                "file_sortby"   => "Music/Old Town Road.mp3",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Don't Start Now.mp3",
                "file_size"     => rand(10000, 500000),
                "file_category" => "music",
                "file_title"    => "Don't Start Now",
                "file_path"     => "Music",
                "file_sortby"   => "Music/Don't Start Now.mp3",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Lose you to love me.mp3",
                "file_size"     => rand(10000, 500000),
                "file_category" => "music",
                "file_title"    => "Lose You To Love Me",
                "file_path"     => "Music",
                "file_sortby"   => "Music/Lose you to love me.mp3",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],

            [   //,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Old Town Road.mp4",
                "file_size"     => rand(10000, 500000),
                "file_category" => "video",
                "file_title"    => "Old Town Road",
                "file_path"     => "Video",
                "file_sortby"   => "Video/Old town road.mp4",//
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Don't Start Now.mp4",
                "file_size"     => rand(10000, 500000),
                "file_category" => "video",
                "file_title"    => "Don't Start Now",
                "file_path"     => "Video",
                "file_sortby"   => "Video/Old town road.mp4",//
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Lose you to love me.mp4",
                "file_size"     => rand(10000, 500000),
                "file_category" => "video",
                "file_title"    => "Lose you to love me",
                "file_path"     => "Video",
                "file_sortby"   => "Video/Lose you to love me.mp4",//
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Lose you.ai",
                "file_size"     => rand(10000, 500000),
                "file_category" => "merch",
                "file_title"    => "Panic",
                "file_path"     => "Merch",
                "file_sortby"   => "Merch/Lose you.ai",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Old Town Road.ai",
                "file_size"     => rand(10000, 500000),
                "file_category" => "merch",
                "file_title"    => "Old Town Road",
                "file_path"     => "Merch",
                "file_sortby"   => "Merch/Old Town Road.ai",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //19
                "file_uuid"     => Util::uuid(),
                "file_name"     => "description.doc",
                "file_size"     => rand(10000, 500000),
                "file_category" => "other",
                "file_title"    => "description",
                "file_path"     => "Other",
                "file_sortby"   => "Other/description.doc",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
        ];

        $col2Files = [
            [   //1,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Future Nostalgia.mp3",
                "file_size"     => rand(10000, 500000),
                "file_category" => "music",
                "file_title"    => "Future Nostalgia",
                "file_path"     => "Music",
                "file_sortby"   => "Music/Future Nostalgia.mp3",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //2,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Future Nostalgia.mp4",
                "file_size"     => rand(10000, 500000),
                "file_category" => "video",
                "file_title"    => "Future Nostalgia",
                "file_path"     => "Video",
                "file_sortby"   => "Video/Future Nostalgia.mp4",//3
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //3,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "album.psd",
                "file_size"     => rand(10000, 500000),
                "file_category" => "merch",
                "file_title"    => "album",
                "file_path"     => "Merch",
                "file_sortby"   => "Merch/album.psd",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //4,
                "file_uuid"     => Util::uuid(),
                "file_name"     => "album-calm.psd",
                "file_size"     => rand(10000, 500000),
                "file_category" => "merch",
                "file_title"    => "album-calm",
                "file_path"     => "Merch",
                "file_sortby"   => "Merch/album-calm.psd",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //5
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Description.doc",
                "file_size"     => rand(10000, 500000),
                "file_category" => "other",
                "file_title"    => "Description",
                "file_path"     => "Other",
                "file_sortby"   => "Other/Description.doc",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
        ];

        $col7Files = [
            [
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Local Honey.mp3",
                "file_size"     => rand(10000, 500000),
                "file_category" => "music",
                "file_title"    => "Local Honey",
                "file_path"     => "Music",
                "file_sortby"   => "Music/Local Honey.mp3",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Local Honey.mp4",
                "file_size"     => rand(10000, 500000),
                "file_category" => "video",
                "file_title"    => "Local Honey Video",
                "file_path"     => "Video",
                "file_sortby"   => "Video/Local Honey.mp4",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [
                "file_uuid"     => Util::uuid(),
                "file_name"     => "The Slow Rush.ai",
                "file_size"     => rand(10000, 500000),
                "file_category" => "merch",
                "file_title"    => "The_Slow_Rush",
                "file_path"     => "Merch",
                "file_sortby"   => "Merch/The Slow Rush.ai",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Dec-REC.doc",
                "file_size"     => rand(10000, 500000),
                "file_category" => "other",
                "file_title"    => "Description",
                "file_path"     => "Other",
                "file_sortby"   => "Other/Dec-REC.doc",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
        ];

        $col8Files = [
            [
                "file_uuid"     => Util::uuid(),
                "file_name"     => "We're new again.mp3",
                "file_size"     => rand(10000, 500000),
                "file_category" => "music",
                "file_title"    => "2020 We're new again.",
                "file_path"     => "Music",
                "file_sortby"   => "Music/We're new again.mp3",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Again.mp4",
                "file_size"     => rand(10000, 500000),
                "file_category" => "video",
                "file_title"    => "Meet again",
                "file_path"     => "Video",
                "file_sortby"   => "Video/Again.mp4",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [
                "file_uuid"     => Util::uuid(),
                "file_name"     => "The Slow Rush.psd",
                "file_size"     => rand(10000, 500000),
                "file_category" => "merch",
                "file_title"    => "The_Slow_Rush",
                "file_path"     => "Merch",
                "file_sortby"   => "Merch/The Slow Rush.psd",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Dec-REC.doc",
                "file_size"     => rand(10000, 500000),
                "file_category" => "other",
                "file_title"    => "Description",
                "file_path"     => "Other",
                "file_sortby"   => "Other/Dec-REC.doc",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
        ];

        $col9Files = [
            [
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Nevermind.mp3",
                "file_size"     => rand(10000, 500000),
                "file_title"    => "Nevermin",
                "file_category" => "music",
                "file_path"     => "Music",
                "file_sortby"   => "Music/Nevermind.mp3",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Again.mp4",
                "file_size"     => rand(10000, 500000),
                "file_category" => "video",
                "file_title"    => "Meet again",
                "file_path"     => "Video",
                "file_sortby"   => "Video/Again.mp4",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [
                "file_uuid"     => Util::uuid(),
                "file_name"     => "The Slow Rush.psd",
                "file_size"     => rand(10000, 500000),
                "file_category" => "merch",
                "file_title"    => "The_Slow_Rush",
                "file_path"     => "Merch",
                "file_sortby"   => "Merch/The Slow Rush.psd",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Dec-REC.doc",
                "file_size"     => rand(10000, 500000),
                "file_category" => "other",
                "file_title"    => "Description",
                "file_path"     => "Other",
                "file_sortby"   => "Other/Dec-REC.doc",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
        ];

        $col10Files = [
            [
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Suddenly.mp3",
                "file_size"     => rand(10000, 500000),
                "file_title"    => "Suddely",
                "file_category" => "music",
                "file_path"     => "Music",
                "file_sortby"   => "Music/Suddenly.mp3",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Abbey Road.mp4",
                "file_size"     => rand(10000, 500000),
                "file_category" => "video",
                "file_title"    => "Abbey Road",
                "file_path"     => "Video",
                "file_sortby"   => "Video/Abbey Road.mp4",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Abbey Road.psd",
                "file_size"     => rand(10000, 500000),
                "file_category" => "merch",
                "file_title"    => "Abbey_Road",
                "file_path"     => "Merch",
                "file_sortby"   => "Merch/Abbey Road.psd",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [
                "file_uuid"     => Util::uuid(),
                "file_name"     => "Abbey.docx",
                "file_size"     => rand(10000, 500000),
                "file_category" => "other",
                "file_title"    => "Description",
                "file_path"     => "Other",
                "file_sortby"   => "Other/Abbey.docx",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
        ];

        $extra4Files = [
            [   //22
                "file_uuid"     => Util::uuid(),
                "file_name"     => "special.mp3",
                "file_size"     => rand(10000, 500000),
                "file_category" => "music",
                "file_title"    => "Everyone Like",
                "file_path"     => "Music",
                "file_sortby"   => "Music/special.mp3",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //23
                "file_uuid"     => Util::uuid(),
                "file_name"     => "special-1.mp3",
                "file_size"     => rand(10000, 500000),
                "file_category" => "music",
                "file_title"    => "Specialty",
                "file_path"     => "Music",
                "file_sortby"   => "Music/sepcial-1.mp3",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
        ];

        $extra6Files = [
            [   //24
                "file_uuid"     => Util::uuid(),
                "file_name"     => "special-video.mp4",
                "file_size"     => rand(10000, 500000),
                "file_category" => "video",
                "file_title"    => "Multiple",
                "file_path"     => "Video",
                "file_sortby"   => "Video/special-video.mp4",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
            [   //25
                "file_uuid"     => Util::uuid(),
                "file_name"     => "special-image.ai",
                "file_size"     => rand(10000, 500000),
                "file_category" => "video",
                "file_title"    => "Multiple",
                "file_path"     => "Video",
                "file_sortby"   => "Video/special-video-1.mp4",
                "file_md5"      => md5(time() . rand(1000, 1000000)),
            ],
        ];

        $originFiles = collect();
        $historySize = 0;
        $objCol3 = Collection::find(3);

        $intTrack = 0;
        foreach ($files as $file) {
            $objFile = File::create($file);
            $category = $objFile->file_category;
            $arrSubParams = [];
            switch ($category) {
                case "music" :
                {
                    $intTrack++;
                    $arrSubParams = [
                        "row_uuid"      => Util::uuid(),
                        "file_id"       => $objFile->file_id,
                        "file_uuid"     => $objFile->file_uuid,
                        "file_track"    => $intTrack,
                        "file_duration" => rand(180, 300),
                        "file_isrc"     => $this->collectionService->generateIsrc($isrcIncrement),
                    ];
                    $objFile->music()->create($arrSubParams);
                    $isrcIncrement++;
                    break;
                }
                case "video" :
                {
                    break;
                }
                case "merch" :
                {
                    $arrSubParams = [
                        "row_uuid"  => Util::uuid(),
                        "file_id"   => $objFile->file_id,
                        "file_uuid" => $objFile->file_uuid,
                        "file_sku"  => "4225-776-3234",
                    ];
                    $objFile->merch()->create($arrSubParams);
                    break;
                }
                case "other" :
                {
                    $arrSubParams = [
                        "row_uuid"  => Util::uuid(),
                        "file_id"   => $objFile->file_id,
                        "file_uuid" => $objFile->file_uuid,
                    ];
                    $objFile->other()->create($arrSubParams);
                    break;
                }
            }
            $originFiles->push($objFile);
            $historySize += $objFile->file_size;
            $objFile->collections()->attach(
                $objCol3->collection_id, [
                "row_uuid"                  => Util::uuid(),
                "file_uuid"                 => $objFile->file_uuid,
                "collection_uuid"           => $objCol3->collection_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);
            FileHistory::create([
                "row_uuid"                  => Util::uuid(),
                "collection_id"             => $objCol3->collection_id,
                "collection_uuid"           => $objCol3->collection_uuid,
                "file_id"                   => $objFile->file_id,
                "file_uuid"                 => $objFile->file_uuid,
                "file_action"               => "Created",
                "file_category"             => $objFile->file_category,
                "file_memo"                 => "File( " . $objFile->file_uuid . " )",
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);

        }
        CollectionHistory::create([
            "history_uuid"              => Util::uuid(),
            "collection_id"             => $objCol3->collection_id,
            "collection_uuid"           => $objCol3->collection_uuid,
            "history_category"          => "Multiple",
            "file_action"               => "Created",
            "history_size"              => $historySize,
            "history_comment"           => "Music( " . Str::random() . " )",
            BaseModel::STAMP_CREATED    => time(),
            BaseModel::STAMP_UPDATED    => time(),
            BaseModel::STAMP_CREATED_BY => 3,
            BaseModel::STAMP_UPDATED_BY => 3,
        ]);


        $whiteCol = Collection::find(1);
        $intTrack = 0;
        foreach ($swhiteFiles as $file) {
            $objFile = File::create($file);
            $arrSubParams = [];
            $category = $objFile->file_category;
            switch ($category) {
                case "music" :
                {
                    $intTrack++;
                    $arrSubParams = [
                        "row_uuid"      => Util::uuid(),
                        "file_id"       => $objFile->file_id,
                        "file_uuid"     => $objFile->file_uuid,
                        "file_track"    => $intTrack,
                        "file_duration" => rand(180, 300),
                        "file_isrc"     => $this->collectionService->generateIsrc($isrcIncrement),
                    ];
                    $objFile->music()->create($arrSubParams);
                    $isrcIncrement++;
                    break;
                }
                case "video" :
                {
                    break;
                }
                case "merch" :
                {
                    $arrSubParams = [
                        "row_uuid"  => Util::uuid(),
                        "file_id"   => $objFile->file_id,
                        "file_uuid" => $objFile->file_uuid,
                        "file_sku"  => "4225-776-3234",
                    ];
                    $objFile->merch()->create($arrSubParams);
                    break;
                }
                case "other" :
                {
                    $arrSubParams = [
                        "row_uuid"  => Util::uuid(),
                        "file_id"   => $objFile->file_id,
                        "file_uuid" => $objFile->file_uuid,
                    ];
                    $objFile->other()->create($arrSubParams);
                    break;
                }
            }

            $historySize += $objFile->file_size;
            $objFile->collections()->attach(
                $whiteCol->collection_id, [
                "row_uuid"                  => Util::uuid(),
                "file_uuid"                 => $objFile->file_uuid,
                "collection_uuid"           => $whiteCol->collection_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);

            FileHistory::create([
                "row_uuid"                  => Util::uuid(),
                "collection_id"             => $whiteCol->collection_id,
                "collection_uuid"           => $whiteCol->collection_uuid,
                "file_id"                   => $objFile->file_id,
                "file_uuid"                 => $objFile->file_uuid,
                "file_action"               => "Created",
                "file_category"             => $objFile->file_category,
                "file_memo"                 => "File( " . $objFile->file_uuid . " )",
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);
        }

        CollectionHistory::create([
            "history_uuid"              => Util::uuid(),
            "collection_id"             => $whiteCol->collection_id,
            "collection_uuid"           => $whiteCol->collection_uuid,
            "history_category"          => "Multiple",
            "file_action"               => "Created",
            "history_size"              => $historySize,
            "history_comment"           => "Music( " . Str::random() . " )",
            BaseModel::STAMP_CREATED    => time(),
            BaseModel::STAMP_UPDATED    => time(),
            BaseModel::STAMP_CREATED_BY => 3,
            BaseModel::STAMP_UPDATED_BY => 3,
        ]);

        $objCol2 = Collection::find(2);
        $historySize = 0;
        $intTrack = 0;
        foreach ($col2Files as $file) {
            $objFile = File::create($file);
            $category = $objFile->file_category;
            $arrSubParams = [];
            switch ($category) {
                case "music" :
                {
                    $intTrack++;
                    $arrSubParams = [
                        "row_uuid"      => Util::uuid(),
                        "file_id"       => $objFile->file_id,
                        "file_uuid"     => $objFile->file_uuid,
                        "file_track"    => $intTrack,
                        "file_duration" => rand(180, 300),
                        "file_isrc"     => $this->collectionService->generateIsrc($isrcIncrement),
                    ];
                    $objFile->music()->create($arrSubParams);
                    $isrcIncrement++;
                    break;
                }
                case "video" :
                {
                    break;
                }
                case "merch" :
                {
                    $arrSubParams = [
                        "row_uuid"  => Util::uuid(),
                        "file_id"   => $objFile->file_id,
                        "file_uuid" => $objFile->file_uuid,
                        "file_sku"  => "4225-776-3234",
                    ];
                    $objFile->merch()->create($arrSubParams);
                    break;
                }
                case "other" :
                {
                    $arrSubParams = [
                        "row_uuid"  => Util::uuid(),
                        "file_id"   => $objFile->file_id,
                        "file_uuid" => $objFile->file_uuid,
                    ];
                    $objFile->other()->create($arrSubParams);
                    break;
                }
            }


            $historySize += $objFile->file_size;
            $objFile->collections()->attach($objCol2->collection_id, [
                "row_uuid"                  => Util::uuid(),
                "file_uuid"                 => $objFile->file_uuid,
                "collection_uuid"           => $objCol2->collection_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);

            FileHistory::create([
                "row_uuid"                  => Util::uuid(),
                "collection_id"             => $objCol2->collection_id,
                "collection_uuid"           => $objCol2->collection_uuid,
                "file_id"                   => $objFile->file_id,
                "file_uuid"                 => $objFile->file_uuid,
                "file_action"               => "Created",
                "file_category"             => $objFile->file_category,
                "file_memo"                 => "File( " . $objFile->file_uuid . " )",
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);
        }

        CollectionHistory::create([
            "history_uuid"              => Util::uuid(),
            "collection_id"             => $objCol2->collection_id,
            "collection_uuid"           => $objCol2->collection_uuid,
            "history_category"          => "Multiple",
            "file_action"               => "Created",
            "history_size"              => $historySize,
            "history_comment"           => "Music( " . Str::random() . " )",
            BaseModel::STAMP_CREATED    => time(),
            BaseModel::STAMP_UPDATED    => time(),
            BaseModel::STAMP_CREATED_BY => 3,
            BaseModel::STAMP_UPDATED_BY => 3,
        ]);

        $objCol7 = Collection::find(7);
        $historySize = 0;
        $intTrack = 0;
        foreach ($col7Files as $file) {
            $objFile = File::create($file);
            $category = $objFile->file_category;
            $arrSubParams = [];
            switch ($category) {
                case "music" :
                {
                    $intTrack++;
                    $arrSubParams = [
                        "row_uuid"      => Util::uuid(),
                        "file_id"       => $objFile->file_id,
                        "file_uuid"     => $objFile->file_uuid,
                        "file_track"    => $intTrack,
                        "file_duration" => rand(180, 300),
                        "file_isrc"     => $this->collectionService->generateIsrc($isrcIncrement),
                    ];
                    $objFile->music()->create($arrSubParams);
                    $isrcIncrement++;
                    break;
                }
                case "video" :
                {
                    break;
                }
                case "merch" :
                {
                    $arrSubParams = [
                        "row_uuid"  => Util::uuid(),
                        "file_id"   => $objFile->file_id,
                        "file_uuid" => $objFile->file_uuid,
                        "file_sku"  => "4225-776-3234",
                    ];
                    $objFile->merch()->create($arrSubParams);
                    break;
                }
                case "other" :
                {
                    $arrSubParams = [
                        "row_uuid"  => Util::uuid(),
                        "file_id"   => $objFile->file_id,
                        "file_uuid" => $objFile->file_uuid,
                    ];
                    $objFile->other()->create($arrSubParams);
                    break;
                }
            }

            $historySize += $objFile->file_size;
            $objFile->collections()->attach($objCol7->collection_id, [
                "row_uuid"                  => Util::uuid(),
                "file_uuid"                 => $objFile->file_uuid,
                "collection_uuid"           => $objCol7->collection_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);

            FileHistory::create([
                "row_uuid"                  => Util::uuid(),
                "collection_id"             => $objCol7->collection_id,
                "collection_uuid"           => $objCol7->collection_uuid,
                "file_id"                   => $objFile->file_id,
                "file_uuid"                 => $objFile->file_uuid,
                "file_action"               => "Created",
                "file_category"             => $objFile->file_category,
                "file_memo"                 => "File( " . $objFile->file_uuid . " )",
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);
        }

        CollectionHistory::create([
            "history_uuid"              => Util::uuid(),
            "collection_id"             => $objCol7->collection_id,
            "collection_uuid"           => $objCol7->collection_uuid,
            "history_category"          => "Multiple",
            "file_action"               => "Created",
            "history_size"              => $historySize,
            "history_comment"           => "Music( " . Str::random() . " )",
            BaseModel::STAMP_CREATED    => time(),
            BaseModel::STAMP_UPDATED    => time(),
            BaseModel::STAMP_CREATED_BY => 3,
            BaseModel::STAMP_UPDATED_BY => 3,
        ]);

        $objCol8 = Collection::find(8);
        $historySize = 0;
        $intTrack = 0;
        foreach ($col8Files as $file) {
            $objFile = File::create($file);
            $category = $objFile->file_category;
            $arrSubParams = [];
            switch ($category) {
                case "music" :
                {
                    $intTrack++;
                    $arrSubParams = [
                        "row_uuid"      => Util::uuid(),
                        "file_id"       => $objFile->file_id,
                        "file_uuid"     => $objFile->file_uuid,
                        "file_track"    => $intTrack,
                        "file_duration" => rand(180, 300),
                        "file_isrc"     => $this->collectionService->generateIsrc($isrcIncrement),
                    ];
                    $objFile->music()->create($arrSubParams);
                    $isrcIncrement++;
                    break;
                }
                case "video" :
                {
                    break;
                }
                case "merch" :
                {
                    $arrSubParams = [
                        "row_uuid"  => Util::uuid(),
                        "file_id"   => $objFile->file_id,
                        "file_uuid" => $objFile->file_uuid,
                        "file_sku"  => "4225-776-3234",
                    ];
                    $objFile->merch()->create($arrSubParams);
                    break;
                }
                case "other" :
                {
                    $arrSubParams = [
                        "row_uuid"  => Util::uuid(),
                        "file_id"   => $objFile->file_id,
                        "file_uuid" => $objFile->file_uuid,
                    ];
                    $objFile->other()->create($arrSubParams);
                    break;
                }
            }

            $historySize += $objFile->file_size;
            $objFile->collections()->attach($objCol8->collection_id, [
                "row_uuid"                  => Util::uuid(),
                "file_uuid"                 => $objFile->file_uuid,
                "collection_uuid"           => $objCol8->collection_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);

            FileHistory::create([
                "row_uuid"                  => Util::uuid(),
                "collection_id"             => $objCol8->collection_id,
                "collection_uuid"           => $objCol8->collection_uuid,
                "file_id"                   => $objFile->file_id,
                "file_uuid"                 => $objFile->file_uuid,
                "file_action"               => "Created",
                "file_category"             => $objFile->file_category,
                "file_memo"                 => "File( " . $objFile->file_uuid . " )",
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);
        }

        CollectionHistory::create([
            "history_uuid"              => Util::uuid(),
            "collection_id"             => $objCol8->collection_id,
            "collection_uuid"           => $objCol8->collection_uuid,
            "history_category"          => "Multiple",
            "file_action"               => "Created",
            "history_size"              => $historySize,
            "history_comment"           => "Music( " . Str::random() . " )",
            BaseModel::STAMP_CREATED    => time(),
            BaseModel::STAMP_UPDATED    => time(),
            BaseModel::STAMP_CREATED_BY => 3,
            BaseModel::STAMP_UPDATED_BY => 3,
        ]);

        $objCol9 = Collection::find(9);
        $historySize = 0;
        $intTrack = 0;
        foreach ($col9Files as $file) {
            $objFile = File::create($file);
            $category = $objFile->file_category;
            $arrSubParams = [];
            switch ($category) {
                case "music" :
                {
                    $intTrack++;
                    $arrSubParams = [
                        "row_uuid"      => Util::uuid(),
                        "file_id"       => $objFile->file_id,
                        "file_uuid"     => $objFile->file_uuid,
                        "file_track"    => $intTrack,
                        "file_duration" => rand(180, 300),
                        "file_isrc"     => $this->collectionService->generateIsrc($isrcIncrement),
                    ];
                    $objFile->music()->create($arrSubParams);
                    $isrcIncrement++;
                    break;
                }
                case "video" :
                {
                    break;
                }
                case "merch" :
                {
                    $arrSubParams = [
                        "row_uuid"  => Util::uuid(),
                        "file_id"   => $objFile->file_id,
                        "file_uuid" => $objFile->file_uuid,
                        "file_sku"  => "4225-776-3234",
                    ];
                    $objFile->merch()->create($arrSubParams);
                    break;
                }
                case "other" :
                {
                    $arrSubParams = [
                        "row_uuid"  => Util::uuid(),
                        "file_id"   => $objFile->file_id,
                        "file_uuid" => $objFile->file_uuid,
                    ];
                    $objFile->other()->create($arrSubParams);
                    break;
                }
            }

            $historySize += $objFile->file_size;
            $objFile->collections()->attach($objCol9->collection_id, [
                "row_uuid"                  => Util::uuid(),
                "file_uuid"                 => $objFile->file_uuid,
                "collection_uuid"           => $objCol9->collection_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);

            FileHistory::create([
                "row_uuid"                  => Util::uuid(),
                "collection_id"             => $objCol9->collection_id,
                "collection_uuid"           => $objCol9->collection_uuid,
                "file_id"                   => $objFile->file_id,
                "file_uuid"                 => $objFile->file_uuid,
                "file_action"               => "Created",
                "file_category"             => $objFile->file_category,
                "file_memo"                 => "File( " . $objFile->file_uuid . " )",
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);
        }

        CollectionHistory::create([
            "history_uuid"              => Util::uuid(),
            "collection_id"             => $objCol9->collection_id,
            "collection_uuid"           => $objCol9->collection_uuid,
            "history_category"          => "Multiple",
            "file_action"               => "Created",
            "history_size"              => $historySize,
            "history_comment"           => "Music( " . Str::random() . " )",
            BaseModel::STAMP_CREATED    => time(),
            BaseModel::STAMP_UPDATED    => time(),
            BaseModel::STAMP_CREATED_BY => 3,
            BaseModel::STAMP_UPDATED_BY => 3,
        ]);

        $objCol10 = Collection::find(10);
        $historySize = 0;
        $intTrack = 0;
        foreach ($col10Files as $file) {
            $objFile = File::create($file);
            $category = $objFile->file_category;
            $arrSubParams = [];
            switch ($category) {
                case "music" :
                {
                    $intTrack++;
                    $arrSubParams = [
                        "row_uuid"      => Util::uuid(),
                        "file_id"       => $objFile->file_id,
                        "file_uuid"     => $objFile->file_uuid,
                        "file_track"    => $intTrack,
                        "file_duration" => rand(180, 300),
                        "file_isrc"     => $this->collectionService->generateIsrc($isrcIncrement),
                    ];
                    $objFile->music()->create($arrSubParams);
                    $isrcIncrement++;
                    break;
                }
                case "video" :
                {
                    break;
                }
                case "merch" :
                {
                    $arrSubParams = [
                        "row_uuid"  => Util::uuid(),
                        "file_id"   => $objFile->file_id,
                        "file_uuid" => $objFile->file_uuid,
                        "file_sku"  => "4225-776-3234",
                    ];
                    $objFile->merch()->create($arrSubParams);
                    break;
                }
                case "other" :
                {
                    $arrSubParams = [
                        "row_uuid"  => Util::uuid(),
                        "file_id"   => $objFile->file_id,
                        "file_uuid" => $objFile->file_uuid,
                    ];
                    $objFile->other()->create($arrSubParams);
                    break;
                }
            }

            $historySize += $objFile->file_size;
            $objFile->collections()->attach($objCol10->collection_id, [
                "row_uuid"                  => Util::uuid(),
                "file_uuid"                 => $objFile->file_uuid,
                "collection_uuid"           => $objCol10->collection_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);
            FileHistory::create([
                "row_uuid"                  => Util::uuid(),
                "collection_id"             => $objCol10->collection_id,
                "collection_uuid"           => $objCol10->collection_uuid,
                "file_id"                   => $objFile->file_id,
                "file_uuid"                 => $objFile->file_uuid,
                "file_action"               => "Created",
                "file_category"             => $objFile->file_category,
                "file_memo"                 => "File( " . $objFile->file_uuid . " )",
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);
        }

        CollectionHistory::create([
            "history_uuid"              => Util::uuid(),
            "collection_id"             => $objCol10->collection_id,
            "collection_uuid"           => $objCol10->collection_uuid,
            "history_category"          => "Multiple",
            "file_action"               => "Created",
            "history_size"              => $historySize,
            "history_comment"           => "Music( " . Str::random() . " )",
            BaseModel::STAMP_CREATED    => time(),
            BaseModel::STAMP_UPDATED    => time(),
            BaseModel::STAMP_CREATED_BY => 3,
            BaseModel::STAMP_UPDATED_BY => 3,
        ]);

        $arrHistoryCols = Collection::where("collection_comment", "**jin")->get();
        $arrExtraMusicFiles = collect();
        $intTrack = 3;
        foreach ($extra4Files as $file) {
            $objFile = File::create($file);
            $arrExtraMusicFiles->push($objFile);
            $category = $objFile->file_category;
            $arrSubParams = [];
            switch ($category) {
                case "music" :
                {
                    $intTrack++;
                    $arrSubParams = [
                        "row_uuid"      => Util::uuid(),
                        "file_id"       => $objFile->file_id,
                        "file_uuid"     => $objFile->file_uuid,
                        "file_track"    => $intTrack,
                        "file_duration" => rand(180, 300),
                        "file_isrc"     => $this->collectionService->generateIsrc($isrcIncrement),
                    ];
                    $objFile->music()->create($arrSubParams);
                    $isrcIncrement++;
                    break;
                }
                case "video" :
                {
                    break;
                }
                case "merch" :
                {
                    $arrSubParams = [
                        "row_uuid"  => Util::uuid(),
                        "file_id"   => $objFile->file_id,
                        "file_uuid" => $objFile->file_uuid,
                        "file_sku"  => "4225-776-3234",
                    ];
                    $objFile->merch()->create($arrSubParams);
                    break;
                }
                case "other" :
                {
                    $arrSubParams = [
                        "row_uuid"  => Util::uuid(),
                        "file_id"   => $objFile->file_id,
                        "file_uuid" => $objFile->file_uuid,
                    ];
                    $objFile->other()->create($arrSubParams);
                    break;
                }
            }
        }
        // 1st step 2 musics added,
        $historySize = 0;
        foreach ($arrExtraMusicFiles as $musicFile) {
            $musicFile->collections()->attach($arrHistoryCols[1]->collection_id, [
                "row_uuid"                  => Util::uuid(),
                "file_uuid"                 => $musicFile->file_uuid,
                "collection_uuid"           => $arrHistoryCols[1]->collection_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_CREATED_BY => 3,
                BaseModel::STAMP_UPDATED_BY => 3,
            ]);

            $historySize += $musicFile->file_size;
            $arrHistoryCols[1]->collectionFilesHistory()->attach($musicFile->file_id, [
                "row_uuid"                  => Util::uuid(),
                "collection_uuid"           => $arrHistoryCols[1]->collection_uuid,
                "file_uuid"                 => $musicFile->file_uuid,
                "file_action"               => "Created",
                "file_category"             => $musicFile->file_category,
                "file_memo"                 => sprintf("File ( %s ) %s", $musicFile->file_uuid, "Created"),
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_CREATED_BY => 3,
                BaseModel::STAMP_UPDATED_BY => 3,
            ]);
        }

        foreach ($objCol3->files as $objFile) {
            $objFile->collections()->attach($arrHistoryCols[1]->collection_id, [
                "row_uuid"                  => Util::uuid(),
                "file_uuid"                 => $objFile->file_uuid,
                "collection_uuid"           => $arrHistoryCols[1]->collection_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_CREATED_BY => 3,
                BaseModel::STAMP_UPDATED_BY => 3,
            ]);
        }

        CollectionHistory::create([
            "history_uuid"     => Util::uuid(),
            "collection_id"    => $arrHistoryCols[1]->collection_id,
            "collection_uuid"  => $arrHistoryCols[1]->collection_uuid,
            "history_category" => "Music",
            "file_action"      => "Created",
            "history_size"     => $historySize,
            "history_comment"  => "Music( " . Str::random() . " )",
        ]);

        //2 step remove music file
        $deletedFile = File::where("file_name", "special-1.mp3")->firstOrFail();
        $arrObjFiles = $arrHistoryCols[1]->files()->wherePivot("file_id", "<>", $deletedFile->file_id)->get();
        foreach ($arrObjFiles as $objFile) {
            $arrHistoryCols[2]->files()->attach($objFile->file_id, [
                "row_uuid"                  => Util::uuid(),
                "file_uuid"                 => $objFile->file_uuid,
                "collection_uuid"           => $arrHistoryCols[2]->collection_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_CREATED_BY => 3,
                BaseModel::STAMP_UPDATED_BY => 3,
            ]);
        }
        $historySize = 0;

        $historySize += $deletedFile->file_size;

        $arrHistoryCols[2]->collectionFilesHistory()->attach($deletedFile->file_id, [
            "row_uuid"                  => Util::uuid(),
            "collection_uuid"           => $arrHistoryCols[2]->collection_uuid,
            "parent_id"                 => $deletedFile->file_id,
            "parent_uuid"               => $deletedFile->file_uuid,
            "file_uuid"                 => $deletedFile->file_uuid,
            "file_action"               => "Deleted",
            "file_category"             => $deletedFile->file_category,
            "file_memo"                 => sprintf("File ( %s ) %s", $deletedFile->file_uuid, "Deleted"),
            BaseModel::STAMP_CREATED    => time(),
            BaseModel::STAMP_UPDATED    => time(),
            BaseModel::STAMP_CREATED_BY => 3,
            BaseModel::STAMP_UPDATED_BY => 3,
        ]);

        CollectionHistory::create([
            "history_uuid"     => Util::uuid(),
            "collection_id"    => $arrHistoryCols[2]->collection_id,
            "collection_uuid"  => $arrHistoryCols[2]->collection_uuid,
            "history_category" => "Video",
            "file_action"      => "Deleted",
            "history_size"     => $historySize,
            "history_comment"  => "Video( " . Str::random() . " )",
        ]);

        //3 step added multiple file
        $arrMultiFiles = collect();
        $historySize = 0;
        $intTrack = 5;
        foreach ($extra6Files as $file) {
            $objFile = File::create($file);
            switch ($category) {
                case "music" :
                {
                    $intTrack++;
                    $arrSubParams = [
                        "row_uuid"      => Util::uuid(),
                        "file_id"       => $objFile->file_id,
                        "file_uuid"     => $objFile->file_uuid,
                        "file_track"    => $intTrack,
                        "file_duration" => rand(180, 300),
                        "file_isrc"     => $this->collectionService->generateIsrc($isrcIncrement),
                    ];
                    $objFile->music()->create($arrSubParams);
                    $isrcIncrement++;
                    break;
                }
                case "video" :
                {
                    break;
                }
                case "merch" :
                {
                    $arrSubParams = [
                        "row_uuid"  => Util::uuid(),
                        "file_id"   => $objFile->file_id,
                        "file_uuid" => $objFile->file_uuid,
                        "file_sku"  => "4225-776-3234",
                    ];
                    $objFile->merch()->create($arrSubParams);
                    break;
                }
                case "other" :
                {
                    $arrSubParams = [
                        "row_uuid"  => Util::uuid(),
                        "file_id"   => $objFile->file_id,
                        "file_uuid" => $objFile->file_uuid,
                    ];
                    $objFile->other()->create($arrSubParams);
                    break;
                }
            }
            $historySize += $objFile->file_size;
            $arrMultiFiles->push($objFile);
            $objFile->collections()->attach($arrHistoryCols[3]->collection_id, [
                "row_uuid"                  => Util::uuid(),
                "file_uuid"                 => $objFile->file_uuid,
                "collection_uuid"           => $arrHistoryCols[3]->collection_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_CREATED_BY => 3,
                BaseModel::STAMP_UPDATED_BY => 3,
            ]);

            $arrHistoryCols[3]->collectionFilesHistory()->attach($objFile->file_id, [
                "row_uuid"                  => Util::uuid(),
                "collection_uuid"           => $arrHistoryCols[3]->collection_uuid,
                "file_uuid"                 => $objFile->file_uuid,
                "file_action"               => "Created",
                "file_category"             => $objFile->file_category,
                "file_memo"                 => sprintf("File ( %s ) %s", $objFile->file_uuid, "Created"),
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_CREATED_BY => 3,
                BaseModel::STAMP_UPDATED_BY => 3,
            ]);
        }

        foreach ($arrHistoryCols[2]->files as $objFile) {
            $objFile->collections()->attach($arrHistoryCols[3]->collection_id, [
                "row_uuid"                  => Util::uuid(),
                "file_uuid"                 => $objFile->file_uuid,
                "collection_uuid"           => $arrHistoryCols[3]->collection_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_CREATED_BY => 3,
                BaseModel::STAMP_UPDATED_BY => 3,
            ]);
        }

        CollectionHistory::create([
            "history_uuid"     => Util::uuid(),
            "collection_id"    => $arrHistoryCols[3]->collection_id,
            "collection_uuid"  => $arrHistoryCols[3]->collection_uuid,
            "history_category" => "Multiple",
            "history_size"     => $historySize,
            "file_action"      => "Created",
            "history_comment"  => "Multiple( " . Str::random() . " )",
        ]);

        Model::reguard();
    }
}
