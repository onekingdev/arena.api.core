<?php

namespace App\Services\Core;

use Util;
use Client;
use ZipArchive;
use App\Models\Core\Auth\AuthGroup;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Events\Common\PrivateNotification;
use App\Repositories\User\UserContactEmail;
use App\Repositories\Core\CorrespondenceAttachments;
use App\Mail\Core\Correspondence as CorrespondenceMail;
use App\Repositories\Core\Correspondence as CorrespondenceRepository;
use App\Mail\Core\CorrespondenceResponse as CorrespondenceResponseMail;
use App\Mail\Core\CorrespondenceConfirmation as CorrespondenceConfirmationMail;
use App\Repositories\Core\CorrespondenceResponses as CorrespondenceResponsesRepository;

class Correspondence {
    /** @var CorrespondenceRepository */
    private CorrespondenceRepository $correspondenceRepository;
    /** @var UserContactEmail */
    private UserContactEmail $contactEmailRepository;
    /** @var CorrespondenceAttachments */
    private CorrespondenceAttachments $correspondenceAttachmentsRepository;
    /** @var \Illuminate\Filesystem\FilesystemAdapter */
    private \Illuminate\Filesystem\FilesystemAdapter $coreAdapter;
    /** @var \Illuminate\Filesystem\FilesystemAdapter */
    private \Illuminate\Filesystem\FilesystemAdapter $localAdapter;
    /** @var CorrespondenceResponsesRepository */
    private CorrespondenceResponsesRepository $correspondenceResponsesRepo;

    /**
     * CorrespondenceService constructor.
     * @param CorrespondenceRepository $correspondenceRepository
     * @param UserContactEmail $contactEmailRepository
     * @param CorrespondenceAttachments $correspondenceAttachmentsRepository
     * @param CorrespondenceResponsesRepository $correspondenceResponsesRepo
     */
    public function __construct(CorrespondenceRepository $correspondenceRepository, UserContactEmail $contactEmailRepository,
                                CorrespondenceAttachments $correspondenceAttachmentsRepository,
                                CorrespondenceResponsesRepository $correspondenceResponsesRepo) {
        $this->contactEmailRepository = $contactEmailRepository;
        $this->correspondenceRepository = $correspondenceRepository;
        $this->correspondenceResponsesRepo = $correspondenceResponsesRepo;
        $this->correspondenceAttachmentsRepository = $correspondenceAttachmentsRepository;
        $this->initFileSystemAdapter();
    }

    /**
     *
     */
    private function initFileSystemAdapter() {
        if (env("APP_ENV") == "local") {
            $this->coreAdapter = Storage::disk("local");
        } else {
            $this->coreAdapter = bucket_storage("core");
        }

        $this->localAdapter = Storage::disk("local");
    }

    /**
     * @param array $requestData
     * @param string $clientIp
     * @param string $clientHost
     * @param array $attachments
     * @return mixed
     * @throws \Exception
     */
    public function create(array $requestData, string $clientIp, string $clientHost, array $attachments) {
        $arrAdminEmails = ["swhite@arena.com"];

        if (config("app.env") === "prod") {
            $arrAdminEmails = ["devans@arena.com", "swhite@arena.com"];
        }

        /* Creating Insert Data Array */
        $arrInsertData = [];
        $objApp = Client::app();
        $arrInsertData["app_id"] = $objApp->app_id;
        $arrInsertData["app_uuid"] = $objApp->app_uuid;
        $arrInsertData["remote_addr"] = $clientIp;
        $arrInsertData["remote_host"] = $clientHost;
        $arrInsertData["email_subject"] = $requestData["subject"];
        $arrInsertData["correspondence_uuid"] = Util::uuid();

        $objContactEmail = $this->contactEmailRepository->find($requestData["email"]);

        if (is_null($objContactEmail)) {
            $arrInsertData["email_address"] = $requestData["email"];
        } else {
            $arrInsertData["email_id"] = $objContactEmail->row_id;
            $arrInsertData["email_uuid"] = $objContactEmail->row_uuid;
        }

        $arrInsertData["email_json"] = $requestData["json"];

        /* Insert Data */
        $objCorrespondence = $this->correspondenceRepository->create($arrInsertData);

        if (!empty($attachments)) {
            /* Insert Attachments in table */
            foreach ($attachments as $attachment) {
                $strFileName = $attachment->getClientOriginalName();
                $strFilePath = "public" . DIRECTORY_SEPARATOR . "correspondence" . DIRECTORY_SEPARATOR . "attachments" .
                    DIRECTORY_SEPARATOR . $objCorrespondence->correspondence_uuid;

                bucket_storage("core")->putFileAs($strFilePath, $attachment, $strFileName, "public");

                $arrFileData["file_name"] = $strFileName;
                $arrFileData["file_type"] = $attachment->getMimeType();
                $arrFileData["correspondence_id"] = $objCorrespondence->correspondence_id;
                $arrFileData["correspondence_uuid"] = $objCorrespondence->correspondence_uuid;

                $this->correspondenceAttachmentsRepository->create($arrFileData);
            }

            /* Make .zip file from attachments and upload to S3 */
            $this->attachmentsToZip($attachments, $objCorrespondence);
        }

        /* Send Mail */
        Mail::to($objCorrespondence->email)
            ->send(new CorrespondenceConfirmationMail($objCorrespondence->app, $objCorrespondence));
        Mail::to($arrAdminEmails)
            ->send(new CorrespondenceMail($objCorrespondence->app, $objCorrespondence));

        /* Send Notification */
        $flags = [
            "notification_state" => "unread",
            "flag_canarchive"    => true,
            "flag_candelete"     => true,
            "flag_email"         => false,
        ];

        $strMemo = "&quot;{$requestData["subject"]}&quot; by {$requestData["email"]}<br>" . ucfirst($objApp->app_name);

        $startContract = [
            "notification_name" => "Correspondence Received",
            "notification_memo" => $strMemo,
            "notification_url"  => app_url("office") . "customers/correspondence/" . $objCorrespondence->correspondence_uuid,
        ];

        $objAuthGroup = AuthGroup::where("group_name", "App.Office")->first();
        $objOfficeUsers = $objAuthGroup->users;

        foreach ($objOfficeUsers as $user) {
            event(new PrivateNotification($user, $startContract, $flags, $objApp));
        }

        return ($objCorrespondence);
    }

