<?php

namespace Zapoyok\ContentBundle\Model;

interface PageInterface
{
    public function setName($name);

    public function getName();

    public function getId();
}
