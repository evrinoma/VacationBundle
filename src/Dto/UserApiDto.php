<?php

namespace Evrinoma\VacationBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdTrait;
use Symfony\Component\HttpFoundation\Request;

class UserApiDto  extends AbstractDto implements UserApiDtoInterface
{
    use IdTrait;

    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {

            $user      = $request->get(UserApiDtoInterface::AUTHOR);
            $resolver  = $request->get(UserApiDtoInterface::RESOLVED_BY);

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