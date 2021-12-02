<?php

namespace Evrinoma\VacationBundle\Dto;

use Evrinoma\DtoBundle\Annotation\Dto;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\IdTrait;
use Evrinoma\VacationBundle\Model\ModelInterface;
use Symfony\Component\HttpFoundation\Request;

class VacationApiDto extends AbstractDto implements VacationApiDtoInterface
{
    use IdTrait;

//region SECTION: Fields
    /**
     * @Dto(class="Evrinoma\VacationBundle\Dto\RangeApiDto", generator="genRequestRangeApiDto")
     * @var RangeApiDto|null
     */
    private ?RangeApiDto        $rangeApiDto = null;
    private ?\DateTimeImmutable $createdAt   = null;
    private ?string             $user        = null;
    private ?string             $status      = null;
    private ?string             $resolver    = null;
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function hasCreatedAt(): bool
    {
        return $this->createdAt !== null;
    }

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
    /**
     * @param int|null $id
     *
     * @return VacationApiDtoInterface
     */
    private function setId(?int $id): VacationApiDtoInterface
    {
        $this->id = $id;

        return $this;
    }

    private function setCreatedAt(\DateTimeImmutable $createdAt): VacationApiDtoInterface
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    private function setResolver(string $resolver): VacationApiDtoInterface
    {
        $this->resolver = $resolver;

        return $this;
    }

    private function setStatus(string $status): VacationApiDtoInterface
    {
        $this->status = $status;

        return $this;

    }

    private function setUser(string $user): VacationApiDtoInterface
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

            $id        = $request->get(ModelInterface::ID);
            $user      = $request->get(ModelInterface::AUTHOR);
            $status    = $request->get(ModelInterface::STATUS);
            $resolver  = $request->get(ModelInterface::RESOLVED_BY);
            $createdAt = $request->get(ModelInterface::CREATED_AT);

            if ($id) {
                $this->setId($id);
            }

            if ($user) {
                $this->setUser($user);
            }

            if ($status) {
                $this->setStatus($status);
            }

            if ($resolver) {
                $this->setResolver($resolver);
            }

            if ($createdAt) {
                $this->setCreatedAt((new \DateTimeImmutable)->setTimestamp((int)$createdAt));
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
            $type = $request->get('range');
            if ($type) {
                $newRequest                    = $this->getCloneRequest();
                $type[DtoInterface::DTO_CLASS] = RangeApiDto::class;
                $newRequest->request->add($type);

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
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return bool
     */
    public function getResolver(): bool
    {
        return $this->resolver;
    }

    /**
     * @return bool
     */
    public function getUser(): bool
    {
        return $this->user;
    }

    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }
//endregion Getters/Setters
}
