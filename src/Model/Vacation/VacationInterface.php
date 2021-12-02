<?php


namespace Evrinoma\VacationBundle\Model\Vacation;

use Evrinoma\UtilsBundle\Entity\CreateUpdateAtInterface;
use Evrinoma\UtilsBundle\Entity\DateStartFinishInterface;
use Evrinoma\UtilsBundle\Entity\IdInterface;
use Evrinoma\VacationBundle\Model\Status\StatusInterface;

interface VacationInterface extends CreateUpdateAtInterface, IdInterface, DateStartFinishInterface, StatusInterface
{

}