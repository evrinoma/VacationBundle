<?php

namespace Evrinoma\VacationBundle\Manager\Vacation;

use Evrinoma\VacationBundle\Dto\VacationApiDtoInterface;
use Evrinoma\VacationBundle\Exception\Vacation\VacationNotFoundException;
use Evrinoma\VacationBundle\Exception\Vacation\VacationProxyException;
use Evrinoma\VacationBundle\Model\Vacation\VacationInterface;

interface QueryManagerInterface
{
//region SECTION: Public
    /**
     * @param VacationApiDtoInterface $dto
     *
     * @return array
     * @throws VacationNotFoundException
     */
    public function criteria(VacationApiDtoInterface $dto): array;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param VacationApiDtoInterface $dto
     *
     * @return VacationInterface
     * @throws VacationNotFoundException
     */
    public function get(VacationApiDtoInterface $dto): VacationInterface;
    /**
     * @param VacationApiDtoInterface $dto
     *
     * @return VacationInterface
     * @throws VacationProxyException
     */
    public function proxy(VacationApiDtoInterface $dto): VacationInterface;
//endregion Getters/Setters
}