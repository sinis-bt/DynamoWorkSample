<?php

declare(strict_types=1);

namespace App\Domain\Laureate;

interface LaureateRepository
{
    public function getMostRecent20(): array;
}
