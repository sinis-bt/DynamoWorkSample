<?php

declare(strict_types=1);

namespace Tests\Domain\Laureate;

use App\Domain\Laureate\Laureate;
use DateTime;
use Tests\TestCase;

class LaureateTest extends TestCase
{
    public function LaureateProvider(): array
    {
        return [
            [1, 'Louis E. Brus', '1942-11-30', 'USA', 'Chemistry', '2023-10-04'],
            [2, 'Ferenc Krausz', '1962-05-17', 'Hungary', 'Physics', '2023-10-03'],
            [3, 'Drew Weissman', '1959-09-07', 'USA', 'Physiology or Medicine', '2023-10-02'],
            [4, 'Ales Bialiatski', '1962-09-25', 'Russia', 'Peace', '2022-10-07'],
            [5, 'Annie Ernaux', '1940-09-01', 'France', 'Literature', '2022-10-06']
        ];
    }

    /**
     * @dataProvider LaureateProvider
     * @param int $id
     * @param string $fullName
     * @param string $birthDate
     * @param string $nativeCountry
     * @param string $category
     * @param string $awardDate
     * @throws Exception
     */
    public function testGetters(int $id,
                                string $fullName,
                                string $birthDate,
                                string $nativeCountry,
                                string $category,
                                string $awardDate)
    {
        $birthDate = new DateTime($birthDate);
        $awardDate = new DateTime($awardDate);
        $laureate = new Laureate($id, $fullName, $birthDate, $nativeCountry, $category, $awardDate);

        $this->assertEquals($id, $laureate->getId());
        $this->assertEquals($fullName, $laureate->getFullName());
        $this->assertEquals($birthDate, $laureate->getBirthDate());
        $this->assertEquals($nativeCountry, $laureate->getNativeCountry());
        $this->assertEquals($category, $laureate->getCategory());
        $this->assertEquals($awardDate, $laureate->getDateAwarded());
    }

    /**
     * @dataProvider laureateProvider
     * @param int $id
     * @param string $fullName
     * @param string $birthDate
     * @param string $nativeCountry
     * @param string $category
     * @param string $awardDate
     * @throws Exception
     */
    public function testJsonSerialize(
        int $id,
        string $fullName,
        string $birthDate,
        string $nativeCountry,
        string $category,
        string $awardDate
    ) {
        $birthDateDateTime = new DateTime($birthDate);
        $awardDateDateTime = new DateTime($awardDate);
        $laureate = new Laureate($id, $fullName, $birthDateDateTime, $nativeCountry, $category, $awardDateDateTime);

        $expectedPayload = json_encode([
            'id' => $laureate->getId(),
            'fullName' => $laureate->getFullName(),
            'birthDate' => $laureate->getBirthDate()->format("Y-m-d"),
            'nativeCountry' => $laureate->getNativeCountry(),
            'category' => $laureate->getCategory(),
            'dateAwarded' => $laureate->getDateAwarded()->format("Y-m-d"),
        ]);

        $this->assertEquals($expectedPayload, json_encode($laureate));
    }
}