    public function attachmentsToZip(array $attachments, $objCorrespondence) {
        $zip = new ZipArchive();

        /* Create path for .zip archive */
        $localAdapterPath = "public" . DIRECTORY_SEPARATOR . "correspondence" . DIRECTORY_SEPARATOR . "attachments" .
            DIRECTORY_SEPARATOR . $objCorrespondence->correspondence_uuid;
        $zipPath = $localAdapterPath . DIRECTORY_SEPARATOR . $objCorrespondence->correspondence_uuid . ".zip";

        if ($this->coreAdapter->exists($zipPath)) {
            $this->coreAdapter->delete($zipPath);
        }

        if (!$this->localAdapter->exists($localAdapterPath)) {
            $this->localAdapter->makeDirectory($localAdapterPath);
        }

        /* Create .zip file and put to core bucket */
        if ($zip->open($this->localAdapter->path($zipPath), ZipArchive::CREATE)) {
            foreach ($attachments as $file) {
                $zip->addFile($file->getPathName(), $file->getClientOriginalName());
            }

            $boolRes = $zip->close();

            if ($boolRes === true) {
                $readStream = $this->localAdapter->readStream($zipPath);
                $this->coreAdapter->writeStream($zipPath, $readStream);
                $this->coreAdapter->setVisibility($zipPath, "public");
                $this->localAdapter->delete($zipPath);

                return (true);
            }

            return (false);
        }

        return (false);
    }

    /**
     * @param string $correspondence
     * @param array $arrParams
     * @return bool
     * @throws \Exception
     */
    public function responseForCorrespondence(string $correspondence, array $arrParams): bool {
        $objCorrespondence = $this->correspondenceRepository->find($correspondence);

        $objCorrespondenceResponse = $this->correspondenceResponsesRepo->create([
            "correspondence_id"   => $objCorrespondence->correspondence_id,
            "correspondence_uuid" => $objCorrespondence->correspondence_uuid,
            "response_message"    => $arrParams["text"],
        ]);

        if (!empty($arrParams["attachments"])) {
            foreach ($arrParams["attachments"] as $attachment) {
                bucket_storage("core")->putFileAs(
                    "public" . DIRECTORY_SEPARATOR . "correspondence" . DIRECTORY_SEPARATOR . "responses" .
                    DIRECTORY_SEPARATOR . "attachments" . DIRECTORY_SEPARATOR . $objCorrespondenceResponse->row_uuid,
                    $attachment,
                    $attachment->getClientOriginalName(),
                    "public"
                );
            }

            $objCorrespondenceResponse->update([
                "flag_attachments" => true,
            ]);
        }

        Mail::to($objCorrespondence->email)
            ->send(new CorrespondenceResponseMail($objCorrespondence->app, $objCorrespondenceResponse));

        return (true);
    }

    /**
     * @param string $strEmail
     * @param string $strSubject
     * @param string $strJson
     * @return mixed
     */
    public function checkDuplicate(string $strEmail, string $strSubject, string $strJson) {
        return $this->correspondenceRepository->checkDuplicate($strEmail, $strSubject, $strJson);
    }
}
