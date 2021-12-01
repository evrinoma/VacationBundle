<?php

namespace Evrinoma\VacationBundle\Manager\Vacation;

use Evrinoma\VacationBundle\Dto\VacationApiDtoInterface;
use Evrinoma\VacationBundle\Exception\Vacation\VacationNotFoundException;
use Evrinoma\VacationBundle\Exception\Vacation\VacationProxyException;
use Evrinoma\VacationBundle\Model\Vacation\VacationInterface;
use Evrinoma\VacationBundle\Repository\Vacation\VacationQueryRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;

final class QueryManager implements QueryManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private VacationQueryRepositoryInterface $repository;
//endregion Fields

//region SECTION: Constructor
    public function __construct(VacationQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param VacationApiDtoInterface $dto
     *
     * @return array
     * @throws VacationNotFoundException
     */
    public function criteria(VacationApiDtoInterface $dto): array
    {
        try {
            $vacation = $this->repository->findByCriteria($dto);
        } catch (VacationNotFoundException $e) {
            throw $e;
        }

        return $vacation;
    }

    /**
     * @param VacationApiDtoInterface $dto
     *
     * @return VacationInterface
     * @throws VacationProxyException
     */
    public function proxy(VacationApiDtoInterface $dto): VacationInterface
    {
        try {
            if ($dto->hasId()) {
                $vacation = $this->repository->proxy((string)$dto->getId());
            } else {
                throw new VacationProxyException('entity does\'t have id');
            }
        } catch (VacationProxyException $e) {
            throw $e;
        }

        return $vacation;
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getRestStatus(): int
    {
        return $this->status;
    }

    /**
     * @param VacationApiDtoInterface $dto
     *
     * @return VacationInterface
     * @throws VacationNotFoundException
     */
    public function get(VacationApiDtoInterface $dto): VacationInterface
    {
        try {
            $vacation = $this->repository->find($dto->getId());
        } catch (VacationNotFoundException $e) {
            throw $e;
        }

        return $vacation;
    }
//endregion Getters/Setters
}