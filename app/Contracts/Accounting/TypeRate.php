<?php

namespace App\Contracts\Accounting;

interface TypeRate
{
    public function getCharges();
    public function saveCharges(array $requestData);
    public function updateTypeRate(array $requestData, string $typeRateUuid);
    public function deleteTypeRate(string $typeRateUuid);
}
