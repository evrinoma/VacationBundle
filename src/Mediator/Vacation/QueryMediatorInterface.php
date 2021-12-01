<?php

namespace Evrinoma\VacationBundle\Mediator\Vacation;

use Doctrine\ORM\QueryBuilder;
use Evrinoma\VacationBundle\Dto\VacationApiDtoInterface;

interface QueryMediatorInterface
{
    /**
     * @return string
     */
    public function alias(): string;

    /**
     * @param VacationApiDtoInterface $dto
     * @param QueryBuilder              $builder
     *
     * @return mixed
     */
    public function createQuery(VacationApiDtoInterface $dto, QueryBuilder $builder):void;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param VacationApiDtoInterface $dto
     * @param QueryBuilder              $builder
     *
     * @return array
     */
    public function getResult(VacationApiDtoInterface $dto, QueryBuilder $builder): array;
}