<?php

namespace App\Console\Commands\Music\Moods;

use App\Helpers\Util;
use App\Models\Music\Genre as GenreModel;
use App\Models\Music\Mood;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CollectMoods extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'music:mood';

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
        $genres = DB::connection("mysql-music")->table("projects_moods")->groupBy("project_mood")
                    ->pluck("project_mood");

        foreach ($genres as $genre) {
            if (Mood::where("mood", $genre)->doesntExist()) {
                Mood::create([
                    "mood_uuid" => Util::uuid(),
                    "mood"      => $genre,
                ]);
            }
        }

        $genres = DB::connection("mysql-music")->table("artists_moods")->groupBy("artist_mood")
                    ->pluck("artist_mood");

        foreach ($genres as $genre) {
            if (Mood::where("mood", $genre)->doesntExist()) {
                Mood::create([
                    "mood_uuid" => Util::uuid(),
                    "mood"      => $genre,
                ]);
            }
        }

        return 0;
    }
}
