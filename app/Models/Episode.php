<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;

class Episode
{
    private int $id;
    private string $name;
    private Carbon $airDate;
    private string $episode;
    private ?CharacterCollection $characters;

    public function __construct(
        int $id,
        string $name,
        Carbon $airDate,
        string $episode,
        ?CharacterCollection $characters = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->airDate = $airDate;
        $this->episode = $episode;
        $this->characters = $characters;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAirDate(): Carbon
    {
        return $this->airDate;
    }

    public function getEpisode(): string
    {
        return $this->episode;
    }

    public function getCharacters(): ?CharacterCollection
    {
        return $this->characters;
    }

    public function setCharacters(?CharacterCollection $characters): void
    {
        $this->characters = $characters;
    }
    public function matchesSearchQuery(string $query): bool
    {
        return stripos((string)$this->getId(), $query) !== false
            || stripos($this->getName(), $query) !== false
            || stripos($this->getEpisode(), $query) !== false;
    }
}
