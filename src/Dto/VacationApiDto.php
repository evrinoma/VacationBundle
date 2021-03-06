<?php

namespace Evrinoma\VacationBundle\Dto;

use Evrinoma\DtoBundle\Annotation\Dto;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdTrait;
use Symfony\Component\HttpFoundation\Request;

class VacationApiDto extends AbstractDto implements VacationApiDtoInterface
{
    use IdTrait;

//region SECTION: Fields
    /**
     * @Dto(class="Evrinoma\VacationBundle\Dto\RangeApiDto", generator="genRequestRangeApiDto")
     * @var RangeApiDto|null
     */
    private ?RangeApiDto $rangeApiDto = null;
    /**
     * @Dto(class="Evrinoma\VacationBundle\Dto\UserApiDto", generator="genRequestAuthorApiDto")
     * @var UserApiDto|null
     */
    private ?UserApiDto $user = null;
    /**
     * @var string|null
     */
    private ?string $status = null;
    /**
     * @Dto(class="Evrinoma\VacationBundle\Dto\UserApiDto", generator="genRequestResolvedApiDto")
     * @var UserApiDto|null
     */
    private ?UserApiDto $resolver = null;
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function hasResolver(): bool
    {
        return $this->resolver !== null;
    }

    /**
     * @return bool
     */
    public function hasUser(): bool
    {
        return $this->user !== null;
    }

    /**
     * @return bool
     */
    public function hasStatus(): bool
    {
        return $this->status !== null;
    }
//endregion Public

//region SECTION: Private
    public function setResolver(UserApiDtoInterface $resolver): DtoInterface
    {
        $this->resolver = $resolver;

        return $this;
    }

    private function setStatus(string $status): DtoInterface
    {
        $this->status = $status;

        return $this;

    }

    public function setUser(UserApiDtoInterface $user): DtoInterface
    {
        $this->user = $user;

        return $this;
    }
//endregion Private

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {

            $id     = $request->get(VacationApiDtoInterface::ID);
            $status = $request->get(VacationApiDtoInterface::STATUS);

            if ($id) {
                $this->setId($id);
            }

            if ($status) {
                $this->setStatus($status);
            }

        }

        return $this;
    }

    /**
     * @return \Generator
     */
    public function genRequestRangeApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $dateStart = $request->get(RangeApiDtoInterface::DATE_START);
            $dateEnd   = $request->get(RangeApiDtoInterface::DATE_END);
            if ($dateStart && $dateEnd) {
                $newRequest                        = $this->getCloneRequest();
                $range[DtoInterface::DTO_CLASS]    = RangeApiDto::class;
                $range[RangeApiDtoInterface::DATE_START] = $dateStart;
                $range[RangeApiDtoInterface::DATE_END]   = $dateEnd;
                $newRequest->request->add($range);

                yield $newRequest;
            }
        }
    }

    /**
     * @return \Generator
     */
    public function genRequestAuthorApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $author = $request->get(UserApiDtoInterface::AUTHOR);
            if ($author) {
                $newRequest                    = $this->getCloneRequest();
                $user[DtoInterface::DTO_CLASS] = UserApiDto::class;
                $user[UserApiDtoInterface::AUTHOR]  = $author;
                $newRequest->request->add($user);

                yield $newRequest;
            }
        }
    }

    /**
     * @return \Generator
     */
    public function genRequestResolvedApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $resolver = $request->get(UserApiDtoInterface::RESOLVED_BY);
            if ($resolver) {
                $newRequest                        = $this->getCloneRequest();
                $user[DtoInterface::DTO_CLASS]     = UserApiDto::class;
                $user[UserApiDtoInterface::RESOLVED_BY] = $resolver;
                $newRequest->request->add($user);

                yield $newRequest;
            }
        }
    }

    /**
     * @return bool
     */
    public function hasRangeApiDto(): bool
    {
        return $this->rangeApiDto !== null;
    }

    /**
     * @param RangeApiDtoInterface|null $rangeApiDto
     *
     * @return VacationApiDtoInterface
     */
    public function setRangeApiDto(?RangeApiDtoInterface $rangeApiDto): VacationApiDtoInterface
    {
        $this->rangeApiDto = $rangeApiDto;

        return $this;
    }

    /**
     * @return RangeApiDtoInterface
     */
    public function getRangeApiDto(): RangeApiDtoInterface
    {
        return $this->rangeApiDto;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return UserApiDtoInterface
     */
    public function getResolver(): UserApiDtoInterface
    {
        return $this->resolver;
    }

    /**
     * @return UserApiDtoInterface
     */
    public function getUser(): UserApiDtoInterface
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
//endregion Getters/Setters
}
