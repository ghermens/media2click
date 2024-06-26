<?php
declare(strict_types=1);

namespace Amazing\Media2click\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class HostRepository extends Repository
{
    /**
     * sort FE host list by BE sorting
     */
    protected $defaultOrderings = [
        'sorting' => QueryInterface::ORDER_ASCENDING,
    ];

    /**
     * @param string $includedHosts list of host uids
     * @throws InvalidQueryException
     */
    public function findHostsForToggle(string $includedHosts = ''): QueryResultInterface
    {
        $query = $this->createQuery();
        $includedHostsArray = GeneralUtility::intExplode(',', $includedHosts, true);
        if (count($includedHostsArray)) {
            $query->matching(
                $query->logicalAnd(
                    $query->equals('allowPermanent',1),
                    $query->in('uid', $includedHostsArray)
                )
            );
        } else {
            $query->matching(
                $query->equals('allowPermanent', 1)
            );
        }
        return $query->execute();
    }
}
