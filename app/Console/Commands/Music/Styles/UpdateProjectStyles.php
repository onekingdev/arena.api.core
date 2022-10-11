<?php

namespace App\Console\Commands\Music\Styles;

use App\Models\Music\ArtistMood;
use App\Models\Music\ProjectGenre;
use App\Models\Music\ProjectMood;
use App\Models\Music\ProjectStyle;
use Illuminate\Console\Command;

class UpdateProjectStyles extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:styles:update';

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
        $arrStyle = \App\Models\Music\Style::all();

        foreach ($arrStyle as $style) {
            ProjectStyle::where("project_style", $style->style_name)->update([
                "style_id"   => $style->style_id,
                "style_uuid" => $style->style_uuid,
            ]);
        }

        return 0;
    }
}
