<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategoryAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list)
    {
       $list
           ->addIdentifier('name', TextType::class)
           ->add('_action', 'actions', array(
               'actions' => array(
                   'show' => array(),
                   'edit' => array(),
                   'delete' => array(),
               )
           ))
       ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('name');
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('name');
    }

    protected function configureShowFields(ShowMapper $show)
    {
        $show->add('name');
    }
}