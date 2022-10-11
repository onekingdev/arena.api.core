<?php

namespace App\Mail\Core;

use App\Models\Core\App;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Core\CorrespondenceResponse as CorrespondenceResponseModel;

class CorrespondenceResponse extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var App
     */
    private App $app;
    /**
     * @var CorrespondenceResponseModel
     */
    private CorrespondenceResponseModel $correspondenceResponse;

    /**
     * Create a new message instance.
     *
     * @param App $app
     * @param CorrespondenceResponseModel $correspondence
     */
    public function __construct(App $app, CorrespondenceResponseModel $correspondence)
    {
        $this->app = $app;
        $this->correspondenceResponse = $correspondence;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $attachmentPath = null;

        /* Get bucket correspondence attachments path */
        if ($this->correspondenceResponse->flag_attachments) {
            $arrFiles = bucket_storage("core")->files($this->correspondenceResponse->attachments_path);
            if (!empty($arrFiles)) {
                foreach ($arrFiles as $filePath) {
                    $this->attachFromStorageDisk("s3-core", $filePath);
                }
            }
        }

        $this->withSwiftMessage(function ($message) {
            $message->app = $this->app;
        });

        $appName = config("constant.email.". $this->app->app_name .".name");
        $this->from(config("constant.email.". $this->app->app_name .".address"), "Arena " . $appName);
        $this->subject("Arena Correspondence");

        return ($this->view("mail.core.correspondenceResponse")
            ->with(["text" => $this->correspondenceResponse->response_message, "app" => $appName])
        );
    }
}
