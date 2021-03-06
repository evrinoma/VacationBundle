<?php

namespace Evrinoma\VacationBundle\Manager\Vacation;

use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;
use Evrinoma\VacationBundle\Dto\VacationApiDtoInterface;
use Evrinoma\VacationBundle\Exception\Vacation\VacationCannotBeCreatedException;
use Evrinoma\VacationBundle\Exception\Vacation\VacationCannotBeRemovedException;
use Evrinoma\VacationBundle\Exception\Vacation\VacationCannotBeSavedException;
use Evrinoma\VacationBundle\Exception\Vacation\VacationInvalidException;
use Evrinoma\VacationBundle\Exception\Vacation\VacationNotFoundException;
use Evrinoma\VacationBundle\Factory\VacationFactoryInterface;
use Evrinoma\VacationBundle\Manager\User\QueryManagerInterface as UserQueryManagerInterface;
use Evrinoma\VacationBundle\Mediator\Vacation\CommandMediatorInterface;
use Evrinoma\VacationBundle\Model\Vacation\VacationInterface;
use Evrinoma\VacationBundle\Repository\Vacation\VacationCommandRepositoryInterface;

final class CommandManager implements CommandManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private VacationCommandRepositoryInterface $repository;
    private ValidatorInterface                 $validator;
    private VacationFactoryInterface           $factory;
    private CommandMediatorInterface           $mediator;
    private UserQueryManagerInterface          $userQueryManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * @param ValidatorInterface                 $validator
     * @param VacationCommandRepositoryInterface $repository
     * @param VacationFactoryInterface           $factory
     * @param CommandMediatorInterface           $mediator
     * @param UserQueryManagerInterface          $userQueryManager
     */
    public function __construct(ValidatorInterface $validator, VacationCommandRepositoryInterface $repository, VacationFactoryInterface $factory, CommandMediatorInterface $mediator, UserQueryManagerInterface $userQueryManager)
    {
        $this->validator        = $validator;
        $this->repository       = $repository;
        $this->factory          = $factory;
        $this->mediator         = $mediator;
        $this->userQueryManager = $userQueryManager;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param VacationApiDtoInterface $dto
     *
     * @return VacationInterface
     * @throws VacationInvalidException
     * @throws VacationCannotBeCreatedException
     */
    public function post(VacationApiDtoInterface $dto): VacationInterface
    {
        if (!$dto->hasRangeApiDto()) {
            throw new VacationCannotBeCreatedException();
        }

        $vacation = $this->factory->create($dto);

        try {
            $vacation->setUser($this->userQueryManager->proxy($dto->getUser()));
        } catch (\Exception $e) {
            throw new VacationCannotBeCreatedException($e->getMessage());
        }

        try {
            $vacation->setResolver($this->userQueryManager->proxy($dto->getResolver()));
        } catch (\Exception $e) {
            throw new VacationCannotBeCreatedException($e->getMessage());
        }

        $this->mediator->onCreate($dto, $vacation);

        $errors = $this->validator->validate($vacation);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            throw new VacationInvalidException($errorsString);
        }

        $this->repository->save($vacation);

        return $vacation;
    }

    /**
     * @param VacationApiDtoInterface $dto
     *
     * @return VacationInterface
     * @throws VacationInvalidException
     * @throws VacationNotFoundException
     * @throws VacationCannotBeSavedException
     */
    public function put(VacationApiDtoInterface $dto): VacationInterface
    {
        try {
            $vacation = $this->repository->find($dto->getId());
        } catch (VacationNotFoundException $e) {
            throw $e;
        }

        if (!$dto->hasRangeApiDto()) {
            throw new VacationCannotBeSavedException();
        }

        try {
            $vacation->setUser($this->userQueryManager->proxy($dto->getUser()));
        } catch (\Exception $e) {
            throw new VacationCannotBeSavedException($e->getMessage());
        }

        try {
            $vacation->setResolver($this->userQueryManager->proxy($dto->getResolver()));
        } catch (\Exception $e) {
            throw new VacationCannotBeSavedException($e->getMessage());
        }

        $vacation
            ->setDateStart($dto->getRangeApiDto()->getStart())
            ->setDateFinish($dto->getRangeApiDto()->getEnd())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setStatus($dto->getStatus())
        ;

        $this->mediator->onUpdate($dto, $vacation);

        $errors = $this->validator->validate($vacation);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            throw new VacationInvalidException($errorsString);
        }

        $this->repository->save($vacation);

        return $vacation;
    }

    /**
     * @param VacationApiDtoInterface $dto
     *
     * @throws VacationCannotBeRemovedException
     * @throws VacationNotFoundException
     */
    public function delete(VacationApiDtoInterface $dto): void
    {
        try {
            $vacation = $this->repository->find($dto->getId());
        } catch (VacationNotFoundException $e) {
            throw $e;
        }
        $this->mediator->onDelete($dto, $vacation);
        try {
            $this->repository->remove($vacation);
        } catch (VacationCannotBeRemovedException $e) {
            throw $e;
        }
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}