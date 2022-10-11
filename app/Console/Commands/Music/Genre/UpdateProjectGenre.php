<?php

namespace App\Console\Commands\Music\Genre;

use App\Models\Music\ProjectGenre;
use Illuminate\Console\Command;

class UpdateProjectGenre extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:genre:update';

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
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $arrGenre = \App\Models\Music\Genre::all();

        foreach ($arrGenre as $genre) {
            ProjectGenre::where("project_genre", $genre->genre)->update([
                "genre_id"   => $genre->genre_id,
                "genre_uuid" => $genre->genre_uuid,
            ]);
        }
        return 0;
    }
}
