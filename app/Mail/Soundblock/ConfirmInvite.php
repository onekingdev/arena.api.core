<?php

namespace App\Mail\Soundblock;

use App\Models\{
    Core\App,
    Soundblock\Accounts\Account
};
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmInvite extends Mailable implements ShouldQueue{
    use Queueable, SerializesModels;

    /** @var App */
    private App $app;
    private string $userName;
    private string $accountName;
    private bool $flagConfirm;
    /**
     * @var Account
     */
    private Account $objAccount;

    /**
     * Create a new message instance.
     *
     * @param App $app
     * @param string $userName
     * @param Account $objAccount
     * @param bool $flagConfirm
     */
    public function __construct(App $app, string $userName, Account $objAccount, bool $flagConfirm = true) {
        $this->app = $app;
        $this->userName = $userName;
        $this->flagConfirm = $flagConfirm;
        $this->objAccount = $objAccount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        $frontendUrl = app_url("soundblock", "http://localhost:4200");

        $this->withSwiftMessage(function ($message) {
            $message->app = $this->app;
        });

        $this->from(config("constant.email.soundblock.address"), config("constant.email.soundblock.name"));

        if ($this->flagConfirm) {
            $this->subject("Account Invitation Accepted");
        } else {
            $this->subject("Account Invitation Declined");
        }

        $accountDetails = [
            "Name"   => $this->objAccount->account_name,
            "Status" => $this->objAccount->flag_status,
            "Holder" => $this->objAccount->user->name,
        ];

        return ($this->view("mail.soundblock.confirm_invite"))->with([
            "frontendUrl" => $frontendUrl,
            "userName"    => $this->userName,
            "flagConfirm" => $this->flagConfirm,
            "account"     => $accountDetails,
        ]);
    }
}
