<?php

namespace Zapoyok\ContentBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TranslationAdmin extends Admin
{
    protected $formOptions = [
        'cascade_validation' => true,
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper

                 ->add('translation', 'sonata_type_model_list', ['required' => false], [])

            ->end();
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('page')
            ->addIdentifier('translation')
        ;
    }
}
