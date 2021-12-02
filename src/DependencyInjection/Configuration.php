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
        $supportedDrivers = ['orm'];

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('db_driver')
            ->validate()
            ->ifNotInArray($supportedDrivers)
            ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
            ->end()
            ->cannotBeOverwritten()
            ->defaultValue('orm')
            ->end()
            ->scalarNode('factory_vacation')->cannotBeEmpty()->defaultValue(EvrinomaVacationExtension::FACTORY_VACATION)->end()
            ->scalarNode('entity_vacation')->cannotBeEmpty()->defaultValue(EvrinomaVacationExtension::ENTITY_BASE_VACATION)->end()
            ->scalarNode('entity_user')->cannotBeEmpty()->defaultValue(EvrinomaVacationExtension::ENTITY_BASE_USER)->end()
            ->scalarNode('constraints_vacation')->defaultTrue()->info('This option is used for enable/disable basic vacation constraints')->end()
            ->scalarNode('dto_vacation')->cannotBeEmpty()->defaultValue(EvrinomaVacationExtension::DTO_BASE_VACATION)->info('This option is used for dto class override')->end()
            ->arrayNode('decorates')->addDefaultsIfNotSet()->children()
            ->scalarNode('command_vacation')->defaultNull()->info('This option is used for command vacation decoration')->end()
            ->scalarNode('query_vacation')->defaultNull()->info('This option is used for query vacation decoration')->end()
            ->end()->end()->end();

        return $treeBuilder;
    }
//endregion Getters/Setters
}
