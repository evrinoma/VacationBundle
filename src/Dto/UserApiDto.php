<?php

namespace Evrinoma\VacationBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\IdTrait;
use Evrinoma\VacationBundle\Model\ModelInterface;
use Symfony\Component\HttpFoundation\Request;

class UserApiDto  extends AbstractDto implements UserApiDtoInterface
{
    use IdTrait;

    /**
     * @param int|null $id
     *
     * @return UserApiDtoInterface
     */
    private function setId(?int $id): UserApiDtoInterface
    {
        $this->id = $id;

        return $this;
    }

    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {

            $user      = $request->get(ModelInterface::AUTHOR);
            $resolver  = $request->get(ModelInterface::RESOLVED_BY);

            if ($user) {
                $this->setId($user);
            }

            if ($resolver) {
                $this->setId($resolver);
            }

        }

        return $this;
    }
}