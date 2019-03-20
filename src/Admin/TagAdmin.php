<?php

namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TagAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('name')
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('name')
        ;
    }
}