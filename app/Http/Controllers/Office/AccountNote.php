<?php

namespace App\Http\Controllers\Office;

use Auth;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Account\GetAccountNote;
use App\Http\Requests\Office\Account\CreateAccountNote;
use App\Services\Soundblock\AccountNote as AccountNoteService;
use App\Http\Transformers\Soundblock\AccountNote as AccountNoteTransformer;
use App\Repositories\Common\AccountNoteAttachment as AccountNoteAttachmentRepository;

/**
 * @group Office Soundblock
 *
 */
class AccountNote extends Controller
{
    /** @var AccountNoteService */
    private AccountNoteService $noteService;

    /**
     * AccountNote constructor.
     * @param AccountNoteService $noteService
     */
    public function __construct(AccountNoteService $noteService){
        $this->noteService = $noteService;
    }

    /**
     * @param GetAccountNote $objRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response|object
     * @throws \Exception
     */
    public function index(GetAccountNote $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        [$objNotes, $availableMetaData] = $this->noteService->findAllByAccount($objRequest->all());

        return ($this->paginator($objNotes, new AccountNoteTransformer(["attachments"]), $availableMetaData));
    }

    /**
     * @param string $attachment
     * @param AccountNoteAttachmentRepository $accountAttachmentsRepo
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object|\Symfony\Component\HttpFoundation\StreamedResponse
     * @throws \Exception
     */
    public function getAttachment(string $attachment, AccountNoteAttachmentRepository $accountAttachmentsRepo){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $objAttachment = $accountAttachmentsRepo->find($attachment, true);

        return (bucket_storage("soundblock")->download($objAttachment->attachment_url));
    }

    /**
     * @param CreateAccountNote $objRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response|object
     * @throws \Exception
     */
    public function store(CreateAccountNote $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objNote = $this->noteService->create($objRequest->all());

        return ($this->item($objNote, new AccountNoteTransformer(["attachments"])));
    }
}
