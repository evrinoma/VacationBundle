<?php


namespace Evrinoma\VacationBundle\Model\Status;

interface StatusInterface
{
//region SECTION: Fields
    public const PENDING  = 'pending';
    public const APPROVED = 'approved';
    public const REJECTED = 'rejected';


    public const STATUS = [
        StatusInterface::PENDING,
        StatusInterface::APPROVED,
        StatusInterface::REJECTED,
    ];
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function isPending(): bool;

    /**
     * @return bool
     */
    public function isApproved(): bool;

    /**
     * @return bool
     */
    public function isRejected(): bool;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     * @param string $status
     *
     * @return self
     */
    public function setStatus(string $status = StatusInterface::PENDING): self;

    /**
     * @return self
     */
    public function setStatusToRejected(): self;

    /**
     * @return self
     */
    public function setStatusToPending(): self;

    /**
     * @return self
     */
    public function setStatusToApproved(): self;
//endregion Getters/Setters
}