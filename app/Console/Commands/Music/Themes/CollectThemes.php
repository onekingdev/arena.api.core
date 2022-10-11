<?php

namespace App\Console\Commands\Music\Themes;

use App\Helpers\Util;
use App\Models\Music\Genre as GenreModel;
use App\Models\Music\Mood;
use App\Models\Music\Style;
use App\Models\Music\Theme;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CollectThemes extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'music:themes';

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
        $themes = DB::connection("mysql-music")->table("projects_themes")->groupBy("project_theme")
                    ->pluck("project_theme");

        foreach ($themes as $theme) {
            if (Theme::where("theme_name", $theme)->doesntExist()) {
                Theme::create([
                    "theme_uuid" => Util::uuid(),
                    "theme_name" => $theme,
                ]);
            }
        }

        $themes = DB::connection("mysql-music")->table("artists_themes")->groupBy("artist_theme")
                    ->pluck("artist_theme");

        foreach ($themes as $theme) {
            if (Theme::where("theme_name", $theme)->doesntExist()) {
                Theme::create([
                    "theme_uuid" => Util::uuid(),
                    "theme_name" => $theme,
                ]);
            }
        }

        return 0;
    }
}
