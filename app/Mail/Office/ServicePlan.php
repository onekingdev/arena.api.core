<?php

namespace App\Mail\Office;

use App\Models\Core\App;
use App\Models\Soundblock\Accounts\AccountPlan as AccountPlanModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ServicePlan extends Mailable
{
    use Queueable, SerializesModels;

    /** @var App */
    private App $app;
    /** @var AccountPlanModel */
    private AccountPlanModel $objAccountPlan;

    /**
     * Create a new message instance.
     *
     * @param App $app
     * @param AccountPlanModel $objAccountPlan
     */
    public function __construct(App $app, AccountPlanModel $objAccountPlan)
    {
        $this->app = $app;
        $this->objAccountPlan = $objAccountPlan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from(config("constant.email.soundblock.address"), config("constant.email.soundblock.name"));
        $this->subject("Account Plan Type");
        $this->withSwiftMessage(function ($message) {
            $message->app = $this->app;
        });

        $userName = $this->objAccountPlan->account->user->name;
        $frontendUrl = app_url("soundblock", "http://localhost:4200") . "settings/account";
        $accountPlanType = $this->objAccountPlan->plan_type;

        return $this->view("mail.soundblock.created_account_plan_type")->with([
            "frontendUrl" => $frontendUrl,
            "userName"    => $userName,
            "accountPlanType" => $accountPlanType,
        ]);
    }
}
