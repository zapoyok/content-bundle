<?php

namespace Zapoyok\ContentBundle\Entity;

use Doctrine\ORM\EntityManager;
use Zapoyok\ContentBundle\Model\PageInterface;
use Zapoyok\ContentBundle\Model\PageManagerInterface;

class PageManager implements PageManagerInterface
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function create()
    {
        return new Page();
    }

    public function findOneById($id)
    {
        return $this->getRepository()->findOneBy(['id' => $id]);
    }

    public function findOneByPermalink($permalink)
    {
        return $this->getRepository()->findOneBy(['permalink' => $permalink]);
    }

    public function delete(PageInterface $message)
    {
        return;
    }

    public function getRepository()
    {
        return $this->em->getRepository('ZapoyokContentBundle:Page');
    }

    public function save(PageInterface $entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }
}
