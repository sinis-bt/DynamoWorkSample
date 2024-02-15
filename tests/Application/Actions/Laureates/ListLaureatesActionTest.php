<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Laureates;

use App\Application\Actions\ActionPayload;
use App\Domain\Laureate\Laureate;
use App\Domain\Laureate\LaureateRepository;
use DateTime;
use DI\Container;
use Tests\TestCase;

class ListLaureatesActionTest extends TestCase
{
    public function testAction()
    {

        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $laureate = new Laureate(
            id: 1,
            fullName: 'Jon Fosse',
            birthDate: new DateTime('1959-09-29'),
            nativeCountry: 'Norway',
            category: 'Literature',
            dateAwarded: new DateTime('2023-10-05')
        );

        $laureateRepositoryProphecy = $this->prophesize(LaureateRepository::class);

        $laureateRepositoryProphecy
            ->getMostRecent20()
            ->willReturn([$laureate])
            ->shouldBeCalledOnce();

        $container->set(LaureateRepository::class, $laureateRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/laureates');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, [$laureate]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
