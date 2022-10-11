<?php

namespace App\Rules\Soundblock\Collection;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class UploadFile implements Rule {
    private string $strMessage = "Invalid Files.";
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value) {
        $intZipCount = 0;

        /** @var UploadedFile $objFile */
        foreach ($value as $objFile) {
            if ($objFile->getClientMimeType() == "application/zip") {
                $intZipCount++;
            }
        }

        $intCommonFileCount = count($value) - $intZipCount;

        if ($intZipCount > 0 && $intCommonFileCount > 0) {
            $this->strMessage = "You Cannot Send Zip With Another Files.";

            return false;
        }

        if ($intZipCount !==  1&& $intCommonFileCount === 0) {
            $this->strMessage = "Only One Zip Allowed.";

            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {
        return $this->strMessage;
    }
}
