<?php

namespace Evrinoma\VacationBundle\Factory;

use Evrinoma\VacationBundle\Dto\VacationApiDtoInterface;
use Evrinoma\VacationBundle\Model\Vacation\VacationInterface;

interface VacationFactoryInterface
{
//region SECTION: Public
    /**
     * @param VacationApiDtoInterface $dto
     *
     * @return VacationInterface
     */
    public function create(VacationApiDtoInterface $dto): VacationInterface;
//endregion Public
}