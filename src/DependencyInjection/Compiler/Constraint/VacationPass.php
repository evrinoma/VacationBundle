<?php

namespace Evrinoma\VacationBundle\DependencyInjection\Compiler\Constraint;


use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Evrinoma\VacationBundle\Validator\VacationValidator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class VacationPass extends AbstractConstraint implements CompilerPassInterface
{
    public const VACATION_VACATION_CONSTRAINT = 'evrinoma.vacation.constraint.vacation';

    protected static string $alias = self::VACATION_VACATION_CONSTRAINT;
    protected static string $class = VacationValidator::class;
    protected static string $methodCall = 'addConstraint';
}