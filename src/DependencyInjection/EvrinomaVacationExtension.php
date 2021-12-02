<?php

namespace Evrinoma\VacationBundle\DependencyInjection;

use Evrinoma\UtilsBundle\DependencyInjection\HelperTrait;
use Evrinoma\VacationBundle\DependencyInjection\Compiler\Constraint\VacationPass;
use Evrinoma\VacationBundle\Dto\VacationApiDto;
use Evrinoma\VacationBundle\EvrinomaVacationBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class EvrinomaVacationExtension extends Extension
{
    use HelperTrait;

//region SECTION: Fields
    public const ENTITY               = 'Evrinoma\VacationBundle\Entity';
    public const FACTORY_VACATION     = 'Evrinoma\VacationBundle\Factory\VacationFactory';
    public const ENTITY_BASE_VACATION = self::ENTITY.'\Vacation\BaseVacation';
    public const ENTITY_BASE_USER     = self::ENTITY.'\User\BaseUser';
    public const DTO_BASE_VACATION    = VacationApiDto::class;

    /**
     * @var array
     */
    private static array $doctrineDrivers = array(
        'orm' => array(
            'registry' => 'doctrine',
            'tag'      => 'doctrine.event_subscriber',
        ),
    );
//endregion Fields

//region SECTION: Public
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if ($container->getParameter('kernel.environment') !== 'prod') {
            $loader->load('fixtures.yml');
        }

        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);

        if ($config['factory_vacation'] !== self::FACTORY_VACATION) {
            $this->wireFactory($container, 'vacation', $config['factory_vacation'], $config['entity_vacation']);
        } else {
            $definitionFactory = $container->getDefinition('evrinoma.'.$this->getAlias().'.vacation.factory');
            $definitionFactory->setArgument(0, $config['entity_vacation']);
        }


        $doctrineRegistry = null;

        if (isset(self::$doctrineDrivers[$config['db_driver']])) {
            $loader->load('doctrine.yml');
            $container->setAlias('evrinoma.'.$this->getAlias().'.doctrine_registry', new Alias(self::$doctrineDrivers[$config['db_driver']]['registry'], false));
            $doctrineRegistry = new Reference('evrinoma.'.$this->getAlias().'.doctrine_registry');
            $container->setParameter('evrinoma.'.$this->getAlias().'.backend_type_'.$config['db_driver'], true);
            $objectManager = $container->getDefinition('evrinoma.'.$this->getAlias().'.object_manager');
            $objectManager->setFactory([$doctrineRegistry, 'getManager']);
        }

        $this->remapParametersNamespaces(
            $container,
            $config,
            [
                '' => [
                    'db_driver'       => 'evrinoma.'.$this->getAlias().'.storage',
                    'entity_vacation' => 'evrinoma.'.$this->getAlias().'.entity_vacation',
                    'entity_user'     => 'evrinoma.'.$this->getAlias().'.entity_user',
                ],
            ]
        );

        if ($doctrineRegistry) {
            $this->wireRepository($container, $doctrineRegistry, 'vacation', $config['entity_vacation']);
            $this->wireRepository($container, $doctrineRegistry, 'user', $config['entity_user']);
        }

        $this->wireController($container, 'vacation', $config['dto_vacation']);

        $this->wireValidator($container, 'vacation', $config['entity_vacation']);

        $loader->load('validation.yml');

        if ($config['constraints_vacation']) {
            $loader->load('constraint/vacation.yml');
        }

        $this->wireConstraintTag($container);

        if ($config['decorates']) {
            $this->remapParametersNamespaces(
                $container,
                $config['decorates'],
                [
                    '' => [
                        'command_vacation' => 'evrinoma.'.$this->getAlias().'.decorates.vacation.command',
                        'query_vacation'   => 'evrinoma.'.$this->getAlias().'.decorates.vacation.query',
                    ],
                ]
            );
        }
    }
//endregion Public

//region SECTION: Private
    private function wireConstraintTag(ContainerBuilder $container): void
    {
        foreach ($container->getDefinitions() as $key => $definition) {
            switch (true) {
                case strpos($key, VacationPass::VACATION_VACATION_CONSTRAINT) !== false :
                    $definition->addTag(VacationPass::VACATION_VACATION_CONSTRAINT);
                    break;
            }
        }
    }

    private function wireFactory(ContainerBuilder $container, string $name, string $class, string $paramClass): void
    {
        $container->removeDefinition('evrinoma.'.$this->getAlias().'.'.$name.'.factory');
        $definitionFactory = new Definition($class);
        $definitionFactory->addArgument($paramClass);
        $alias = new Alias('evrinoma.'.$this->getAlias().'.'.$name.'.factory');
        $container->addDefinitions(['evrinoma.'.$this->getAlias().'.'.$name.'.factory' => $definitionFactory]);
        $container->addAliases([$class => $alias]);
    }

    private function wireController(ContainerBuilder $container, string $name, string $class): void
    {
        $definitionApiController = $container->getDefinition('evrinoma.'.$this->getAlias().'.'.$name.'.api.controller');
        $definitionApiController->setArgument(5, $class);
    }

    private function wireValidator(ContainerBuilder $container, string $name, string $class): void
    {
        $definitionApiController = $container->getDefinition('evrinoma.'.$this->getAlias().'.'.$name.'.validator');
        $definitionApiController->setArgument(0, $class);
    }

    private function wireRepository(ContainerBuilder $container, Reference $doctrineRegistry, string $name, string $class): void
    {
        $definitionRepository = $container->getDefinition('evrinoma.'.$this->getAlias().'.'.$name.'.repository');

        switch ($name) {
            case 'vacation':
                $definitionQueryMediator = $container->getDefinition('evrinoma.'.$this->getAlias().'.'.$name.'.query.mediator');
                $definitionRepository->setArgument(2, $definitionQueryMediator);
            case 'user':
                $definitionRepository->setArgument(1, $class);
            default:
                $definitionRepository->setArgument(0, $doctrineRegistry);
        }
        $array = $definitionRepository->getArguments();
        ksort($array);
        $definitionRepository->setArguments($array);
    }
//endregion Private

//region SECTION: Getters/Setters
    public function getAlias()
    {
        return EvrinomaVacationBundle::VACATION_BUNDLE;
    }
//endregion Getters/Setters
}