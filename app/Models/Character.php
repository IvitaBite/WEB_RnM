<?php

declare(strict_types=1);

namespace App\Models;

class Character
{
    private string $name;
    private string $species;
    private string $gender;
    private string $origin;
    private string $image;
    private string $status;

    public function __construct(
        string $name,
        string $species,
        string $gender,
        string $origin,
        string $image,
        string $status
    )
    {
        $this->name = $name;
        $this->species = $species;
        $this->gender = $gender;
        $this->origin = $origin;
        $this->image = $image;
        $this->status = $status;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSpecies(): string
    {
        return $this->species;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getOrigin(): string
    {
        return $this->origin;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}