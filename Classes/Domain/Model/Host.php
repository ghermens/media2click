<?php
declare(strict_types=1);

namespace Amazing\Media2click\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Host extends AbstractEntity
{
    protected int $allowPermanent = 0;

    protected string $host = '';

    /**
     * @var ObjectStorage<FileReference>
     */
    protected ObjectStorage $logo;

    protected string $placeholder = '';

    protected string $privacyStatementLink = '';

    protected string $title = '';

    public function __construct()
    {
        $this->logo = new ObjectStorage();
    }

    public function getAllowPermanent(): int
    {
        return $this->allowPermanent;
    }

    public function setAllowPermanent(int $allowPermanent): void
    {
        $this->allowPermanent = $allowPermanent;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @return ObjectStorage<FileReference>
     */
    public function getLogo(): ObjectStorage
    {
        return $this->logo;
    }

    /**
     * @param ObjectStorage<FileReference> $logo
     */
    public function setLogo(ObjectStorage $logo): void
    {
        $this->logo = $logo;
    }

    public function addLogo(FileReference $file): void
    {
        $this->logo->attach($file);
    }

    public function getPlaceholder(): string
    {
        return $this->placeholder;
    }

    public function setPlaceholder(string $placeholder): void
    {
        $this->placeholder = $placeholder;
    }

    public function getPrivacyStatementLink(): string
    {
        return $this->privacyStatementLink;
    }

    public function setPrivacyStatementLink(string $privacyStatementLink): void
    {
        $this->privacyStatementLink = $privacyStatementLink;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
