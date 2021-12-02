<?php

namespace Evrinoma\VacationBundle\Tests\Functional\Controller;

use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestInterface;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestTrait;
use Evrinoma\TestUtilsBundle\Controller\ApiControllerTestInterface;
use Evrinoma\TestUtilsBundle\Helper\ApiMethodTestInterface;
use Evrinoma\TestUtilsBundle\Helper\ApiMethodTestTrait;
use Evrinoma\TestUtilsBundle\Helper\ResponseStatusTestTrait;
use Evrinoma\VacationBundle\Dto\VacationApiDto;
use Evrinoma\VacationBundle\Fixtures\FixtureInterface;
use Evrinoma\VacationBundle\Tests\Functional\CaseTest;


class VacationApiControllerTest extends CaseTest implements ApiControllerTestInterface, ApiBrowserTestInterface, ApiMethodTestInterface
{
//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/vacation/vacation';
    public const API_CRITERIA = 'evrinoma/api/vacation/vacation/criteria';
    public const API_DELETE   = 'evrinoma/api/vacation/vacation/delete';
    public const API_PUT      = 'evrinoma/api/vacation/vacation/save';
    public const API_POST     = 'evrinoma/api/vacation/vacation/create';
//endregion Fields

    use ApiBrowserTestTrait, ApiMethodTestTrait, ResponseStatusTestTrait;

//region SECTION: Protected
//endregion Protected

//region SECTION: Public
    public static function defaultData(): array
    {
        return [
            'author'              => '2',
            'status'              => 'pending',
            'resolved_by'         => '4',
            'request_created_at'  => '2020-08-09T12:57:13.506Z',
            'vacation_start_date' => '2020-08-24T00:00:00.000Z',
            'vacation_end_date'   => '2020-09-04T00:00:00.000Z',
            'id'                  => '48',
            'class'               => static::getDtoClass(),
        ];

    }

    public function testPost(): void
    {
        $this->createVacation();
      //  var_dump($this->client->getResponse()->getContent());
        $this->testResponseStatusCreated();
    }

    public function testCriteriaNotFound(): void
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    public function testCriteria(): void
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    public function testDelete(): void
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    public function testPut(): void
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    public function testGet(): void
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    public function testGetNotFound(): void
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    public function testDeleteNotFound(): void
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    public function testDeleteUnprocessable(): void
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    public function testPutNotFound(): void
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    public function testPutUnprocessable(): void
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    public function testPostDuplicate(): void
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    public function testPostUnprocessable(): void
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }
//endregion Public

//region SECTION: Private
    private function createVacation(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }
//endregion Private

//region SECTION: Getters/Setters
    public static function getFixtures(): array
    {
        return [FixtureInterface::USER_FIXTURES];
    }

    public static function getDtoClass(): string
    {
        return VacationApiDto::class;
    }
//endregion Getters/Setters
}
