<?php

namespace Zapoyok\ContentBundle\Entity;

use Doctrine\ORM\EntityRepository;

class TranslationRepository extends EntityRepository
{
    private static function _extractIds($entity)
    {
        $arrTranslated   = [];
        $arrTranslated[] = $entity->getId();
        foreach ($entity->getTranslations() as $translatedPage) {
            $arrTranslated[] = $translatedPage->getTranslation()->getId();
        }

        return $arrTranslated;
    }

    /**
     * Suppression de toutes les translations concernant les pages translatées.
     *
     * @param unknown $entity
     */
    public function cleanupTranslations($entity)
    {
        $arrTranslated = self::_extractIds($entity);

        $qb = $this->createQueryBuilder('t');
        $qb->delete()
            ->andWhere($qb->expr()->in('t.page', $arrTranslated))
            ->orWhere($qb->expr()->in('t.translation', $arrTranslated))
        ;

//         echo $qb->getQuery()->getSQL();
        $qb->getQuery()->execute();

        return $arrTranslated;
    }
}
