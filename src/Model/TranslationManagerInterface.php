<?php

namespace Zapoyok\ContentBundle\Model;

interface TranslationManagerInterface
{
    /**
     * @return MessageInterface
     */
    public function create();

    /**
     * @param TranslationInterface $message
     */
    public function remove(TranslationInterface $message);

    /**
     *
     */
    public function save(TranslationInterface $message);
}
