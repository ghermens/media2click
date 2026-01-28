<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Amazing\Media2click\ViewHelpers\Uri;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;

/**
 * A ViewHelper for parsing URIs for their parts, host by default
 *
 * Examples
 * ========
 *
 * Default
 * -------
 *
 * ::
 *
 *    {namespace m = Amazing\Media2click\ViewHelpers}
 *    <m:uri.part uri="https://www.typo3.org" />
 *
 * ``www.typo3.org``
 *
 * Custom default scheme
 * ---------------------
 *
 * ::
 *
 *    <m:uri.part uri="https://typo3.org" part="scheme" />
 *
 * ``https``
 */
class PartViewHelper extends AbstractViewHelper
{
    /**
     * Initialize arguments
     *
     * @throws Exception
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('uri', 'string', 'target URI', true);
        $this->registerArgument('part', 'string', 'Which component of the url to return', false, 'host');
    }

    /**
     * @param array                     $arguments
     * @param \Closure                  $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string Rendered URI
     * @throws Exception
     */
    public function render(): string
    {
        if (!in_array(
            $this->arguments['part'],
            ['scheme', 'host', 'port', 'user', 'pass', 'path', 'query', 'fragment'],
        )) {
            throw new Exception(
                'Argument "part" has to be one of "scheme", "host", "port", "user", "pass", "path", "query", "fragment"',
                1253036401,
            );
        }

        $components = parse_url((string)$this->arguments['uri']);
        return $components[$this->arguments['part']] ?? '';
    }
}
