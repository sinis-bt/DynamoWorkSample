<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\Laureate;

use App\Domain\Laureate\Laureate;
use App\Infrastructure\LaureateFetcher\LaureateFetcher;
use App\Infrastructure\Persistence\Laureate\InMemoryLaureateRepository;
use DateTime;
use Tests\TestCase;

/**
 * @method assertEquals(int $int, array $getMostRecent20)
 */
class InMemoryLaureateRepositoryTest extends TestCase
{
    public function testFind20Laureates()
    {
        $mappedLaureates = [
            [new Laureate(id: 1, fullName: 'Jon Fosse', birthDate: new DateTime('1959-09-29'), nativeCountry: 'Norway', category: 'Literature', dateAwarded: new DateTime('2023-10-05'))],
            [new Laureate(id: 2, fullName: 'Jon Fosse', birthDate: new DateTime('1959-09-29'), nativeCountry: 'Norway', category: 'Literature', dateAwarded: new DateTime('2023-10-05'))],
            [new Laureate(id: 3, fullName: 'Jon Fosse', birthDate: new DateTime('1959-09-29'), nativeCountry: 'Norway', category: 'Literature', dateAwarded: new DateTime('2023-10-05'))],
            [new Laureate(id: 4, fullName: 'Jon Fosse', birthDate: new DateTime('1959-09-29'), nativeCountry: 'Norway', category: 'Literature', dateAwarded: new DateTime('2023-10-05'))],
            [new Laureate(id: 5, fullName: 'Jon Fosse', birthDate: new DateTime('1959-09-29'), nativeCountry: 'Norway', category: 'Literature', dateAwarded: new DateTime('2023-10-05'))],
            [new Laureate(id: 6, fullName: 'Jon Fosse', birthDate: new DateTime('1959-09-29'), nativeCountry: 'Norway', category: 'Literature', dateAwarded: new DateTime('2023-10-05'))],
            [new Laureate(id: 7, fullName: 'Jon Fosse', birthDate: new DateTime('1959-09-29'), nativeCountry: 'Norway', category: 'Literature', dateAwarded: new DateTime('2023-10-05'))],
            [new Laureate(id: 8, fullName: 'Jon Fosse', birthDate: new DateTime('1959-09-29'), nativeCountry: 'Norway', category: 'Literature', dateAwarded: new DateTime('2023-10-05'))],
            [new Laureate(id: 9, fullName: 'Jon Fosse', birthDate: new DateTime('1959-09-29'), nativeCountry: 'Norway', category: 'Literature', dateAwarded: new DateTime('2023-10-05'))],
            [new Laureate(id: 10, fullName: 'Jon Fosse', birthDate: new DateTime('1959-09-29'), nativeCountry: 'Norway', category: 'Literature', dateAwarded: new DateTime('2023-10-05'))],
            [new Laureate(id: 11, fullName: 'Jon Fosse', birthDate: new DateTime('1959-09-29'), nativeCountry: 'Norway', category: 'Literature', dateAwarded: new DateTime('2023-10-05'))],
            [new Laureate(id: 12, fullName: 'Jon Fosse', birthDate: new DateTime('1959-09-29'), nativeCountry: 'Norway', category: 'Literature', dateAwarded: new DateTime('2023-10-05'))],
            [new Laureate(id: 13, fullName: 'Jon Fosse', birthDate: new DateTime('1959-09-29'), nativeCountry: 'Norway', category: 'Literature', dateAwarded: new DateTime('2023-10-05'))],
            [new Laureate(id: 14, fullName: 'Jon Fosse', birthDate: new DateTime('1959-09-29'), nativeCountry: 'Norway', category: 'Literature', dateAwarded: new DateTime('2023-10-05'))],
            [new Laureate(id: 15, fullName: 'Jon Fosse', birthDate: new DateTime('1959-09-29'), nativeCountry: 'Norway', category: 'Literature', dateAwarded: new DateTime('2023-10-05'))],
            [new Laureate(id: 16, fullName: 'Jon Fosse', birthDate: new DateTime('1959-09-29'), nativeCountry: 'Norway', category: 'Literature', dateAwarded: new DateTime('2023-10-05'))],
            [new Laureate(id: 17, fullName: 'Jon Fosse', birthDate: new DateTime('1959-09-29'), nativeCountry: 'Norway', category: 'Literature', dateAwarded: new DateTime('2023-10-05'))],
            [new Laureate(id: 18, fullName: 'Jon Fosse', birthDate: new DateTime('1959-09-29'), nativeCountry: 'Norway', category: 'Literature', dateAwarded: new DateTime('2023-10-05'))],
            [new Laureate(id: 19, fullName: 'Jon Fosse', birthDate: new DateTime('1959-09-29'), nativeCountry: 'Norway', category: 'Literature', dateAwarded: new DateTime('2023-10-05'))],
            [new Laureate(id: 20, fullName: 'Jon Fosse', birthDate: new DateTime('1959-09-29'), nativeCountry: 'Norway', category: 'Literature', dateAwarded: new DateTime('2023-10-05'))]
        ];

        $laureateFetcherMock = $this->getMockBuilder(LaureateFetcher::class)
            ->onlyMethods(['get20RecentLaureates'])
            ->getMock();

        $laureateFetcherMock->expects($this->once())
            ->method('get20RecentLaureates')
            ->willReturn($mappedLaureates);

        $laureateRepository = new InMemoryLaureateRepository($laureateFetcherMock);
        $this->assertEquals(20, count($laureateRepository->getMostRecent20()));
    }
}
