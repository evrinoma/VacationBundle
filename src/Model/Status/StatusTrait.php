<?php

namespace Evrinoma\VacationBundle\Model\Status;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

trait StatusTrait
{
//region SECTION: Fields
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=false)
     */
    protected string $status = StatusInterface::PENDING;
//endregion Fields

//region SECTION: Public
    /**
     * @VirtualProperty
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->status === StatusInterface::PENDING;
    }

    /**
     * @VirtualProperty
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->status === StatusInterface::APPROVED;
    }

    /**
     * @VirtualProperty
     * @return bool
     */
    public function isRejected(): bool
    {
        return $this->status === StatusInterface::REJECTED;
    }

//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return self
     */
    public function setStatus(string $status = StatusInterface::PENDING): self
    {
        switch ($status) {
            case StatusInterface::PENDING:
                $this->setStatusToPending();
                break;
            case StatusInterface::APPROVED:
                $this->setStatusToApproved();
                break;
            case StatusInterface::REJECTED:
                $this->setStatusToRejected();
                break;
        }

        return $this;
    }

    /**
     * @return self
     */
    public function setStatusToRejected(): self
    {
        $this->status = StatusInterface::REJECTED;

        return $this;
    }

    /**
     * @return self
     */
    public function setStatusToPending(): self
    {
        $this->status = StatusInterface::PENDING;

        return $this;
    }

    /**
     * @return self
     */
    public function setStatusToApproved(): self
    {
        $this->status = StatusInterface::APPROVED;

        return $this;
    }
//endregion Getters/Setters
}