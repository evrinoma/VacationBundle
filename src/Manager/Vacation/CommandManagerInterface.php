<?php

namespace Evrinoma\VacationBundle\Manager\Vacation;

use Evrinoma\VacationBundle\Dto\VacationApiDtoInterface;
use Evrinoma\VacationBundle\Exception\Vacation\VacationCannotBeCreatedException;
use Evrinoma\VacationBundle\Exception\Vacation\VacationCannotBeRemovedException;
use Evrinoma\VacationBundle\Exception\Vacation\VacationCannotBeSavedException;
use Evrinoma\VacationBundle\Exception\Vacation\VacationInvalidException;
use Evrinoma\VacationBundle\Exception\Vacation\VacationNotFoundException;
use Evrinoma\VacationBundle\Model\Vacation\VacationInterface;


interface CommandManagerInterface
{
//region SECTION: Public
    /**
     * @param VacationApiDtoInterface $dto
     *
     * @return VacationInterface
     * @throws VacationInvalidException
     * @throws VacationCannotBeCreatedException
     */
    public function post(VacationApiDtoInterface $dto): VacationInterface;

    /**
     * @param VacationApiDtoInterface $dto
     *
     * @return VacationInterface
     * @throws VacationInvalidException
     * @throws VacationNotFoundException
     * @throws VacationCannotBeSavedException
     */
    public function put(VacationApiDtoInterface $dto): VacationInterface;

    /**
     * @param VacationApiDtoInterface $dto
     *
     * @throws VacationCannotBeRemovedException
     * @throws VacationNotFoundException
     */
    public function delete(VacationApiDtoInterface $dto): void;
//endregion Public
}