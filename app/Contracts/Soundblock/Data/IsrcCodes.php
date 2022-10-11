<?php

namespace App\Contracts\Soundblock\Data;

use App\Models\Soundblock\Data\IsrcCode;

interface IsrcCodes {
    public function getUnused();
    public function useIsrc(IsrcCode $isrcCode);
}