<?php

namespace Evrinoma\VacationBundle\Factory;

use Evrinoma\VacationBundle\Dto\VacationApiDtoInterface;
use Evrinoma\VacationBundle\Entity\Vacation\BaseVacation;
use Evrinoma\VacationBundle\Model\ModelInterface;
use Evrinoma\VacationBundle\Model\Vacation\VacationInterface;

final class VacationFactory implements VacationFactoryInterface
{
//region SECTION: Fields
    private static string $entityClass = BaseVacation::class;
//endregion Fields

//region SECTION: Public
    public function create(VacationApiDtoInterface $dto): VacationInterface
    {
        /** @var BaseVacation $rate */
        $rate = new self::$entityClass;

        $rate
            ->setStatus()
            ->setCreatedAt(new \DateTimeImmutable())
            ->setDateStart($dto->getRangeApiDto()->getStart())
            ->setDateFinish($dto->getRangeApiDto()->getEnd())
        ;

        return $rate;
    }
//endregion Public
}