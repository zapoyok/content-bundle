<?php

/**
 * This file is part of the ZapoyokBundles project.
 *
 * (c) Zapoyok S.A.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Zapoyok\ContentBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zapoyok\ContentBundle\Model\PageManagerInterface;

class UnLockPagePermalinkCommand extends ContainerAwareCommand
{
    protected $em;

    /**
     * @var PageManagerInterface
     */
    protected $pageManager;

    protected function configure()
    {
        $this
            ->setName('zapoyok:content:page:unlock')
            ->setDescription('')
            ->addArgument('permalink', InputArgument::REQUIRED, 'Permalink (Ex. « /legal »)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->pageManager = $this->getContainer()->get('zapoyok_content.page.manager');
        $this->em          = $this->getContainer()->get('doctrine')->getManager();

        if (null !== ($page = $this->pageManager->findOneByPermalink($input->getArgument('permalink')))) {
            $page = $this->pageManager->findOneByPermalink($input->getArgument('permalink'));
            $page->setLocked(false);
            $this->pageManager->save($page);

            $output->writeln(sprintf('Page #%d « %s » Unlocked', $page->getId(), $input->getArgument('permalink')));
        } else {
            $output->writeln(sprintf('<error>Page « %s » does not exist', $input->getArgument('permalink')));
        }
    }
}
