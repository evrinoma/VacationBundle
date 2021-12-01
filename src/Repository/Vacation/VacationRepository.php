<?php

namespace Evrinoma\VacationBundle\Repository\Vacation;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\Persistence\ManagerRegistry;
use Evrinoma\VacationBundle\Exception\Vacation\VacationCannotBeRemovedException;
use Evrinoma\VacationBundle\Exception\Vacation\VacationProxyException;
use Evrinoma\VacationBundle\Mediator\Vacation\QueryMediatorInterface;
use Evrinoma\VacationBundle\Dto\VacationApiDtoInterface;
use Evrinoma\VacationBundle\Exception\Vacation\VacationCannotBeSavedException;
use Evrinoma\VacationBundle\Exception\Vacation\VacationNotFoundException;
use Evrinoma\VacationBundle\Model\Vacation\VacationInterface;

class VacationRepository extends ServiceEntityRepository implements VacationRepositoryInterface
{
//region SECTION: Fields
    private QueryMediatorInterface $mediator;
//endregion Fields

//region SECTION: Constructor
    /**
     * @param ManagerRegistry        $registry
     * @param string                 $entityClass
     * @param QueryMediatorInterface $mediator
     */
    public function __construct(ManagerRegistry $registry, string $entityClass, QueryMediatorInterface $mediator)
    {
        parent::__construct($registry, $entityClass);
        $this->mediator = $mediator;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param VacationInterface $vacation
     *
     * @return bool
     * @throws VacationCannotBeSavedException
     * @throws ORMException
     */
    public function save(VacationInterface $vacation): bool
    {
        try {
            $this->getEntityManager()->persist($vacation);
        } catch (ORMInvalidArgumentException $e) {
            throw new VacationCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param VacationInterface $vacation
     *
     * @return bool
     * @throws ORMException
     * @throws VacationCannotBeRemovedException
     */
    public function remove(VacationInterface $vacation): bool
    {
        try {
            $this->getEntityManager()->remove($vacation);
        } catch (ORMInvalidArgumentException $e) {
            throw new VacationCannotBeRemovedException($e->getMessage());
        }

        return true;
    }
//endregion Public

//region SECTION: Find Filters Repository
    /**
     * @param VacationApiDtoInterface $dto
     *
     * @return array
     * @throws VacationNotFoundException
     */
    public function findByCriteria(VacationApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilder($this->mediator->alias());

        $this->mediator->createQuery($dto, $builder);

        $vacationes = $this->mediator->getResult($dto, $builder);

        if (count($vacationes) === 0) {
            throw new VacationNotFoundException("Cannot find vacation by findByCriteria");
        }

        return $vacationes;
    }

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return mixed
     * @throws VacationNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): VacationInterface
    {
        /** @var VacationInterface $vacation */
        $vacation = parent::find($id);

        if ($vacation === null) {
            throw new VacationNotFoundException("Cannot find vacation with id $id");
        }

        return $vacation;
    }

    /**
     * @param string $id
     *
     * @return VacationInterface
     * @throws VacationProxyException
     * @throws ORMException
     */
    public function proxy(string $id): VacationInterface
    {
        $em = $this->getEntityManager();

        $vacation = $em->getReference($this->getEntityName(), $id);

        if (!$em->contains($vacation)) {
            throw new VacationProxyException("Proxy doesn't exist with $id");
        }

        return $vacation;
    }
//endregion Find Filters Repository

}