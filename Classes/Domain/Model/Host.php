<?php
namespace Amazing\Media2click\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Host extends AbstractEntity
{
    /**
     * @var string
     */
    protected $host = '';

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
