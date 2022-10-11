<?php

namespace App\Console\Commands\Music\Genre;

use App\Helpers\Util;
use App\Models\Music\Genre as GenreModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Genre extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'music:genres';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Group Genres';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $genres = DB::connection("mysql-music")->table("projects_genres")->groupBy("project_genre")
                    ->pluck("project_genre");

        foreach ($genres as $genre) {
            if (GenreModel::where("genre", $genre)->doesntExist()) {
                GenreModel::create([
                    "genre_uuid" => Util::uuid(),
                    "genre"      => $genre,
                ]);
            }
        }

        $genres = DB::connection("mysql-music")->table("artists_genres")->groupBy("artist_genre")
                    ->pluck("artist_genre");

        foreach ($genres as $genre) {
            if (GenreModel::where("genre", $genre)->doesntExist()) {
                GenreModel::create([
                    "genre_uuid" => Util::uuid(),
                    "genre"      => $genre,
                ]);
            }
        }

        return 0;
    }
}
