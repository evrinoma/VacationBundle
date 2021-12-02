<?php

namespace Evrinoma\VacationBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\VacationBundle\Model\ModelInterface;
use Symfony\Component\HttpFoundation\Request;

class RangeApiDto extends AbstractDto implements RangeApiDtoInterface
{
//region SECTION: Fields
    private ?\DateTimeImmutable $start = null;
    private ?\DateTimeImmutable $end   = null;
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function hasRange(): bool
    {
        return $this->hasStart() && $this->hasEnd();
    }

    /**
     * @return bool
     */
    public function hasStart(): bool
    {
        return $this->start !== null;
    }

    /**
     * @return bool
     */
    public function hasEnd(): bool
    {
        return $this->end !== null;
    }
//endregion Public

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {

            $start = $request->get(ModelInterface::DATE_START);
            $end   = $request->get(ModelInterface::DATE_END);
            
            if ($start) {
                $this->setStart(new \DateTimeImmutable($start));
            }

            if ($end) {
                $this->setEnd(new \DateTimeImmutable($end));
            }
        }

        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return \DateTimeImmutable|null
     */
    public function getStart(): ?\DateTimeImmutable
    {
        return $this->start;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getEnd(): ?\DateTimeImmutable
    {
        return $this->end;
    }

    /**
     * @param \DateTimeImmutable|null $start
     *
     * @return RangeApiDtoInterface
     */
    public function setStart(?\DateTimeImmutable $start): RangeApiDtoInterface
    {
        $this->start = $start;

        return $this;
    }

    /**
     * @param \DateTimeImmutable|null $end
     *
     * @return RangeApiDtoInterface
     */
    public function setEnd(?\DateTimeImmutable $end): RangeApiDtoInterface
    {
        $this->end = $end;

        return $this;
    }
//endregion Getters/Setters
}
