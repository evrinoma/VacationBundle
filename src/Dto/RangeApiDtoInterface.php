<?php

namespace Evrinoma\VacationBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface RangeApiDtoInterface extends DtoInterface
{
//region SECTION: Public
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
