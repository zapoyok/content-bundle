<?php

namespace Zapoyok\ContentBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends ContainerAware
{
    public function indexAction(Request $request)
    {
        if (null === ($page = $request->get('ZapoyokContentPage', null))) {
            /* @var $page \Zapoyok\ContentBundle\Model\Page */
            $page = $this->getPageOr404($request->get('permalink', null));
        }

        $seoPage = $this->getSeoManager();

        $title = $page->getName() ? $page->getName() : $page->getTitle();

        $seoPage
            ->setTitle(htmlentities($title))
            ->addMeta('property', 'og:title', $title)
            ->addMeta('property', 'og:type', 'article')
//         ->addMeta('property', 'og:url',  $this->generateUrl('sonata_news_view', array(
//             'permalink'  => $this->getBlog()->getPermalinkGenerator()->generate($post, true)
//         ), true))
        ;
        if ($page->getMetaDescription()) {
            $seoPage
                ->addMeta('property', 'og:description', $page->getMetaDescription())
                ->addMeta('name', 'description', $page->getMetaDescription());
        }

        if ($page->getMetaKeywords()) {
            $seoPage
                ->addMeta('name', 'keywords', $page->getMetaKeywords());
        }

        $parameters = ['page' => $page];
        $template   = $this->container->getParameter('zapoyok_content.templates.page');

        return $this->container->get('templating')->renderResponse($template, $parameters);
    }

    public function getPageManager()
    {
        return $this->container->get('zapoyok_content.page.manager');
    }
    public function getSeoManager()
    {
        return $this->container->get('sonata.seo.page');
    }

    /**
     * @param string $name
     *
     * @throws NotFoundHttpException
     *
     * @return TripInterface
     */
    protected function getPageOr404($permalink)
    {
        if (!$page = $this->getPageManager()->findOneByPermalink($permalink)) {
            throw new NotFoundHttpException(sprintf('The page \'%s\' was not found.', $permalink));
        }

        return $page;
    }
}
