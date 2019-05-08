<?php
namespace Faulancr\DdBoilerplate\ViewHelpers;

use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * Class AnimatedGifViewHelper
 */
class AnimatedGifViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'img';

    /**
     * Initialize the arguments.
     *
     * @return void
     * @api
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
    }

    /**
     * @param FileReference $file
     * @return string
     */

    public function render(FileReference $file)
    {
        $this->tag->addAttribute('src', $file->getPublicUrl());

        // The alt-attribute is mandatory to have valid html-code, therefore add it even if it is empty
        $alt = $file->getProperty('alternative');
        if (empty($alt)) {
            $alt = $file->getName();
        }
        $this->tag->addAttribute('alt', $alt);

        $title = $file->getProperty('title');
        if (!empty($title)) {
            $this->tag->addAttribute('title', $title);
        }

        return $this->tag->render();
    }
}
