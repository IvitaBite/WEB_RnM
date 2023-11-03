<?php

declare(strict_types=1);

namespace App\Models;

class SeasonCollection
{
    private array $seasons = [];

    public function __construct(array $seasons = [])
    {
        foreach ($seasons as $season) {
            $this->add($season);
        }
    }

    public function getSeasons(): array
    {
        return $this->seasons;
    }

    public function add(Season $season)
    {
        $this->seasons[] = $season;
    }
}
