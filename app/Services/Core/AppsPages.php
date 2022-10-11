<?php

namespace App\Services\Core;

use Illuminate\Support\Facades\Storage;
use App\Models\Core\AppsPage as AppsPageModel;
use App\Contracts\Core\AppsPages as AppsPagesContract;
use App\Repositories\Core\AppsPages as AppsPagesRepository;

class AppsPages implements AppsPagesContract{
    /** @var AppsPagesRepository */
    private AppsPagesRepository $pagesRepository;
    /** @var PageStructure */
    private PageStructure $pageStructureService;

    /**
     * PagesService constructor.
     * @param PageStructure $pageStructureService
     * @param AppsPagesRepository $pagesRepository
     */
    public function __construct(PageStructure $pageStructureService, AppsPagesRepository $pagesRepository) {
        $this->pagesRepository      = $pagesRepository;
        $this->pageStructureService = $pageStructureService;
    }

    /**
     * @return mixed
     */
    public function getPages(){
        $objPages = $this->pagesRepository->all();

        return ($objPages);
    }

    /**
     * @param string $pageURL
     * @param string $structUuid
     * @return mixed
     * @throws \Exception
     */
    public function getPageByURL(string $pageURL, string $structUuid){
        $objPage = $this->pagesRepository->findByUrl($pageURL, $structUuid);

        if (is_null($objPage)) {
            throw new \Exception("Page Not Found.", 404);
        }

        return ($objPage);
    }

    /**
     * @param string $pageUuid
     * @return AppsPageModel
     * @throws \Exception
     */
    public function getPageByUuid(string $pageUuid){
        $objPage = $this->pagesRepository->findByUuid($pageUuid);

        if (is_null($objPage)) {
            throw new \Exception("Page Not Found.", 404);
        }

        return ($objPage);
    }
    /**
     * @param array $requestData
     * @return mixed
     * @throws \Exception
     */
    public function createPage(array $requestData): AppsPageModel{
        $arrInsertData = [];
        $objStruct = $this->pageStructureService->getStructureByUuid($requestData["struct_uuid"]);

        $arrInsertData["struct_id"]   = $objStruct->struct_id;
        $arrInsertData["struct_uuid"] = $requestData["struct_uuid"];
        $arrInsertData["page_url"]    = $requestData["page_url"];

        if (isset($requestData["meta"]["page_image"])) {
            foreach ($requestData["meta"]["page_image"] as $key => $file){
                if (!is_null($file)){
                    $strFileName = md5($file->getClientOriginalName() . time()) .
                        "." . $file->getClientOriginalExtension();
                    $strFilePath = "pages";

                    Storage::disk("local")->putFileAs(
                        $strFilePath,
                        $file,
                        $strFileName,
                        "public"
                    );

                    unset($requestData["meta"]["page_image"][$key]);
                    $requestData["meta"]["page_image"][$key] = $strFileName;
                }
            }
        }

        foreach ($requestData["content"] as $key => $value){
            $requestData["content"][$key] = $this->deleteAllBetween("<script>", "</script>", $requestData["content"][$key]);
        }

        $arrInsertData["page_json"]["meta"]    = $requestData["meta"];
        $arrInsertData["page_json"]["params"]  = $requestData["params"];
        $arrInsertData["page_json"]["content"] = $requestData["content"];

        $objPage = $this->pagesRepository->create($arrInsertData);

        return ($objPage);
    }

    private function deleteAllBetween($beginning, $end, $string) {
        $beginningPos = strpos($string, $beginning);
        $endPos = strpos($string, $end);
        if ($beginningPos === false || $endPos === false) {
            return $string;
        }

        $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

        return $this->deleteAllBetween($beginning, $end, str_replace($textToDelete, '', $string));
    }
}
