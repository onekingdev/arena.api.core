<?php


namespace App\Helpers;

use App\Models\Soundblock\Accounts\Account;
use Illuminate\Support\Facades\Storage;

class Soundblock
{
    private function initFileSystemAdapter() {
        if (env("APP_ENV") != "local") {
            $this->soundblockAdapter = Storage::disk("local");
        } else {
            $this->soundblockAdapter = bucket_storage("soundblock");
        }
    }

    public function account_directory_size(Account $objAccount){
        $this->initFileSystemAdapter();
        $totalSize = 0;
        foreach ($this->soundblockAdapter->allFiles($this->account_path($objAccount)) as $filePath) {
            $totalSize += $this->soundblockAdapter->getSize($filePath);
        }

        return ($totalSize);
    }

    public function account_path(Account $objAccount){
        return ("accounts/{$objAccount->account_uuid}");
    }
}
