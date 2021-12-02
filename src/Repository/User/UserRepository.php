<?php

namespace Evrinoma\VacationBundle\Repository\User;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Evrinoma\VacationBundle\Exception\User\UserProxyException;
use Evrinoma\VacationBundle\Model\User\VacationInterface;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
//region SECTION: Public
    /**
     * @param string $id
     *
     * @return VacationInterface
     * @throws UserProxyException
     * @throws ORMException
     */
    public function proxy(string $id): VacationInterface
    {
        $em = $this->getEntityManager();

        $user = $em->getReference($this->getEntityName(), $id);

        if (!$em->contains($user)) {
            throw new UserProxyException("Proxy doesn't exist with $id");
        }

        return $user;
    }
//endregion Public
}