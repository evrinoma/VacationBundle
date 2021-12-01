<?php

namespace Evrinoma\VacationBundle\Repository\Vacation;

use Evrinoma\VacationBundle\Exception\Vacation\VacationCannotBeRemovedException;
use Evrinoma\VacationBundle\Exception\Vacation\VacationCannotBeSavedException;
use Evrinoma\VacationBundle\Model\Vacation\VacationInterface;

interface VacationCommandRepositoryInterface
{
    /**
     * @param VacationInterface $rate
     *
     * @return bool
     * @throws VacationCannotBeSavedException
     */
    public function save(VacationInterface $rate): bool;

    /**
     * @param VacationInterface $rate
     *
     * @return bool
     * @throws VacationCannotBeRemovedException
     */
    public function remove(VacationInterface $rate): bool;
}