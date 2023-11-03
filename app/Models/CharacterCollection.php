<?php

declare(strict_types=1);

namespace App\Models;

class CharacterCollection
{
    private array $characters;

    public function __construct(array $characters = [])
    {
        foreach ($characters as $character) {
            $this->add($character);
        }
    }

    public function getCharacters(): array
    {
        return $this->characters;
    }

    public function add(Character $character)
    {
        $this->characters [] = $character;
    }
}