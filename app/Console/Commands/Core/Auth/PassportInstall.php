<?php

namespace App\Console\Commands\Core\Auth;


use App\Contracts\Core\Arena;
use App\Contracts\Core\Slack;
use Aws\ElasticBeanstalk\Exception\ElasticBeanstalkException;
use Laravel\Passport\Client;
use Laravel\Passport\Console\InstallCommand;
use Aws\ElasticBeanstalk\ElasticBeanstalkClient;

class PassportInstall extends InstallCommand {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passport:install
                            {--eb-env= : EB Env}
                            {--uuids : Use UUIDs for all client IDs}
                            {--force : Overwrite keys they already exist}
                            {--length=4096 : The length of the private key}';

    /**
     * @var Arena
     */
    private Arena $arena;
    /**
     * @var Slack
     */
    private Slack $slack;

    /**
     * Create a new command instance.
     *
     * @param Arena $arena
     * @param Slack $slack
     */
    public function __construct(Arena $arena, Slack $slack) {
        parent::__construct();
        $this->arena = $arena;
        $this->slack = $slack;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle() {
        $installResult = parent::handle();

        if ($this->option("eb-env")) {
            $objBeanstalk = new ElasticBeanstalkClient([
                'region'      => 'us-east-1',
                'version'     => 'latest',
                'credentials' => [
                    'key'    => env("AWS_ACCESS_KEY_ID"),
                    'secret' => env("AWS_SECRET_ACCESS_KEY"),
                ],
            ]);

            $oauthClient = Client::where("password_client", 1)->latest()->first();
            $ebInfo = $this->arena->beanstalkConfig("api.core", $this->option("eb-env"));

            if (is_null($ebInfo)) {
                return $installResult;
            }

            try{
                $objBeanstalk->updateEnvironment([
                    "ApplicationName" => $ebInfo["name"],
                    "EnvironmentId"   => $ebInfo["id"],
                    "EnvironmentName" => $ebInfo["environment"],
                    "OptionSettings"  => [
                        [
                            "Namespace"    => "aws:elasticbeanstalk:application:environment",
                            "OptionName"   => "PASSWORD_CLIENT_ID",
                            "ResourceName" => "PASSWORD_CLIENT_ID",
                            "Value"        => $oauthClient->id,
                        ],
                        [
                            "Namespace"    => "aws:elasticbeanstalk:application:environment",
                            "OptionName"   => "PASSWORD_CLIENT_SECRET",
                            "ResourceName" => "PASSWORD_CLIENT_SECRET",
                            "Value"        => $oauthClient->secret,
                        ],
                    ],
                ]);
            } catch (ElasticBeanstalkException $exception) {
                $this->slack->passportNotification($oauthClient, $ebInfo, $exception->getAwsErrorMessage());
            }
        }

        return $installResult;
    }
}
