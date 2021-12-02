<?php

namespace Evrinoma\VacationBundle\Tests\Functional;

use Evrinoma\TestUtilsBundle\Kernel\AbstractApiKernel;

/**
 * Kernel
 */
class Kernel extends AbstractApiKernel
{
//region SECTION: Fields
    protected string $bundlePrefix = 'VacationBundle';
    protected string $rootDir = __DIR__;
//endregion Fields

//region SECTION: Public
    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        return array_merge(parent::registerBundles(), [new \Evrinoma\DtoBundle\EvrinomaDtoBundle(), new \Evrinoma\VacationBundle\EvrinomaVacationBundle()]);
    }

    protected function getBundleConfig(): array
    {
        return  ['framework.yaml', 'jms_serializer.yaml'];
    }

}
