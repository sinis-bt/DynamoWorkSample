<?php

namespace App\Infrastructure\LaureateFetcher;

use App\Domain\Laureate\Laureate;
use DateTime;
use Exception;
use RuntimeException;

class LaureateFetcher
{
    private const API_BASE_URL = 'https://api.nobelprize.org/2.1/laureates';
    private const DEFAULT_YEAR_RANGE = 2;

    /**
     * Fetches the most recent Nobel Prize laureates from the API.
     *
     * @param int $yearRange Number of years to go back from the current year.
     * @return array Array of laureates' information.
     * @throws RuntimeException If there is an error fetching data from the API.
     * @throws RuntimeException|Exception If there is an error decoding JSON data.
     */
    public function getRecentLaureates(int $yearRange) : array
    {

        $currentYear = date('Y');
        $startYear = $currentYear - $yearRange;
        $url = self::API_BASE_URL . "?nobelPrizeYear=$startYear&yearTo=$currentYear";

        $response = file_get_contents($url);

        if ($response === false) {
            // Handle the error, such as connection issues
            throw new Exception('Error fetching data from the API');
        }

        // Decode the JSON response
        $data = json_decode($response, true);

        if ($data === null) {
            // Handle JSON decoding errors
            throw new Exception('Error decoding JSON data');
        }

        // Extract and return the relevant information
        return $this->mapToLaureates($data["laureates"]);
    }

    /**
     * @throws Exception
     */
    public function get20RecentLaureates(): array
    {
        $listOfLaureates = $this->getRecentLaureates(self::DEFAULT_YEAR_RANGE);
        if (empty($listOfLaureates)){
            return [];
        }
        usort($listOfLaureates, fn($a, $b) => $b->getDateAwarded() <=> $a->getDateAwarded());
        return array_slice($listOfLaureates, 0, 20);
    }

    /**
     * Maps raw laureate data to Laureate objects.
     *
     * @param array $rawLaureatesData Raw laureate data fetched from the API.
     * @return array Array of Laureate objects.
     */
    private function mapToLaureates(array $rawLaureatesData): array
    {
        $mappedLaureates = [];

        foreach ($rawLaureatesData as $rawLaureate) {
            // Skip invalid data
            if (!is_array($rawLaureate)) {
                continue;
            }
            $mappedLaureates[] = $this->mapToLaureate($rawLaureate);
        }

        return $mappedLaureates;
    }

    /**
     * Maps raw laureate data to a Laureate object.
     *
     * @param array $rawLaureate Raw laureate data fetched from the API.
     * @return Laureate|null Laureate object or null if mapping fails.
     */
    private function mapToLaureate(array $rawLaureate): ?Laureate
    {
        try {
            return new Laureate(
                $rawLaureate['id'],
                $rawLaureate["fullName"]["en"] ?? $rawLaureate["orgName"]["en"],
                new DateTime($rawLaureate['birth']['date'] ?? $rawLaureate["founded"]["date"]),
                $rawLaureate["birth"]["place"]["country"]["en"] ?? null,
                $rawLaureate["nobelPrizes"][0]["category"]["en"],
                new DateTime($rawLaureate["nobelPrizes"][0]['dateAwarded'])
            );
        } catch (Exception $e) {
            // Handle any exceptions that might occur during the mapping process
            return null;
        }
    }
}
