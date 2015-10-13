<?php

namespace Zapoyok\ContentBundle\Model;

class Translation implements TranslationInterface
{
    /**
     * @var number
     */
    protected $id;

    /**
     * @var PageInterface
     */
    protected $page;

    /**
     * @var PageInterface
     */
    protected $translation;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    public function getId()
    {
        return $this->id;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setPage(PageInterface $page = null)
    {
        $this->page = $page;

        return $this;
    }

    public function getTranslation()
    {
        return $this->translation;
    }

    public function setTranslation(PageInterface $translation = null)
    {
        $this->translation = $translation;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
