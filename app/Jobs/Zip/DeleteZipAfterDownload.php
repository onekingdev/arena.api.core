<?php

namespace App\Jobs\Zip;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteZipAfterDownload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $zipFilePath;

    /**
     * Create a new job instance.
     *
     * @param string $zipFilePath
     */
    public function __construct(string $zipFilePath)
    {
        $this->zipFilePath = $zipFilePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var \Illuminate\Filesystem\FilesystemAdapter $soundblockAdapter*/
        if (env("APP_ENV") == "local") {
            $soundblockAdapter = Storage::disk("local");
        } else {
            $soundblockAdapter = bucket_storage("soundblock");
        }

        $soundblockAdapter->delete($this->zipFilePath);
    }
}
