<?php

namespace App\Services\Core;

use Symfony\Component\Process\Process;
use App\Contracts\Core\Sox as SoxContract;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Sox implements SoxContract {
    public function getInfo(string $strFilePath) {
        $process = new Process(['sox', '--i', $strFilePath]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return ($this->parseOutput($process->getOutput()));
    }

    private function parseOutput(string $strOutput): array {
        $arrOutput = [];

        $strOutput = trim($strOutput);
        $arrData = explode("\n", $strOutput);

        foreach ($arrData as $strData) {
            $arrInfo = explode(": ", $strData);
            $arrOutput[trim(array_shift($arrInfo))] = implode("", $arrInfo);
        }

        return $arrOutput;
    }

    public function convert(string $strFilePath) {
        $bnOutOfRange = false;
        $arrCommand = ['sox', $strFilePath];
        $arrData = $this->getInfo($strFilePath);

        if (strpos($arrData["Sample Encoding"], "Signed Integer") === false) {
            $bnOutOfRange = true;
            $arrCommand = array_merge($arrCommand, ["-e", "signed-integer"]);
        }

        if ($arrData["Sample Encoding"] !== "32-bit") {
            $bnOutOfRange = true;
            $arrCommand = array_merge($arrCommand, ["-b", 32]);
        }

        if ($arrData["Sample Rate"] !== "192000") {
            $bnOutOfRange = true;
            $arrCommand = array_merge($arrCommand, ["-r", 192000]);
        }

        if ($bnOutOfRange === false) {
            return $strFilePath;
        }

        $strFileExtension = pathinfo($strFilePath, PATHINFO_EXTENSION);
        $strOutputFilePath = substr($strFilePath, 0, strpos($strFilePath, ".$strFileExtension")) . "_processed.$strFileExtension";
        $arrCommand = array_merge($arrCommand, [$strOutputFilePath]);

        $process = new Process($arrCommand);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $strOutputFilePath;
    }
}