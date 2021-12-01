<?php

namespace Evrinoma\VacationBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\IdTrait;
use Evrinoma\VacationBundle\Model\ModelInterface;
use Symfony\Component\HttpFoundation\Request;

class VacationApiDto extends AbstractDto implements VacationApiDtoInterface
{
    use IdTrait;

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
//endregion Private

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id = $request->get(ModelInterface::ID);

            if ($id) {
                $this->setId($id);
            }
        }

        return $this;
    }
//endregion SECTION: Dto
}
