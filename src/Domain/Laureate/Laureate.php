<?php

declare(strict_types=1);

namespace App\Domain\Laureate;

use DateTime;
use JsonSerializable;

class Laureate implements JsonSerializable
{
    public function __construct(
        private int                $id,
        private ?string            $fullName,
        private ?DateTime          $birthDate,
        private ?string            $nativeCountry,
        private ?string            $category,
        private ?DateTime          $dateAwarded
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
            'birthDate' => $this->birthDate?->format("Y-m-d"),
            'nativeCountry'=> $this->nativeCountry,
            'category' => $this->category,
            'dateAwarded' => $this->dateAwarded?->format("Y-m-d"),
        ];
    }
}
