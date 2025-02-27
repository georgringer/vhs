<?php
namespace FluidTYPO3\Vhs\ViewHelpers\Format;

/*
 * This file is part of the FluidTYPO3/Vhs project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * Trims $content by stripping off $characters (string list
 * of individual chars to strip off, default is all whitespaces).
 */
class TrimViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    public function initializeArguments(): void
    {
        $this->registerArgument('content', 'string', 'String to trim');
        $this->registerArgument('characters', 'string', 'List of characters to trim, no separators, e.g. "abc123"');
    }

    /**
     * Trims content by stripping off $characters
     *
     * @return mixed
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $characters = $arguments['characters'];
        $content = $renderChildrenClosure();
        if (!empty($characters)) {
            $content = trim($content, $characters);
        } else {
            $content = trim($content);
        }
        return $content;
    }
}
