<?php

namespace Evrinoma\VacationBundle\Manager\User;



use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;
use Evrinoma\VacationBundle\Exception\User\UserProxyException;
use Evrinoma\VacationBundle\Model\User\VacationInterface;


final class QueryManager implements QueryManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private UserQueryRepositoryInterface $repository;
//endregion Fields

//region SECTION: Constructor
    public function __construct(UserQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param UserApiDtoInterface $dto
     *
     * @return VacationInterface
     * @throws UserProxyException
     */
    public function proxy(UserApiDtoInterface $dto): VacationInterface
    {
        try {
            if ($dto->hasId()) {
                $vacation = $this->repository->proxy((string)$dto->getId());
            } else {
                throw new UserProxyException('entity does\'t have id');
            }
        } catch (UserProxyException $e) {
            throw $e;
        }

        return $vacation;
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}