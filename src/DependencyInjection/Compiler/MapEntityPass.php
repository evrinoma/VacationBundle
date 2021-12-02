<?php

namespace Evrinoma\VacationBundle\DependencyInjection\Compiler;

use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractMapEntity;
use Evrinoma\VacationBundle\DependencyInjection\EvrinomaVacationExtension;
use Evrinoma\VacationBundle\Entity\User\BaseUser;
use Evrinoma\VacationBundle\Entity\Vacation\BaseVacation;
use Evrinoma\VacationBundle\EvrinomaVacationBundle;
use Evrinoma\VacationBundle\Model\User\VacationInterface as UserVacationInterface;
use Evrinoma\VacationBundle\Model\Vacation\VacationInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MapEntityPass extends AbstractMapEntity implements CompilerPassInterface
{
//region SECTION: Public
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $this->setContainer($container);

        $driver                    = $container->findDefinition('doctrine.orm.default_metadata_driver');
        $referenceAnnotationReader = new Reference('annotations.reader');

        $this->cleanMetadata($driver, [EvrinomaVacationExtension::ENTITY]);

        $entityUser = $container->getParameter('evrinoma.'.EvrinomaVacationBundle::VACATION_BUNDLE.'.entity_user');

        if ((strpos($entityUser, EvrinomaVacationExtension::ENTITY) !== false)) {
            $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/User', '%s/Entity/User');
            $this->addResolveTargetEntity([BaseUser::class => UserVacationInterface::class,], false);
        } else {
            $this->addResolveTargetEntity([$entityUser => UserVacationInterface::class,], false);
        }

        $entityVacation = $container->getParameter('evrinoma.'.EvrinomaVacationBundle::VACATION_BUNDLE.'.entity_vacation');

        if ((strpos($entityVacation, EvrinomaVacationExtension::ENTITY) !== false)) {
            $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/Vacation', '%s/Entity/Vacation');
            $this->addResolveTargetEntity([BaseVacation::class => VacationInterface::class,], false);
        }
    }

//endregion Private
}