<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Core\AppsPages as AppsPagesContract;
use App\Repositories\Core\AppsPages as AppsPagesRepository;
use App\Http\{Controllers\Controller, Transformers\Core\AppsPage, Requests\Core\CreatePage, Requests\Core\GetPageByUrl};

/**
 * @group Core
 *
 */
class AppsPages extends Controller {
    /** @var AppsPagesRepository */
    private AppsPagesRepository $pagesRepository;

    private AppsPagesContract $appsPages;

    /**
     * PagesController constructor.
     * @param AppsPagesRepository $pagesRepository
     */
    public function __construct(AppsPagesRepository $pagesRepository) {
        $this->appsPages = resolve(AppsPagesContract::class);
        $this->pagesRepository = $pagesRepository;
    }

    /**
     * @return object
     */
    public function getPages() {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        return ($this->apiReply($this->appsPages->getPages()));
    }

    /**
     * @param GetPageByUrl $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPageByUrl(GetPageByUrl $request){
        $objPage = $this->appsPages->getPageByURL($request->input("page_url"), $request->input("struct_uuid"));

        return ($this->item($objPage, new AppsPage));
    }

    /**
     * @param string $pageUuid
     * @return mixed
     */
    public function getPageByUuid(string $pageUuid) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objPage = $this->appsPages->getPageByUuid($pageUuid);

        return ($this->item($objPage, new AppsPage));
    }

    /**
     * @param CreatePage $request
     * @return mixed
     * @throws \Exception
     */
    public function addNewPage(CreatePage $request) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objPage = $this->appsPages->createPage($request->only([
            "struct_uuid",
            "page_url",
            "meta",
            "params",
            "content",
        ]));

        return ($this->item($objPage, new AppsPage));
    }

    /**
     * @param string $pageUuid
     * @return mixed
     */
    public function deletePageByUuid(string $pageUuid) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $boolResult = $this->pagesRepository->delete($pageUuid);

        if ($boolResult) {
            return ($this->apiReply(null, "Page deleted successfully."));
        }

        return ($this->apiReject(null, "Page haven't deleted."));
    }
}
