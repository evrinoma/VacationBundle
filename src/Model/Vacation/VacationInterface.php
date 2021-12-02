<?php


namespace Evrinoma\VacationBundle\Model\Vacation;

use Evrinoma\UtilsBundle\Entity\CreateUpdateAtInterface;
use Evrinoma\UtilsBundle\Entity\DateStartFinishInterface;
use Evrinoma\UtilsBundle\Entity\IdInterface;
use Evrinoma\VacationBundle\Model\Status\StatusInterface;
use Evrinoma\VacationBundle\Model\User\VacationInterface as UserVacationInterface;

interface VacationInterface extends CreateUpdateAtInterface, IdInterface, DateStartFinishInterface, StatusInterface
{
//region SECTION: Getters/Setters
    /**
     * @return UserVacationInterface
     */
    public function getResolver(): UserVacationInterface;

    /**
     * @return UserVacationInterface
     */
    public function getUser(): UserVacationInterface;

    /**
     * @param UserVacationInterface $user
     *
     * @return VacationInterface
     */
    public function setUser(UserVacationInterface $user): VacationInterface;

    /**
     * @param UserVacationInterface $resolver
     *
     * @return VacationInterface
     */
    public function setResolver(UserVacationInterface $resolver): VacationInterface;
//endregion Getters/Setters
}