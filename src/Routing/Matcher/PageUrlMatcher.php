<?php

namespace Zapoyok\ContentBundle\Routing\Matcher;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\RequestMatcherInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\VarDumper\VarDumper;
use Zapoyok\ContentBundle\Model\PageManagerInterface;

class PageUrlMatcher implements UrlMatcherInterface, RequestMatcherInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var PageManagerInterface
     */
    protected $pageManager;

    /**
     * @var RequestContext
     */
    protected $context;

    public function __construct(PageManagerInterface $pageManager, LoggerInterface $logger = null)
    {
        $this->logger      = $logger ?: new NullLogger();
        $this->pageManager = $pageManager;
    }

    public function match($pathInfo)
    {
        if (null !== $this->getPageManager()) {
            if (null !== ($page = $this->getPageManager()->findOneByPermalink($pathInfo))) {
                return [
                    '_controller'        => 'ZapoyokContentBundle:Page:index',
                    '_route'             => 'zapoyok_content_page_' . $page->getId(),
                    'ZapoyokContentPage' => $page,
                ];
            }
        }
        throw new ResourceNotFoundException();
    }

    /**
     * @ERROR!!!
     */
    public function setContext(RequestContext $context)
    {
        $this->context = $context;
    }

    /**
     * @ERROR!!!
     */
    public function getContext()
    {
        return $this->context;
    }

    public function getPageManager()
    {
        return $this->pageManager;
    }

    public function setPageManager(PageManagerInterface $pageManager)
    {
        $this->pageManager = $pageManager;

        return $this;
    }

    public function matchRequest(Request $request)
    {
        return $this->match($request->getPathInfo());
    }
}
