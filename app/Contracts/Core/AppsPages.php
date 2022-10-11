<?php

namespace App\Contracts\Core;

use App\Models\Core\AppsPage;

interface AppsPages {
    public function getPages();
    public function getPageByURL(string $pageURL, string $structUuid);
    public function getPageByUuid(string $pageUuid);
    public function createPage(array $requestData): AppsPage;
}