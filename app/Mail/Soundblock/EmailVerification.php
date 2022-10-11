<?php

namespace App\Mail\Soundblock;

use App\Models\Core\App;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use App\Models\Users\Contact\UserContactEmail;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable {
    use Queueable, SerializesModels;

    /**
     * @var UserContactEmail
     */
    private UserContactEmail $objEmail;
    /**
     * @var App
     */
    private App $app;
    /**
     * @var array
     */
    private ?array $option;

    /**
     * Create a new message instance.
     *
     * @param UserContactEmail $objEmail
     * @param App $app
     * @param array $option
     *  $option = [
     *      'required_add_project_group' => (bool) This value represents if the user has to be added to project group after singup by invite email.
     *  ]
     */
    public function __construct(UserContactEmail $objEmail, App $app, ?array $option = ["required_add_project_group" => false]) {
        $this->objEmail = $objEmail;
        $this->app = $app;
        $this->option = $option;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        $this->withSwiftMessage(function ($message) {
            $message->app = $this->app;
        });

        $this->from(config("constant.email.soundblock.address"), config("constant.email.soundblock.name"));

        $frontendUrl = app_url("soundblock", "http://localhost:8200") . "email/" . $this->objEmail->verification_hash;

        return $this->view("mail.soundblock.verification")->subject("Welcome - Please Confirm")
                    ->with(["link" => $frontendUrl]);
    }
}
