<?php

namespace App\Console\Commands\Music\Themes;

use App\Models\Music\ArtistGenre;
use App\Models\Music\ArtistMood;
use App\Models\Music\ArtistStyle;
use App\Models\Music\ArtistTheme;
use App\Models\Music\ProjectGenre;
use Illuminate\Console\Command;

class UpdateArtistsTheme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'artist:themes:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $arrThemes = \App\Models\Music\Theme::all();

        foreach ($arrThemes as $theme) {
            ArtistTheme::where("artist_theme", $theme->theme_name)->update([
                "theme_id"   => $theme->theme_id,
                "theme_uuid" => $theme->theme_uuid,
            ]);
        }

        return 0;
    }
}
