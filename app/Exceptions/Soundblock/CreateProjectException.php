<?php

namespace App\Exceptions\Soundblock;

use Exception;
use App\Models\Soundblock\Projects\Project;

class CreateProjectException extends Exception {
    protected ?Project $objProject;

    public function __construct(Project $objProject = null, $message = "", $code = 0, Exception $previous = null) {
        $this->objProject = $objProject;
        $code = 417;

        parent::__construct($message, $code, $previous);
    }

    public static function collectionExistsAlready(Project $objProject, $message = "", $code = 417, Exception $previous = null) {
        if ($message == "") {
            $message = sprintf("Project (%s) has collection already", $objProject->project_uuid);
        }

        return (new static($objProject, $message, $code, $previous));
    }
}
