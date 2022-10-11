<?php

namespace App\Http\Transformers\Soundblock;

use App\Traits\StampCache;
use App\Http\Transformers\BaseTransformer;
use App\Models\Soundblock\Files\FileMerch as FileMerchModel;

class FileMerch extends BaseTransformer
{
    use StampCache;

    public function transform(FileMerchModel $objFileMerch)
    {

        $arrStamp = $this->stamp($objFileMerch);

        if ($objFileMerch->file)
        {
            $objFile = $objFileMerch->file;
            $arrStamp = array_merge($arrStamp, $objFile->toArray());
        }

        return($arrStamp);
    }
}
