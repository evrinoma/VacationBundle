<?php

namespace Evrinoma\VacationBundle\Tests\Functional\Helper;


trait BaseVacationTestTrait
{
//region SECTION: Protected
    protected function createVacation(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }
//endregion Protected
}