<?php
declare(strict_types=1);

namespace Amazing\Media2click\Upgrade;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard('media2click_migratePlugins')]
final class PluginUpgradeWizard implements UpgradeWizardInterface
{

	/**
	 * @inheritDoc
	 */
	public function getTitle(): string
	{
		return 'Media2Click Plugin to CE Converter';
	}

	/**
	 * @inheritDoc
	 */
	public function getDescription(): string
	{
		return 'Convert Media2Click list plugins to content elements and migrate the corresponding user permissions.';
	}

	/**
	 * @inheritDoc
	 */
	public function executeUpdate(): bool
	{
		$this->performContentMigration();
        $this->performBeGroupsMigration();
        return true;
	}

	/**
	 * @inheritDoc
	 */
	public function updateNecessary(): bool
	{
		return (count($this->getContentMigrationRecords()) > 0 || count($this->getBeGroupsMigrationRecords()) > 0);
	}

	/**
	 * @inheritDoc
	 */
	public function getPrerequisites(): array
	{
		return [];
	}

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    protected function getContentMigrationRecords(): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        return $queryBuilder
            ->select('uid', 'pid', 'CType', 'list_type')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq(
                    'CType',
                    $queryBuilder->createNamedParameter('list')
                ),
                $queryBuilder->expr()->eq(
                    'list_type',
                    $queryBuilder->createNamedParameter('media2click_list')
                )
            )
            ->executeQuery()
            ->fetchAllAssociative();
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    protected function getBeGroupsMigrationRecords(): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('be_groups');
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        return $queryBuilder
            ->select('uid', 'pid', 'explicit_allowdeny')
            ->from('be_groups')
            ->where(
                $queryBuilder->expr()->like(
                    'explicit_allowdeny',
                    $queryBuilder->createNamedParameter('%tt_content:list_type:media2click_list%')
                )
            )
            ->executeQuery()
            ->fetchAllAssociative();
    }

    protected function performContentMigration(): void
    {
        $records = $this->getContentMigrationRecords();
        if (!count($records)) {
            return;
        }

        foreach ($records as $record)
        {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
            $queryBuilder->update('tt_content')
                ->set('CType', 'media2click_list')
                ->set('list_type', '')
                ->where(
                    $queryBuilder->expr()->eq(
                        'uid',
                        $queryBuilder->createNamedParameter($record['uid'], Connection::PARAM_INT)
                    )
                )
                ->executeStatement();
        }
    }

    protected function performBeGroupsMigration(): void
    {
        $records = $this->getBeGroupsMigrationRecords();
        if (!count($records)) {
            return;
        }

        foreach ($records as $record) {
            $explicitAllowdeny = str_replace('tt_content:list_type:media2click_list', 'tt_content:CType:media2click_list', $record['explicit_allowdeny']);
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('be_groups');
            $queryBuilder->update('be_groups')
                ->set('explicit_allowdeny', $explicitAllowdeny)
                ->where(
                    $queryBuilder->expr()->eq(
                        'uid',
                        $queryBuilder->createNamedParameter($record['uid'], Connection::PARAM_INT)
                    )
                )
                ->executeStatement();
        }
    }
}
