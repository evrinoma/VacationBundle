<?php


namespace Evrinoma\VacationBundle\Entity\Vacation;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\VacationBundle\Model\Vacation\AbstractVacation;

/**
 * @ORM\Table(name="evacation")
 * @ORM\Entity()
 */
class BaseVacation extends AbstractVacation
{
}