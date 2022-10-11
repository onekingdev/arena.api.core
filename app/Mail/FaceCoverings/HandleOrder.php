<?php

namespace App\Mail\FaceCoverings;

use App\Models\Core\App;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HandleOrder extends Mailable {
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    private array $orderData;

    /**
     * Create a new message instance.
     *
     * @param array $orderData
     */
    public function __construct(array $orderData) {
        $this->orderData = $orderData;
    }

    /**
     * Build the message.
     *
     * @return HandleOrder
     */
    public function build() {
        $this->withSwiftMessage(function ($message) {
            $message->app = App::where("app_name", "merchandising")->first();
        });

        return $this->subject("New Face Covering Order!")->view('mail.facecovering.order')
                    ->with(["order" => $this->orderData]);
    }
}
