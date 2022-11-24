<?php
namespace Amazing\Media2click\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Host extends AbstractEntity
{
    /**
     * @var int
     */
    protected $allowPermanent = 0;

    /**
     * @var string
     */
    protected $host = '';

    /**
     * @var ObjectStorage<FileReference>
     */
    protected $logo = null;

    /**
     * @var string
     */
    protected $placeholder = '';

    /**
     * @var string
     */
    protected $privacyStatementLink = '';

    /**
     * @var string
     */
    protected $title = '';

    /**
     * Host constructor.
     */
    public function __construct()
    {
        $this->logo = new ObjectStorage();
    }

    /**
     * @return int
     */
    public function getAllowPermanent(): int
    {
        return $this->allowPermanent;
    }

    /**
     * @param int $allowPermanent
     */
    public function setAllowPermanent(int $allowPermanent): void
    {
        $this->allowPermanent = $allowPermanent;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @return ObjectStorage
     */
    public function getLogo(): ObjectStorage
    {
        return $this->logo;
    }

    /**
     * @param ObjectStorage $logo
     */
    public function setLogo(ObjectStorage $logo): void
    {
        $this->logo = $logo;
    }

    /**
     * @param FileReference $file
     */
    public function addLogo(FileReference $file) {
        $this->logo->attach($file);
    }

    /**
     * @return string
     */
    public function getPlaceholder(): string
    {
        return $this->placeholder;
    }

    /**
     * @param string $placeholder
     */
    public function setPlaceholder(string $placeholder): void
    {
        $this->placeholder = $placeholder;
    }

    /**
     * @return string
     */
    public function getPrivacyStatementLink(): string
    {
        return $this->privacyStatementLink;
    }

    /**
     * @param string $privacyStatementLink
     */
    public function setPrivacyStatementLink(string $privacyStatementLink): void
    {
        $this->privacyStatementLink = $privacyStatementLink;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
