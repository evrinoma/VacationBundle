<?php

namespace Evrinoma\VacationBundle\DependencyInjection;

use Evrinoma\UtilsBundle\DependencyInjection\HelperTrait;
use Evrinoma\VacationBundle\EvrinomaVacationBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class EvrinomaVacationExtension extends Extension
{
    use HelperTrait;

//region SECTION: Public
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
//endregion Public


//region SECTION: Getters/Setters
    public function getAlias()
    {
        return EvrinomaVacationBundle::VACATION_BUNDLE;
    }
//endregion Getters/Setters
}