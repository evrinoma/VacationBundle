<?php

namespace Evrinoma\VacationBundle\Constraint\Properties\Vacation;

use Evrinoma\UtilsBundle\Constraint\ConstraintInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

final class User implements ConstraintInterface
{
//region SECTION: Getters/Setters
    public function getConstraints(): array
    {
        return [
            new NotBlank(),
            new NotNull(),
        ];
    }

    public function getPropertyName(): string
    {
        return 'user';
    }
//endregion Getters/Setters
}