<?php
declare(strict_types=1);

namespace Amazing\Media2click\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class HostdataViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument('host', 'string', 'Host to extract from hostsData. If not in arguments then taken from tag content');
        $this->registerArgument('hostsData', 'array', 'Data of permanently activatable hosts', true);
        $this->registerArgument('name', 'string', 'Name of variable to create', false, 'hostData');
    }

    public function render(): void
    {
        $host = $this->renderChildren();
        if (is_array($this->arguments['hostsData'])) {
            foreach ($this->arguments['hostsData'] as $hostData) {
                if ($hostData['data']['host'] === $host) {
                    $value = $hostData['data'];
                    $value['m2cLogoImage'] = $hostData['m2cLogoImage'];
                    $this->renderingContext->getVariableProvider()->add($this->arguments['name'], $value);
                    break;
                }
            }
        }
    }

    public function getContentArgumentName(): ?string
    {
        return 'host';
    }
}
