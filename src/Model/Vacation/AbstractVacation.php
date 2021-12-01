<?php

namespace Evrinoma\VacationBundle\Model\Vacation;

use Evrinoma\UtilsBundle\Entity\CreateUpdateAtTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 * @TODO think about restrictions 
 * ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="idx_vacation", columns={"created"})})
 */
abstract class AbstractVacation implements VacationInterface
{
    use IdTrait, CreateUpdateAtTrait;
}
