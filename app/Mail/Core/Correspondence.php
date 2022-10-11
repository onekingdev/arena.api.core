<?php

namespace App\Mail\Core;

use App\Models\Core\App;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\Core\Correspondence as CorrespondenceModel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Correspondence extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * @var Correspondence
     */
    private $correspondence;
    /**
     * @var App
     */
    private App $app;

    /**
     * CorrespondenceMail constructor.
     * @param App $app
     * @param CorrespondenceModel $correspondence
     */
    public function __construct(App $app, CorrespondenceModel $correspondence){
        $this->correspondence = $correspondence;
        $this->app = $app;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $attachmentPath = null;
        $attachments = [];

        /* Get bucket correspondence attachments path */
        if ($this->correspondence->attachments->isNotEmpty()) {
            $attachmentPath = $this->correspondence->attachments_path . "/" . $this->correspondence->correspondence_uuid . ".zip";
        }

        /* Add correspondence attachments .zip to email */
        if ($attachmentPath && bucket_storage("core")->size($attachmentPath) <= 10485760) {
            $this->attachFromStorageDisk("s3-core", $attachmentPath);
        }

        /* Setup email */
        $this->withSwiftMessage(function ($message) {
            $message->app = $this->app;
        });
        $appName = config("constant.email.". $this->app->app_name .".name");
        $this->from(config("constant.email.". $this->app->app_name .".address"), "Arena " . $appName);
        $this->subject("Correspondence");

        /* Get data for template */
        $arrJsonData = json_decode($this->correspondence->email_json);
        $arrJsonData = (object) array_filter((array) $arrJsonData, function ($val) {
            return !empty(str_replace(" ", "", $val));
        });

        $objAttachments = $this->correspondence->attachments;
        if ($objAttachments->isNotEmpty()) {
            foreach ($objAttachments as $key => $objAttachment) {
                $attachmentPath = $this->correspondence->attachments_path . "/" . $objAttachment->file_name;
                $attachments[$key]["name"] = $objAttachment->file_name;
                $attachments[$key]["url"] = bucket_storage("core")->url($attachmentPath);
            }
        }

        /* Send email */
        return ($this->view("mail.core.correspondence")->with([
            "arrJsonData" => $arrJsonData,
            "app" => $appName,
            "attachments" => $attachments,
            "correspondence" => $this->correspondence
        ]));
    }
}
