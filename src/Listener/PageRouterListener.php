<?php

namespace Zapoyok\ContentBundle\Listener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

class PageRouterListener
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var UrlMatcherInterface
     */
    protected $urlMatcher;

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger
     *                                the monolog logger
     */
    public function __construct(UrlMatcherInterface $urlMatcher, LoggerInterface $logger = null)
    {
        $this->logger     = $logger;
        $this->urlMatcher = $urlMatcher;
    }

    /**
     * onKernelRequest called on event kernel.request.
     *
     * @param GetResponseEvent $event
     *                                the event dispatched on kernel.request
     *
     * @return array|null
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernel::MASTER_REQUEST != $event->getRequestType()) {
            return;
        }

        $request = $event->getRequest();

        if ($request->attributes->has('_controller')) {
            // routing is already done
            return;
        }

        // Do not analyse the devel url : _trans, _wts, …
        if (0 === strpos($request->getPathInfo(), '_')) {
            return;
        }

        try {
            $parameters = $this->getUrlMatcher()->match($request->getPathInfo());
            /*
             * Here, you can execute your logic to match the given url.
             * $parameters = YourRouterService->match($request->getPathInfo())
             * parameters should be an array :
             * array(
             * '_controller' => 'MyBundle:MyController:myAction',
             * '_route' => 'mybundle_mycontroller_myaction',
             * 'entity' => MyEntity matching with the route
             * )
             * You can pass any other key/value to your array.
             */

            if (null !== $this->logger) {
                $this->logger->info(sprintf('Matched route "%s"', $parameters['_route']));
            }

            // Add parameters to the request. If _controller is defined, the symfony routing event listener will not be executed.
            $request->attributes->add($parameters);

            // Unset the 2 parameters used by the framework and add _route_params with the remaining ones
            unset($parameters['_route']);
            unset($parameters['_controller']);
            $request->attributes->set('_route_params', $parameters);
        } catch (ResourceNotFoundException $e) {
            return;
        }
    }

    public function getLogger()
    {
        return $this->logger;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    public function getUrlMatcher()
    {
        return $this->urlMatcher;
    }

    public function setUrlMatcher(UrlMatcherInterface $urlMatcher)
    {
        $this->urlMatcher = $urlMatcher;

        return $this;
    }
}
