<?php

namespace Evrinoma\VacationBundle\Mediator\Vacation;

use Evrinoma\VacationBundle\Dto\VacationApiDtoInterface;
use Evrinoma\VacationBundle\Exception\Vacation\VacationCannotBeCreatedException;
use Evrinoma\VacationBundle\Exception\Vacation\VacationCannotBeRemovedException;
use Evrinoma\VacationBundle\Exception\Vacation\VacationCannotBeSavedException;
use Evrinoma\VacationBundle\Model\Vacation\VacationInterface;

interface CommandMediatorInterface
{
    /**
     * @param VacationApiDtoInterface $dto
     * @param VacationInterface       $entity
     *
     * @return VacationInterface
     * @throws VacationCannotBeSavedException
     */
    public function onUpdate(VacationApiDtoInterface $dto, VacationInterface $entity): VacationInterface;

    /**
     * @param VacationApiDtoInterface $dto
     * @param VacationInterface       $entity
     *
     * @throws VacationCannotBeRemovedException
     */
    public function onDelete(VacationApiDtoInterface $dto, VacationInterface $entity): void;

    /**
     * @param VacationApiDtoInterface $dto
     * @param VacationInterface       $entity
     *
     * @return VacationInterface
     * @throws VacationCannotBeSavedException
     * @throws VacationCannotBeCreatedException
     */
    public function onCreate(VacationApiDtoInterface $dto, VacationInterface $entity): VacationInterface;
}