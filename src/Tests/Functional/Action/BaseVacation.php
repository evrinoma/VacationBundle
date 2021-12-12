<?php

namespace Evrinoma\VacationBundle\Tests\Functional\Action;


use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use Evrinoma\VacationBundle\Dto\VacationApiDto;
use Evrinoma\VacationBundle\Tests\Functional\Helper\BaseVacationTestTrait;
use PHPUnit\Framework\Assert;

class BaseVacation extends AbstractServiceTest implements BaseVacationTestInterface
{
    use BaseVacationTestTrait;

//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/vacation/vacation';
    public const API_CRITERIA = 'evrinoma/api/vacation/vacation/criteria';
    public const API_DELETE   = 'evrinoma/api/vacation/vacation/delete';
    public const API_PUT      = 'evrinoma/api/vacation/vacation/save';
    public const API_POST     = 'evrinoma/api/vacation/vacation/create';
//endregion Fields


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

    public function actionPost(): void
    {
        $this->createVacation();
        //  var_dump($this->client->getResponse()->getContent());
        $this->testResponseStatusCreated();
    }

    public function actionCriteriaNotFound(): void
    {
        Assert::markTestIncomplete('This test has not been implemented yet.');
    }

    public function actionCriteria(): void
    {
        Assert::markTestIncomplete('This test has not been implemented yet.');
    }

    public function actionDelete(): void
    {
        Assert::markTestIncomplete('This test has not been implemented yet.');
    }

    public function actionPut(): void
    {
        Assert::markTestIncomplete('This test has not been implemented yet.');
    }

    public function actionGet(): void
    {
        Assert::markTestIncomplete('This test has not been implemented yet.');
    }

    public function actionGetNotFound(): void
    {
        Assert::markTestIncomplete('This test has not been implemented yet.');
    }

    public function actionDeleteNotFound(): void
    {
        Assert::markTestIncomplete('This test has not been implemented yet.');
    }

    public function actionDeleteUnprocessable(): void
    {
        Assert::markTestIncomplete('This test has not been implemented yet.');
    }

    public function actionPutNotFound(): void
    {
        Assert::markTestIncomplete('This test has not been implemented yet.');
    }

    public function actionPutUnprocessable(): void
    {
        Assert::markTestIncomplete('This test has not been implemented yet.');
    }

    public function actionPostDuplicate(): void
    {
        Assert::markTestIncomplete('This test has not been implemented yet.');
    }

    public function actionPostUnprocessable(): void
    {
        Assert::markTestIncomplete('This test has not been implemented yet.');
    }
//endregion Public


//region SECTION: Getters/Setters
    public static function getDtoClass(): string
    {
        return VacationApiDto::class;
    }
//endregion Getters/Setters
}