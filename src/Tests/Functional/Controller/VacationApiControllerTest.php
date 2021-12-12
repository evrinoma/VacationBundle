<?php

namespace Evrinoma\VacationBundle\Tests\Functional\Controller;


use Evrinoma\TestUtilsBundle\Action\ActionTestInterface;
use Evrinoma\TestUtilsBundle\Functional\AbstractFunctionalTest;
use Evrinoma\VacationBundle\Fixtures\FixtureInterface;
use Psr\Container\ContainerInterface;

final class VacationApiControllerTest extends AbstractFunctionalTest
{
//region SECTION: Fields
    protected string $actionServiceName = 'evrinoma.vacation.test.functional.action.vacation';
//endregion Fields

//region SECTION: Protected
    protected function getActionService(ContainerInterface $container): ActionTestInterface
    {
        return $container->get($this->actionServiceName);
    }
//endregion Protected

//region SECTION: Getters/Setters
    public static function getFixtures(): array
    {
        return [FixtureInterface::USER_FIXTURES];
    }
//endregion Getters/Setters
}
