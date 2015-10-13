<?php

namespace Zapoyok\ContentBundle\Model;

interface PageManagerInterface
{
    /**
     * Creates an empty message instance.
     *
     * @return MessageInterface
     */
    public function create();

    /**
     * Deletes a message.
     *
     * @param MessageInterface $message
     */
    public function delete(PageInterface $message);

    /**
     * Save a message.
     */
    public function save(PageInterface $message);

    /**
     * Find a page by its permalink.
     *
     * @param string $permalink
     *
     * @return Page
     */
    public function findOneByPermalink($permalink);
}
