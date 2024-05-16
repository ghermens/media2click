<?php
declare(strict_types=1);

namespace Amazing\Media2click\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

class HostdataViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    public function initialize(): void
    {
        parent::initialize();
        $this->contentArgumentName = 'host';
    }

    public function initializeArguments(): void
    {
        $this->registerArgument('host', 'string', 'Host to extract from hostsData. If not in arguments then taken from tag content');
        $this->registerArgument('hostsData', 'array', 'Data of permanently activatable hosts', true);
        $this->registerArgument('name', 'string', 'Name of variable to create', false, 'hostData');
    }

    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): void
    {
        $host = $renderChildrenClosure();
        if (is_array($arguments['hostsData'])) {
            foreach ($arguments['hostsData'] as $hostData) {
                if ($hostData['data']['host'] === $host) {
                    $value = $hostData['data'];
                    $value['m2cLogoImage'] = $hostData['m2cLogoImage'];
                    $renderingContext->getVariableProvider()->add($arguments['name'], $value);
                    break;
                }
            }
        }
    }
}
