<?php

namespace App\Contracts\Soundblock\Data;

use App\Models\Soundblock\Data\UpcCode;

interface UpcCodes {
    public function find(string $strUpc): ?UpcCode;

    public function getUnused();
    public function useUpc(UpcCode $objUpc);
    public function freeUpc(UpcCode $objUpc);
}