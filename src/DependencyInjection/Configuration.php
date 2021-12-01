<?php

namespace Evrinoma\VacationBundle\DependencyInjection;


use Evrinoma\VacationBundle\EvrinomaVacationBundle;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;


class Configuration implements ConfigurationInterface
{
//region SECTION: Getters/Setters
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder      = new TreeBuilder(EvrinomaVacationBundle::VACATION_BUNDLE);
        $rootNode         = $treeBuilder->getRootNode();

        return $treeBuilder;
    }
//endregion Getters/Setters
}
