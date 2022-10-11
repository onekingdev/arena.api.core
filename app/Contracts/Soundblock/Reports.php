<?php

namespace App\Contracts\Soundblock;

interface Reports {
    public function store($file): array;
    public function storeProjectUsersRevenue(string $dateStarts, string $dateEnds): bool;
}
