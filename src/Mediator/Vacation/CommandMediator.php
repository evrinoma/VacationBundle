<?php

namespace Evrinoma\VacationBundle\Mediator\Vacation;

use Evrinoma\UtilsBundle\Mediator\AbstractCommandMediator;
use Evrinoma\VacationBundle\Model\Vacation\VacationInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;

class CommandMediator extends AbstractCommandMediator implements CommandMediatorInterface
{
//region SECTION: Public
    public function onUpdate(DtoInterface $dto, $entity): VacationInterface
    {
        return $entity;
    }

    public function onDelete(DtoInterface $dto, $entity): void
    {
    }

    public function onCreate(DtoInterface $dto, $entity): VacationInterface
    {
        return $entity;
    }
//endregion Public
}