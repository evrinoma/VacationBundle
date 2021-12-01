<?php


namespace Evrinoma\VacationBundle\Validator;

use Evrinoma\UtilsBundle\Validator\AbstractValidator;
use Evrinoma\VacationBundle\Entity\Vacation\BaseVacation;

final class VacationValidator extends AbstractValidator
{
//region SECTION: Fields
    /**
     * @var string|null
     */
    protected static ?string $entityClass = BaseVacation::class;
//endregion Fields

//region SECTION: Constructor
    public function __construct(string $entityClass)
    {
        parent::__construct($entityClass);
    }
//endregion Constructor
}