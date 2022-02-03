<?php

namespace Evrinoma\VacationBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;

interface UserApiDtoInterface extends DtoInterface, IdInterface
{
    public const AUTHOR      = 'author';
    public const RESOLVED_BY = 'resolved_by';
}