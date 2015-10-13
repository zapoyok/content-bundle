<?php

namespace Zapoyok\ContentBundle\Entity;

use Doctrine\ORM\EntityManager;
use Zapoyok\ContentBundle\Model\PageManagerInterface;
use Zapoyok\ContentBundle\Model\TranslationInterface;
use Zapoyok\ContentBundle\Model\TranslationManagerInterface;

class TranslationManager implements TranslationManagerInterface
{
    protected $em;
    protected $pageManager;

    public function __construct(EntityManager $em, PageManagerInterface $pageManager)
    {
        $this->em          = $em;
        $this->pageManager = $pageManager;
    }

    public function create()
    {
        return new Translation();
    }

    public function findOneById($id)
    {
        return $this->getRepository()->findOneBy(['id' => $id]);
    }

    public function findOneBy($arr)
    {
        return $this->getRepository()->findOneBy($arr);
    }

    public function findBy($arr)
    {
        return $this->getRepository()->findBy($arr);
    }

    public function remove(TranslationInterface $entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }

    // Suppression de toutes les translations concernat les pages translatées.
    public function cleanupTranslations($entity)
    {
        return $this->getRepository()->cleanupTranslations($entity);
    }

    // Suppression de toutes les translations concernat les pages translatées.
    public function generateTranslations($ids)
    {
        $pages = [];
        foreach ($ids as $id) {
            $pages[$id] = $this->pageManager->findOneById($id);
        }

        foreach ($pages as $p) {
            foreach ($pages as $t) {
                if ($p->getId() != $t->getId()) {
                    $n = $this->create();
                    $n->setPage($p)
                        ->setTranslation($t);
                    $this->em->persist($n);
                }
            }
        }
        $this->em->flush();
    }

    public function getRepository()
    {
        return $this->em->getRepository('ZapoyokContentBundle:Translation');
    }

    public function save(TranslationInterface $entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }
}
