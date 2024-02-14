<?php

namespace App\Infrastructure\LaureateFetcher;

use App\Domain\Laureate\Laureate;
use DateTime;
use Exception;
use RuntimeException;

class LaureateFetcher
{
    private const API_BASE_URL = 'https://api.nobelprize.org/2.1/laureates';
    private const DEFAULT_LIMIT = 20;
    private const DEFAULT_YEAR_RANGE = 2;

    /**
     * Fetches the most recent Nobel Prize laureates from the API.
     *
     * @param int $limit Number of laureates to retrieve.
     * @param int $yearRange Number of years to go back from the current year.
     * @return array Array of laureates' information.
     * @throws RuntimeException If there is an error fetching data from the API.
     * @throws RuntimeException|Exception If there is an error decoding JSON data.
     */
    public function getRecentLaureates(int $limit, int $yearRange) : array
    {

        $currentYear = date('Y');
        $startYear = $currentYear - $yearRange;

        $url = self::API_BASE_URL . "?limit={$limit}&nobelPrizeYear={$startYear}&yearTo={$currentYear}";

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
        return $this->getRecentLaureates(self::DEFAULT_LIMIT, self::DEFAULT_YEAR_RANGE);
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

                var_dump( $rawLaureate );

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
                $rawLaureate["fullName"]["en"] ?? "tmp name",
                isset($rawLaureate['birth']['date']) ? new DateTime($rawLaureate['birth']['date']) : null,
                //$rawLaureate['nativeCountry'],
                $rawLaureate["birth"]["place"]["country"]["en"] ?? "tmp country",
                //$rawLaureate['category'],
                $rawLaureate["nobelPrizes"][0]["category"]["en"],
                isset($rawLaureate["nobelPrizes"][0]['dateAwarded']) ? new DateTime($rawLaureate["nobelPrizes"][0]['dateAwarded']) : null
            );
        } catch (\Exception $e) {
            // Handle any exceptions that might occur during the mapping process
            return null;
        }
    }
}
