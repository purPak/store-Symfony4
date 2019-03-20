<?php

namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProductAdmin extends AbstractAdmin
{
    /**
     * Les champs qui apparaitront dans la liste (tableau)
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('name')
            ->add('price')
            ->add('isPublished')
            ->add('nbViews')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('category.name')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array([
                        //"template" => "@App/Admin/custom/show.html.twig"
                    ]),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * Les champs qui apparaitront dans les formulaires (ajout et édition)
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->with('Informations d\'identification')
                ->add('name')
                ->add('description')
                ->add('price')
                ->add('isPublished')
            ->end()

            ->with('Éléments liés')
                ->add('imageFile', FileType::class)
                ->add('category', ModelType::class)
                ->add('tags', ModelType::class, [
                    'multiple' => true
                ])
            ->end()
        ;
    }

    /**
     * Les champs qui apparaitront dans la vue de détail
     * @param ShowMapper $show
     */
    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->add('id')
            ->add('name')
            ->add('description')
            ->add('price')
            ->add('isPublishedt')
            ->add('nbViews')
            ->add('category')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('imageName', null, array([
                //"template" => "@App/Admin/custom/show.html.twig"
            ]))
        ;
    }

    /**
     * Les champs qui apparaitront dans les filtres de recherches
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {

        $filter
            ->add('name')
            ->add('description')
            ->add('price')
            ->add('isPublished')
            ->add('nbViews')
            ->add('category')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }
}