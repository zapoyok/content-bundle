<?php

namespace Zapoyok\ContentBundle\Model;

class Page implements PageInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $permalink;

    /**
     * @var bool
     */
    protected $locked = false;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $meta_keywords;

    /**
     * @var string
     */
    protected $meta_description;

    /**
     * @var string
     */
    protected $language;

    protected $translations;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    public function __toString()
    {
        return $this->getTitle();
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;

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

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getMetaKeywords()
    {
        return $this->meta_keywords;
    }

    public function setMetaKeywords($meta_keywords)
    {
        $this->meta_keywords = $meta_keywords;

        return $this;
    }

    public function getMetaDescription()
    {
        return $this->meta_description;
    }

    public function setMetaDescription($meta_description)
    {
        $this->meta_description = $meta_description;

        return $this;
    }

    public function getPermalink()
    {
        return $this->permalink;
    }

    public function setPermalink($permalink)
    {
        $this->permalink = $permalink;

        return $this;
    }

    /**
     * @return Boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }

    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    public function addTranslation(TranslationInterface $translation)
    {
        $translation->setPage($this);
        $this->translations[] = $translation;

        return $this;
    }

    public function removeTranslation(TranslationInterface $translation)
    {
        $this->translations->removeElement($translation);
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    public function setTranslations($translations)
    {
        if (count($translations) > 0) {
            $this->translations = null;
            foreach ($translations as $i) {
                $this->addTranslation($i);
            }
        }

        return $this;
    }
}
