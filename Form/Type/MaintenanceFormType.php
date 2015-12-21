<?php

namespace UAM\Bundle\MaintenanceBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Bridge\Propel1\Form\Type\TranslationCollectionType;
use Symfony\Bridge\Propel1\Form\Type\TranslationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MaintenanceFormType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UAM\Bundle\MaintenanceBundle\Propel\Maintenance',
            'name' => 'maintenance',
            'translation_domain' => 'maintenance',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date_start', 'date', array(
            'label' => 'form.date_start.label',
            'attr' => array(
                'class' => 'datepicker',
            ),
            'format' => 'yyyy.MM.dd HH:mm:ss',
            'widget' => 'single_text',
        ));

        $builder->add('date_end', 'date', array(
            'label' => 'form.date_end.label',
            'attr' => array(
                'class' => 'datepicker',
            ),
            'format' => 'yyyy.MM.dd HH:mm:ss',
            'widget' => 'single_text',
        ));

        $builder->add('maintenanceI18ns', new TranslationCollectionType(), array(
            'languages' => array('en', 'fr'),
            'type' => new TranslationType(),
            'options' => array(
                'data_class' => 'UAM\Bundle\MaintenanceBundle\Propel\MaintenanceI18n',
                'columns' => array(
                    'description' => array(
                        'label' => null,
                    ),
                ),
            ),
            'label' => 'form.description.label',
        ));

        $builder->add('confirmed', 'choice', array(
            'label' => 'form.confirmed.label',
            'choices' => array(
                '0' => 0,
                '1' => 1,
            ),
        ));

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $maintenance = $event->getData();
            $form = $event->getForm();

            $form->add('submit', 'submit', array(
                'label' => $maintenance->isNew() ? 'form.create.submit' : 'form.edit.submit',
            ));
        });
    }
}
