<?php

namespace Evrinoma\VacationBundle\Model\Vacation;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtTrait;
use Evrinoma\UtilsBundle\Entity\DateStartFinishTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;
use Evrinoma\VacationBundle\Model\Status\StatusTrait;
use Evrinoma\VacationBundle\Model\User\VacationInterface as UserVacationInterface;

/**
 * @ORM\MappedSuperclass
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="idx_vacation", columns={"user_id","dateStart","dateFinish"})})
 */
abstract class AbstractVacation implements VacationInterface
{
    use IdTrait, CreateUpdateAtTrait, DateStartFinishTrait, StatusTrait;

//region SECTION: Fields
    /**
     * @var UserVacationInterface
     *
     * @ORM\ManyToOne(targetEntity="Evrinoma\VacationBundle\Model\User\VacationInterface")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected UserVacationInterface $user;

    /**
     * @var UserVacationInterface
     *
     * @ORM\ManyToOne(targetEntity="Evrinoma\VacationBundle\Model\User\VacationInterface")
     * @ORM\JoinColumn(name="resolver_id", referencedColumnName="id")
     */
    protected UserVacationInterface $resolver;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return UserVacationInterface
     */
    public function getUser(): UserVacationInterface
    {
        return $this->user;
    }

    /**
     * @return UserVacationInterface
     */
    public function getResolver(): UserVacationInterface
    {
        return $this->resolver;
    }

    /**
     * @param UserVacationInterface $user
     *
     * @return VacationInterface
     */
    public function setUser(UserVacationInterface $user): VacationInterface
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param UserVacationInterface $resolver
     *
     * @return VacationInterface
     */
    public function setResolver(UserVacationInterface $resolver): VacationInterface
    {
        $this->resolver = $resolver;

        return $this;
    }
//endregion Getters/Setters
}
