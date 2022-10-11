<?php

namespace App\Console\Commands\Soundblock\Notification;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Soundblock\Projects\Deployments\Deployment as DeploymentModel;

class Deployment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:deployment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
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
        $arrMailTo = ["swhite@arena.com"];

        if (config("app.env") === "prod") {
            $arrMailTo = ["devans@arena.com", "ajohnson@soundblock.com", "swhite@arena.com"];
        }

        $arrNotNotified = DeploymentModel::where("flag_notify_admin", false)->get();

        $objDeployments = DeploymentModel::where("flag_notify_admin", false)->leftJoin("soundblock_data_platforms",
            "soundblock_projects_deployments.platform_id", "soundblock_data_platforms.platform_id")
            ->select("project_id", \DB::raw("GROUP_CONCAT(soundblock_data_platforms.`name` ORDER BY LOWER(soundblock_data_platforms.name) ASC SEPARATOR ', ') as platforms"))
            ->groupBy("soundblock_projects_deployments.project_id")->get();

        if($objDeployments->isNotEmpty()) {
            Mail::to($arrMailTo)->send(new \App\Mail\System\Notification\Deployment($objDeployments));
        }

        foreach ($arrNotNotified as $objDeployment) {
            $objDeployment->flag_notify_admin = true;
            $objDeployment->save();
        }

        return 0;
    }
}
