<?php

namespace Evrinoma\VacationBundle;


use Evrinoma\VacationBundle\DependencyInjection\Compiler\Constraint\VacationPass;
use Evrinoma\VacationBundle\DependencyInjection\Compiler\DecoratorPass;
use Evrinoma\VacationBundle\DependencyInjection\Compiler\MapEntityPass;
use Evrinoma\VacationBundle\DependencyInjection\EvrinomaVacationExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EvrinomaVacationBundle extends Bundle
{
//region SECTION: Fields
    public const VACATION_BUNDLE = 'vacation';
//endregion Fields

//region SECTION: Public
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container
            ->addCompilerPass(new MapEntityPass($this->getNamespace(), $this->getPath()))
            ->addCompilerPass(new VacationPass())
            ->addCompilerPass(new DecoratorPass())
            ;
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaVacationExtension();
        }

        return $this->extension;
    }
//endregion Getters/Setters

}