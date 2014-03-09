<?php

namespace Baglie\CartBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class CartAddType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['file_type'] = $options['file_type'];
        $view->vars['template'] = $options['template'];
        $view->vars['extensions'] = $options['extensions'];
        $view->vars['btn_name'] = $options['btn_name'];
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'compound' => false,
            'class' => 'cartAdd',
            'btn_name' => 'CartAdd',
            'template' => 'BaglieCartBundle:Cart:add.html.twig',
        ));
    }


    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'cartAdd';
    }
}