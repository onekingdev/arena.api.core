<?php

namespace App\Exceptions\Soundblock;

use App\Models\Soundblock\Files\Directory;
use App\Models\Soundblock\Collections\Collection;
use Exception;

class CollectionException extends Exception {
    public function __construct($message = "", $code = 0, Exception $previous = null) {
        $message = "Can't create new Collection.";
        $code = 417;
        parent::__construct($message, $code, $previous);
    }

    public static function unableToCreateDir(Directory $objDir, Collection $objCol, $message = "", $code = 417, Exception $previous = null) {
        if ($message == "") {
            $message = sprintf("Directory (%s) exists already in collection (%s)", $objDir->directory_name, $objCol->collection_uuid);
        }
        return (new static($message, $code, $previous));
    }
}
