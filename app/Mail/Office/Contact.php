<?php

namespace App\Mail\Office;

use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use App\Models\Office\Contact as ContactModel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Contact extends Mailable implements ShouldQueue {
    use Queueable, SerializesModels;

    /** @var ContactModel */
    protected ContactModel $contact;

    /**
     * Create a new message instance.
     *
     * @param ContactModel $contact
     */
    public function __construct(ContactModel $contact) {
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->markdown("email.office.contact")->with(["contact" => $this->contact]);
    }
}
