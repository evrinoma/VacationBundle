<?php

namespace Evrinoma\VacationBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;

interface VacationApiDtoInterface extends DtoInterface, IdInterface
{
//region SECTION: Public
    public const STATUS      = 'status';
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
     * @return string
     */
    public function getStatus(): string;

    /**
     * @return UserApiDtoInterface
     */
    public function getUser(): UserApiDtoInterface;

    /**
     * @return UserApiDtoInterface
     */
    public function getResolver(): UserApiDtoInterface;
//endregion Getters/Setters

}
