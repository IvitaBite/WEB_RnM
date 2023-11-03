<?php

declare(strict_types=1);

namespace App\Models;

class Season
{
    private int $seasonId;
    private string $seasonName;

    public function __construct(int $seasonId, string $seasonName)
    {
        $this->seasonId = $seasonId;
        $this->seasonName = $seasonName;
    }

    public function getSeasonId(): int
    {
        return $this->seasonId;
    }

    public function getSeasonName(): string
    {
        return $this->seasonName;
    }
}