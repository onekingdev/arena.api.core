<?php

namespace App\Console\Commands\Music\Moods;

use App\Models\Music\ArtistGenre;
use App\Models\Music\ArtistMood;
use App\Models\Music\ProjectGenre;
use Illuminate\Console\Command;

class UpdateArtistsMoods extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'artist:moods:update';

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
        $arrMood = \App\Models\Music\Mood::all();

        foreach ($arrMood as $mood) {
            ArtistMood::where("artist_mood", $mood->mood)->update([
                "mood_id"   => $mood->mood_id,
                "mood_uuid" => $mood->mood_uuid,
            ]);
        }

        return 0;
    }
}
