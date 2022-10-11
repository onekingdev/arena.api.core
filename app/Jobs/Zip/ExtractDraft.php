<?php

namespace App\Jobs\Zip;

use Illuminate\Bus\Queueable;
use App\Services\Common\Zip;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Soundblock\{Projects\ProjectDraft, Accounts\Account};
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};

class ExtractDraft implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $storagePath;

    protected Account $objAccount;

    protected ProjectDraft $objDraft;

    /**
     * Create a new job instance.
     *
     * @param string $storagePath
     * @param Account $objAccount
     * @param ProjectDraft $objDraft
     */
    public function __construct(string $storagePath, Account $objAccount, ProjectDraft $objDraft) {
        $this->storagePath = $storagePath;
        $this->objAccount = $objAccount;
        $this->objDraft = $objDraft;
    }

    /**
     * Execute the job.
     *
     * @param Zip $zipService
     * @return void
     */
    public function handle(Zip $zipService) {
        //
        $zipService->unzipDraft($this->storagePath, $this->objAccount, $this->objDraft);
    }
}
