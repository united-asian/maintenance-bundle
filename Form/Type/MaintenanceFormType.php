<?php

namespace UAM\Bundle\MaintenanceBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MaintenanceFormType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UAM\Bundle\MaintenanceBundle\Propel\Maintenance',
            'name'       => 'maintenance',
            'translation_domain' => 'maintenance',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date_start', 'date', array(
            'label' => 'maintenance.form.date_start.label',
            'attr' => array(
                'class' => 'datepicker',
            ),
            'format' => 'dd.MM.yyyy',
            'widget' => 'single_text',
        ));

        $builder->add('date_end', 'date', array(
            'label' => 'maintenance.form.date_end.label',
            'attr' => array(
                'class' => 'datepicker',
            ),
            'format' => 'dd.MM.yyyy',
            'widget' => 'single_text',
        ));

        $builder->add('confirmed', 'choice', array(
            'label' => 'maintenance.form.confirmed.label',
            'choices' => array(
                '0' => 0,
                '1' => 1
            ),
        ));

        $builder->add('submit', 'submit', array(
            'label' => 'maintenance.form.submit',
        ));
    }
}
