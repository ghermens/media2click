<?php

namespace Amazing\Media2click\Controller;

use Amazing\Media2click\Domain\Repository\HostRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class HostController extends ActionController
{
    /**
     * @var HostRepository
     */
    private $hostRepository;

    /**
     * @param HostRepository $hostRepository
     */
    public function injectHostRepository(HostRepository $hostRepository)
    {
        $this->hostRepository = $hostRepository;
    }

    public function indexAction()
    {
        $this->view->assign('hosts', $this->hostRepository->findByAllowPermanent('1'));
    }
}
