<?php
namespace FluidTYPO3\Vhs\ViewHelpers\Variable;

/*
 * This file is part of the FluidTYPO3/Vhs project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use FluidTYPO3\Vhs\Traits\TemplateVariableViewHelperTrait;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * ### PregMatch regular expression ViewHelper
 *
 * Implementation of `preg_match' for Fluid.
 */
class PregMatchViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;
    use TemplateVariableViewHelperTrait;

    /**
     * @var boolean
     */
    protected $escapeChildren = false;

    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        $this->registerAsArgument();
        $this->registerArgument('pattern', 'mixed', 'Regex pattern to match against', true);
        $this->registerArgument('subject', 'mixed', 'String to match with the regex pattern');
        $this->registerArgument('global', 'boolean', 'Match global', false, false);
    }

    /**
     * @return mixed
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        if (!isset($arguments['subject']) && !isset($arguments['as'])) {
            $subject = $renderChildrenClosure();
        } else {
            $subject = $arguments['subject'];
        }
        if ($arguments['global']) {
            preg_match_all($arguments['pattern'], $subject, $matches, PREG_SET_ORDER);
        } else {
            preg_match($arguments['pattern'], $subject, $matches);
        }
        return static::renderChildrenWithVariableOrReturnInputStatic(
            $matches,
            $arguments['as'],
            $renderingContext,
            $renderChildrenClosure
        );
    }
}
