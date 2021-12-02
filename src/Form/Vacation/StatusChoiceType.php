<?php

namespace Evrinoma\VacationBundle\Form\Vacation;

use Evrinoma\UtilsBundle\Form\Rest\RestChoiceType;
use Evrinoma\VacationBundle\Model\Status\StatusInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatusChoiceType extends AbstractType
{

//region SECTION: Public
    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            return StatusInterface::STATUS;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'status');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'statusList');
        $resolver->setDefault(RestChoiceType::REST_CHOICES, $callback);
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getParent()
    {
        return RestChoiceType::class;
    }
//endregion Getters/Setters
}