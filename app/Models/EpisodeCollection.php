<?php

declare(strict_types=1);

namespace App\Models;

class EpisodeCollection
{
    private array $episodes = [];

    public function __construct(array $episodes = [])
    {
        foreach ($episodes as $episode) {
            $this->add($episode);
        }
    }

    public function getEpisodes(): array
    {
        return $this->episodes;
    }

    public function add(Episode $episode)
    {
        $this->episodes[] = $episode;
    }
}