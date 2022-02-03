<?php

namespace Evrinoma\VacationBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;

interface RangeApiDtoInterface extends DtoInterface, IdInterface
{
//region SECTION: Public
    public const DATE_START  = 'vacation_start_date';
    public const DATE_END    = 'vacation_end_date';
    /**
     * @return bool
     */
    public function hasEnd(): bool;

    /**
     * @return bool
     */
    public function hasStart(): bool;

    /**
     * @return bool
     */
    public function hasRange(): bool;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return \DateTimeImmutable|null
     */
    public function getStart(): ?\DateTimeImmutable;

    /**
     * @return \DateTimeImmutable|null
     */
    public function getEnd(): ?\DateTimeImmutable;
//endregion Getters/Setters
}
