<?php

namespace App\Http\Controllers\Office;

use Exception;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth as AuthFacade;
use App\Services\{Auth, Office\Contact as ContactService};
use App\Http\Transformers\Office\Contact as ContactTransformer;
use App\Http\Requests\Office\Contact\{CreateContact, GetContactsByAccess, UpdateContact};

/**
 * @group Office Contact
 *
 */
class Contact extends Controller {
    /** @var Auth */
    protected Auth $authService;
    /** @var ContactService */
    private ContactService $contactService;

    /**
     * @param Auth $authService
     * @param ContactService $contactService
     */
    public function __construct(Auth $authService, ContactService $contactService) {
        $this->authService = $authService;
        $this->contactService = $contactService;
    }

    /**
     * @param GetContactsByAccess $request
     * @return object
     * @throws Exception
     */
    public function getByAccess(GetContactsByAccess $request) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        [$contacts, $availableMetaData] = $this->contactService->getContactsByAccessUser($request->all());

        return ($this->apiReply($contacts, "", Response::HTTP_OK, $availableMetaData));
    }


    /**
     * @param string $contact
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function show(string $contact) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $contact = $this->contactService->find($contact);

        return ($this->item($contact, new ContactTransformer(["user"])));
    }

    /**
     * @param CreateContact $request
     * @return object
     * @throws Exception
     */
    public function store(CreateContact $request) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $this->contactService->createContact($request->all());

        return ($this->apiReply(null, "Created a contact.", 201));
    }

    /**
     * @param string $contact
     * @param UpdateContact $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function update(string $contact, UpdateContact $request) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $contact = $this->contactService->find($contact);
        $contact = $this->contactService->updateAccess($contact, $request->all());

        return ($this->item($contact, new ContactTransformer(["user"])));
    }
}
