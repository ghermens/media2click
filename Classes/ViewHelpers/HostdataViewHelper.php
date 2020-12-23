<?php


namespace Amazing\Media2click\ViewHelpers;


use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

class HostdataViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    public function initialize()
    {
        parent::initialize();
        $this->contentArgumentName = 'host';
    }

    /**
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('host', 'string', 'Host to extract from hostsData. If not in arguments then taken from tag content');
        $this->registerArgument('hostsData', 'array', 'Data of permanently activatable hosts', true);
        $this->registerArgument('name', 'string', 'Name of variable to create', false, 'hostData');
    }

    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $host = $renderChildrenClosure();
        if (is_array($arguments['hostsData'])) {
            foreach ($arguments['hostsData'] as $hostData) {
                if ($hostData['data']['host'] === $host) {
                    $value = $hostData['data'];
                    $value['logoImage'] = $hostData['logoImage'];
                    $renderingContext->getVariableProvider()->add($arguments['name'], $value);
                    break;
                }
            }
        }
    }
}
