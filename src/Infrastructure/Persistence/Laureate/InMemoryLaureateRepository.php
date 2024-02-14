<?php

namespace App\Infrastructure\Persistence\Laureate;

use App\Domain\Laureate\Laureate;
use App\Domain\Laureate\LaureateRepository;
use App\Infrastructure\LaureateFetcher\LaureateFetcher;

class InMemoryLaureateRepository implements LaureateRepository
{
    public function __construct(private LaureateFetcher $laureateFetcher)
    {
    }

    /**
     * @throws \Exception
     */
    public function getMostRecent20(): array
    {
        return $this->laureateFetcher->get20RecentLaureates();
    }
}
