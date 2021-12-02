<?php

namespace Evrinoma\VacationBundle\DependencyInjection\Compiler;


use Evrinoma\VacationBundle\EvrinomaVacationBundle;
use Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DecoratorPass extends AbstractRecursivePass
{
//region SECTION: Public
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $decoratorQuery = $container->getParameter('evrinoma.'.EvrinomaVacationBundle::VACATION_BUNDLE.'.decorates.vacation.query');
        if ($decoratorQuery) {
            $queryMediator = $container->getDefinition($decoratorQuery);
            $repository    = $container->getDefinition('evrinoma.'.EvrinomaVacationBundle::VACATION_BUNDLE.'.vacation.repository');
            $repository->setArgument(2, $queryMediator);
        }
        $decoratorCommand = $container->getParameter('evrinoma.'.EvrinomaVacationBundle::VACATION_BUNDLE.'.decorates.vacation.command');
        if ($decoratorCommand) {
            $commandMediator = $container->getDefinition($decoratorCommand);
            $commandManager  = $container->getDefinition('evrinoma.'.EvrinomaVacationBundle::VACATION_BUNDLE.'.vacation.command.manager');
            $commandManager->setArgument(3, $commandMediator);
        }
    }
}