<?php

namespace Evrinoma\VacationBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\IdInterface;

interface VacationApiDtoInterface extends DtoInterface, IdInterface
{
//region SECTION: Public
    /**
     * @return bool
     */
    public function hasStatus(): bool;

    /**
     * @return bool
     */
    public function hasUser(): bool;

    /**
     * @return bool
     */
    public function hasResolver(): bool;

    /**
     * @return bool
     */
    public function hasCreatedAt(): bool;
//endregion Public

//region SECTION: Dto
    /**
     * @return RangeApiDtoInterface
     */
    public function getRangeApiDto(): RangeApiDtoInterface;

    /**
     * @return bool
     */
    public function hasRangeApiDto(): bool;
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return bool
     */
    public function getStatus(): bool;

    /**
     * @return bool
     */
    public function getUser(): bool;

    /**
     * @return bool
     */
    public function getResolver(): bool;

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable;
//endregion Getters/Setters

}
