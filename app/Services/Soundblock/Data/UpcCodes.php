<?php

namespace App\Services\Soundblock\Data;

use App\Contracts\Soundblock\Data\UpcCodes as UpcCodesContract;
use App\Models\Soundblock\Data\UpcCode;

class UpcCodes implements UpcCodesContract {
    private \App\Repositories\Soundblock\UpcCodes $upcCodesRepo;

    /**
     * UpcCodes constructor.
     * @param \App\Repositories\Soundblock\UpcCodes $upcCodesRepo
     */
    public function __construct(\App\Repositories\Soundblock\UpcCodes $upcCodesRepo) {
        $this->upcCodesRepo = $upcCodesRepo;
    }

    public function getUnused() {
        return $this->upcCodesRepo->geUnused();
    }

    public function useUpc(UpcCode $objUpc) {
        return $this->upcCodesRepo->useUpc($objUpc);
    }

    public function find(string $strUpc): ?UpcCode {
        return $this->upcCodesRepo->findByUpc($strUpc);
    }

    public function freeUpc(UpcCode $objUpc) {
        return $this->upcCodesRepo->freeUpc($objUpc);
    }
}