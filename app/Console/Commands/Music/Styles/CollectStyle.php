<?php

namespace App\Console\Commands\Music\Styles;

use App\Helpers\Util;
use App\Models\Music\Genre as GenreModel;
use App\Models\Music\Mood;
use App\Models\Music\Style;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CollectStyle extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'music:style';

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
        $styles = DB::connection("mysql-music")->table("projects_styles")->groupBy("project_style")
                    ->pluck("project_style");

        foreach ($styles as $style) {
            if (Style::where("style_name", $style)->doesntExist()) {
                Style::create([
                    "style_uuid" => Util::uuid(),
                    "style_name" => $style,
                ]);
            }
        }

        $styles = DB::connection("mysql-music")->table("artists_styles")->groupBy("artist_style")
                    ->pluck("artist_style");

        foreach ($styles as $style) {
            if (Style::where("style_name", $style)->doesntExist()) {
                Style::create([
                    "style_uuid" => Util::uuid(),
                    "style_name" => $style,
                ]);
            }
        }

        return 0;
    }
}
