<?php


namespace Evrinoma\VacationBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\VacationBundle\Model\User\AbstractUser;

/**
 * @ORM\Table(name="euser")
 * @ORM\Entity()
 */
class BaseUser extends AbstractUser
{
}