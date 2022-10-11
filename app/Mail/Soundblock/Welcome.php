<?php

namespace App\Mail\Soundblock;

use App\Models\Core\App;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Soundblock\Accounts\Account as AccountModel;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;

    /** @var App */
    private App $app;
    /** @var AccountModel */
    private AccountModel $objAccount;

    /**
     * Create a new message instance.
     *
     * @param App $app
     * @param AccountModel $objAccount
     */
    public function __construct(App $app, AccountModel $objAccount)
    {
        $this->app = $app;
        $this->objAccount = $objAccount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from(config("constant.email.soundblock.address"), config("constant.email.soundblock.name"));
        $this->subject("Welcome To Soundblock!");
        $this->withSwiftMessage(function ($message) {
            $message->app = $this->app;
        });

        $userName = $this->objAccount->user->name;
        $userEmail = $this->objAccount->user->primary_email;
        $frontendUrl = app_url("soundblock", "http://localhost:4200");

        if (!$userEmail->flag_verified) {
            $frontendUrl .= "email/" . $userEmail->verification_hash;
        } else {
            $frontendUrl .= "projects";
        }

        return $this->view("mail.soundblock.welcome")->with([
            "frontendUrl" => $frontendUrl,
            "is_verified" => $userEmail->flag_verified,
            "userName"    => $userName
        ]);
    }
}
