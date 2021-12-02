<?php

namespace Evrinoma\VacationBundle\Model\User;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\IdentityInterface;
use Evrinoma\UtilsBundle\Entity\IdentityTrait;
use Evrinoma\UtilsBundle\Entity\IdInterface;
use Evrinoma\UtilsBundle\Entity\IdTrait;
use Evrinoma\UtilsBundle\Entity\RoleTrait;

/**
 * @ORM\MappedSuperclass
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="idx_identety", columns={"identity"})})
 */
abstract class AbstractUser implements VacationInterface, IdInterface, IdentityInterface
{
    use IdTrait, RoleTrait, IdentityTrait;
}
