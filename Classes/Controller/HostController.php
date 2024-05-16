<?php
declare(strict_types=1);

namespace Amazing\Media2click\Controller;

use Amazing\Media2click\Domain\Repository\HostRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class HostController extends ActionController
{
    private HostRepository $hostRepository;

    public function injectHostRepository(HostRepository $hostRepository): void
    {
        $this->hostRepository = $hostRepository;
    }

    public function indexAction(): ResponseInterface
    {
        $hosts = $this->settings['includeHosts'] ?? '';
        $this->view->assign('hosts', $this->hostRepository->findHostsForToggle($hosts));
        return $this->htmlResponse();
    }
}
