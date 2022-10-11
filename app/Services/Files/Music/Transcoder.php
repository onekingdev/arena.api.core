<?php

namespace App\Services\Files\Music;

use App\Helpers\Filesystem\Music;
use App\Models\Music\Core\TranscoderJob;
use App\Repositories\Music\Core\TranscoderJob as TranscoderJobRepository;
use App\Support\Files\File;
use Aws\ElasticTranscoder\ElasticTranscoderClient;
use App\Contracts\File\Music\Transcoder as TranscoderContract;

class Transcoder implements TranscoderContract {
    /*
     * MP3 320K Preset AWS Info
     * */
    const MP3_320K = [
        "id"        => "1351620000001-300010",
        "extension" => "mp3",
        "name"      => "320k",
    ];
    /*
     * MP3 192K Preset AWS Info
     * */
    const MP3_192K = [
        "id"        => "1351620000001-300020",
        "extension" => "mp3",
        "name"      => "192k",
    ];
    /*
     * MP3 160K Preset AWS Info
     * */
    const MP3_160K = [
        "id"        => "1351620000001-300030",
        "extension" => "mp3",
        "name"      => "160k",
    ];
    /*
     * MP3 128K Preset AWS Info
     * */
    const MP3_128K = [
        "id"        => "1351620000001-300040",
        "extension" => "mp3",
        "name"      => "128k",
    ];
    /*
     * FLAC Preset AWS Info
     * */
    const FLAC = [
        "id"        => "1351620000001-300040",
        "extension" => "flac",
        "name"      => "flac",
    ];
    /*
     * WAV 8 BIT Preset AWS Info
     * */
    const WAV_8BIT = [
        "id"        => "1351620000001-300200",
        "extension" => "wav",
        "name"      => "8bit",
    ];
    /*
     * WAV 16 BIT Preset AWS Info
     * */
    const WAV_16BIT = [
        "id"        => "1351620000001-300300",
        "extension" => "wav",
        "name"      => "16bit",
    ];

    /**
     * @var ElasticTranscoderClient
     */
    private ElasticTranscoderClient $awsTranscoder;
    /**
     * @var TranscoderJobRepository
     */
    private TranscoderJobRepository $transcoderJob;
    private string $strPipelineId;

    /**
     * Transcoder constructor.
     * @param ElasticTranscoderClient $awsTranscoder
     * @param TranscoderJobRepository $transcoderJob
     * @param string $strPipelineId
     */
    public function __construct(ElasticTranscoderClient $awsTranscoder, TranscoderJobRepository $transcoderJob, string $strPipelineId) {
        $this->awsTranscoder = $awsTranscoder;
        $this->transcoderJob = $transcoderJob;
        $this->strPipelineId = $strPipelineId;
    }

    public function run(File $objFile, string $strOutput, $presets): array {
        if (is_string($presets)) {
            $presets = [$presets];
        }

        if (!is_array($presets)) {
            throw new \Exception("Invalid Presets Format.");
        }

        $arrTranscoderOutputConf = [];

        foreach ($presets as $preset) {
            $arrTranscoderOutputConf[] = [
                "Key"      => Music::track_bitrate_path($strOutput, $preset["name"], $preset["extension"]),
                "PresetId" => $preset["id"],
            ];
        }

        $objResponse = $this->awsTranscoder->createJob([
            'PipelineId' => $this->strPipelineId,
            'Input'      => ['Key' => $objFile->getFullName()],
            'Outputs'    => $arrTranscoderOutputConf,
        ]);

        return $objResponse->toArray();
    }

    /**
     * @param string $jobId
     * @param string $status
     * @return TranscoderJob
     * @throws \Exception
     */
    public function updateStatus(string $jobId, string $status): TranscoderJob {
        return $this->transcoderJob->updateStatus($jobId, $status);
    }
}