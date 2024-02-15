<?php

declare(strict_types=1);

namespace App\Application\Actions\Laureates;

use Psr\Http\Message\ResponseInterface as Response;

class ListLaureatesAction extends LaureatesAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $laureates = $this->laureateRepository->getMostRecent20();

        $this->logger->info("Laureates list was viewed.");

        return $this->respondWithData($laureates);
    }
}
