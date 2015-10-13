<?php

namespace Zapoyok\ContentBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PageAdmin extends Admin
{
    private $unmappedTranslations = [];
    private $languages            = [];

    protected $translationDomain = 'admin';

    public function setLanguages($languages)
    {
        if (!is_array($languages)) {
            $languages = [$languages];
        }
        foreach ($languages as $lg) {
            $this->languages[$lg] = /* @Ignore */ $this->trans($lg);
        }
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->with('General', ['class' => 'col-md-6'])->end()
        ->with('Language', ['class' => 'col-md-6'])->end()
        ->with('Contenu', ['class' => 'col-md-12'])->end()
        ->with('Seo', ['class' => 'col-md-12'])->end()
        ;

        $formMapper
            ->with('General')
                ->add('permalink', null, ['required' => true, /* @Ignore */'help' => $this->trans('zapoyok_content.form.help.permalink', [], 'admin')])
                ->add('title', null, ['required' => true])
            ->end()
            ->with('Language')
                ->add('language', 'choice', ['choices' => $this->languages])
                ->add('translations', 'sonata_type_collection', [
                        'cascade_validation' => true,
                        /* @Ignore */'label' => $this->trans('zapoyok_content.page.translations.label', [], 'admin'),
                    ], [
                        'edit'            => 'inline',
                        'inline'          => 'table',
                        'sortable'        => 'position',
                        'link_parameters' => ['context' => 'default'],
                        'admin_code'      => 'zapoyok_content.admin.translation',
                    ]
                )
            ->end()
            ->with('Contenu')
                ->add('message', 'ckeditor', [/* @Ignore */'label' => false])
            ->end()
            ->with('Seo')
                ->add('name', null, ['required' => false])
                ->add('meta_keywords', 'text', ['required' => false])
                ->add('meta_description', 'text', ['required' => false])
            ->end()
                ;

        if ($this->getSubject()->getLocked()) {
            $formMapper->add('permalink', null, [
                'required' => true,
                /* @Ignore */
                'help' => $this->trans('zapoyok_content.form.help.permalink.locked', [], 'admin'),
                'attr' => ['readonly' => true]
            ]);
        }
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->addIdentifier('permalink')
            ->add('language', null, [
                /* @Ignore */
                'label' => $this->trans('zapoyok_content.list.label_languages', [], 'admin'), ])
            ->add('translations', null, [
                'associated_property' => 'translation.language',
                /* @Ignore */
                'label' => $this->trans('zapoyok_content.list.label_translations', [], 'admin'), ])

        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid)
    {
        $datagrid
        ->add('title')
        ->add('permalink')
        ->add('language')
        ;
    }

    public function prePersist($object)
    {
        foreach ($object->getTranslations() as $translation) {
            $object->removeTranslation($translation);
            $this->unmappedTranslations[] = $translation;
        }
    }

    public function preUpdate($object)
    {
        $object->setTranslations($object->getTranslations());
    }

    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return [];
        }

        return [
            'provider' => $this->getRequest()->get('provider'),
            'context'  => $this->getRequest()->get('context'),
        ];
    }

    public function postPersist($object)
    {
        if (count($this->unmappedTranslations)) {
            foreach ($this->unmappedTranslations as $translation) {
                $object->addTranslation($translation);
            }
        }
        $this->update($object);
    }
}
