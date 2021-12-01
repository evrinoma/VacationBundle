<?php

namespace Evrinoma\VacationBundle\Repository\Vacation;

use Doctrine\ORM\ORMException;
use Evrinoma\VacationBundle\Dto\VacationApiDtoInterface;
use Evrinoma\VacationBundle\Exception\Vacation\VacationNotFoundException;
use Evrinoma\VacationBundle\Exception\Vacation\VacationProxyException;
use Evrinoma\VacationBundle\Model\Vacation\VacationInterface;

interface VacationQueryRepositoryInterface
{
//region SECTION: Public
    /**
     * @param string $id
     *
     * @return VacationInterface
     * @throws VacationProxyException
     * @throws ORMException
     */
    public function proxy(string $id): VacationInterface;
//endregion Public

//region SECTION: Find Filters Repository
    /**
     * @param VacationApiDtoInterface $dto
     *
     * @return array
     * @throws VacationNotFoundException
     */
    public function findByCriteria(VacationApiDtoInterface $dto): array;

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return VacationInterface
     * @throws VacationNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): VacationInterface;
//endregion Find Filters Repository
}