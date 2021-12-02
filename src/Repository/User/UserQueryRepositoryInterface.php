<?php

namespace Evrinoma\VacationBundle\Repository\User;

use Doctrine\ORM\ORMException;
use Evrinoma\VacationBundle\Exception\User\UserProxyException;
use Evrinoma\VacationBundle\Model\User\VacationInterface;

interface UserQueryRepositoryInterface
{
//region SECTION: Public
    /**
     * @param string $id
     *
     * @return VacationInterface
     * @throws UserProxyException
     * @throws ORMException
     */
    public function proxy(string $id): VacationInterface;
//endregion Public
}