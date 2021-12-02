<?php

namespace Evrinoma\VacationBundle\Model;

interface ModelInterface
{
//region SECTION: Fields
    public const ID          = 'id';
    public const AUTHOR      = 'author';
    public const STATUS      = 'status';
    public const RESOLVED_BY = 'resolved_by';
    public const CREATED_AT  = 'request_created_at';
    public const DATE_START  = 'vacation_start_date';
    public const DATE_END    = 'vacation_end_date';
//endregion Fields
}