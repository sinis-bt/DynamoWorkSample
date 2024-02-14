<?php

declare(strict_types=1);

namespace App\Domain\Laureate;

use DateTime;
use JsonSerializable;

class Laureate implements JsonSerializable
{
    public function __construct(
        private readonly int                $id,
        private readonly ?string            $fullName,
        private readonly ?DateTime          $birthDate,
        private readonly ?string            $nativeCountry,
        private readonly ?string            $category,
        private readonly ?DateTime          $dateAwarded
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function getBirthDate(): ?DateTime
    {
        return $this->birthDate;
    }

    public function getNativeCountry(): ?string
    {
        return $this->nativeCountry;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function getDateAwarded(): ?DateTime
    {
        return $this->dateAwarded;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize() : array
    {
        return [
            'id' => $this->id,
            'fullName' => $this->fullName,
            'birthDate' => $this->birthDate,
            'nativeCountry'=> $this->nativeCountry,
            'category' => $this->category,
            'dateAwarded' => $this->dateAwarded,
        ];
    }
}
