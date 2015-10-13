<?php

namespace Zapoyok\ContentBundle\Entity;

use Zapoyok\ContentBundle\Model\Page as AbstractPage;

class Page extends AbstractPage
{
    public function __construct()
    {
        $this->translations   = new \Doctrine\Common\Collections\ArrayCollection();
        $this->translatedByMe = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
