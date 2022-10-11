<?php
namespace App\Http\Transformers\Soundblock;

use App\Traits\StampCache;
use App\Http\Transformers\BaseTransformer;
use App\Models\Soundblock\Files\FileOther as FileOtherModel;

class FileOther extends BaseTransformer
{

    use StampCache;

    public function transform(FileOtherModel $objFileOther)
    {
        $response = array();
        if ($objFileOther->file)
        {
            $response = $objFileOther->file->toArray();
        }
        $response = array_merge($response, $this->stamp($objFileOther));

        return($response);
    }
}
