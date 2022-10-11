<?php

namespace App\Exceptions\Soundblock;

use Exception;
use App\Models\Soundblock\Platform;
use App\Models\Soundblock\Collections\Collection;

class ProjectException extends Exception
{
    //

    public function __construct(string $message ="", $code = 0, Exception $previous  = null)
    {
        if ($code == 0)
            $code = 417;
        parent::__construct($message, $code, $previous);
    }

    public static function canNotDeploy(Collection $objCol, Platform $objPlatform, $code = 422, Exception $previous  = null)
    {
        $message = sprintf("Collection(%s) is deployed on platform(%s) already.", $objCol->collection_uuid, $objPlatform->platform_uuid);

        return(new static($message, $code, $previous));
    }
}
