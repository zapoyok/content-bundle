<?php

namespace Zapoyok\ContentBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Zapoyok\ContentBundle\Model\PageInterface;

class Translation
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof PageInterface) {
            $this->container->get('logger')->info('Page : ' . $entity->getId());

            // Suppression de toutes les translations concernant les pages translatées.
            $arrTranslated = $this->container->get('zapoyok_content.translation.manager')->cleanupTranslations($entity);

            // Création de tous les couples possibles pour les ids de page fournis.
            $this->container->get('zapoyok_content.translation.manager')->generateTranslations($arrTranslated);
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof PageInterface) {
            $this->container->get('logger')->info('Page : ' . $entity->getId());

            // Suppression de toutes les translations concernant les pages translatées.
            $arrTranslated = $this->container->get('zapoyok_content.translation.manager')->cleanupTranslations($entity);

            // Création de tous les couples possibles pour les ids de page fournis.
            $this->container->get('zapoyok_content.translation.manager')->generateTranslations($arrTranslated);
        }
    }
}
