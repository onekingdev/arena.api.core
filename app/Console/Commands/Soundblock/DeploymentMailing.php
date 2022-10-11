<?php

namespace App\Console\Commands\Soundblock;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\Soundblock\Deployment as DeploymentMail;
use App\Models\Soundblock\Projects\Deployments\Deployment as DeploymentModel;

class DeploymentMailing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deployment:users_mailing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command created for mailing users about changing status of project deployments.';

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
        $arrNotifyUsers = [];
        $arrNotNotified = DeploymentModel::where("flag_notify_user", false)->get();

        /* Create deployments array */
        foreach ($arrNotNotified as $objDeployment) {
            $objUsers = $objDeployment->project->team->users;

            foreach ($objUsers as $objUser) {
                $strEmail = optional($objUser->primary_email)->user_auth_email;

                if (!empty($strEmail)) {
                    $arrNotifyUsers[$objUser->primary_email->user_auth_email][$objDeployment->project->project_uuid][] = [
                        "platform" => $objDeployment->platform->name,
                        "status" => $objDeployment->deployment_status
                    ];
                }
            }
        }

        /* Send email to user */
        foreach ($arrNotifyUsers as $strUserEmail => $arrProjects) {
            foreach ($arrProjects as $projectTitle => $arrDeployments) {
                Mail::to($strUserEmail)->send(new DeploymentMail($projectTitle, $arrDeployments));
            }
        }

        foreach ($arrNotNotified as $objDeployment) {
            $objDeployment->flag_notify_user = true;
            $objDeployment->save();
        }

        return 0;
    }
}
