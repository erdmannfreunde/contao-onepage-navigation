<?php

declare(strict_types=1);

/*
 * Contao Onepage Navigation for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2024, Erdmann & Freunde
 * @author     Erdmann & Freunde <https://erdmann-freunde.de>
 * @license    MIT
 * @link       https://github.com/erdmannfreunde/contao-onepage-navigation
 */

namespace EuF\OnepageNavigation\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\CoreBundle\Slug\Slug;
use Contao\DataContainer;

#[AsCallback(table: 'tl_article', target: 'fields.navigation_jumpTo.save')]
readonly class GenerateAliasSaveCallback
{
    public function __construct(
        private Slug $slug,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(mixed $value, DataContainer $dc): mixed
    {
        // Generate alias if there is none
        if (!$value) {
            $value = $this->slug->generate($dc->activeRecord->navigation_title);
        } elseif (preg_match('/^[1-9]\d*$/', $value)) {
            throw new \Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasNumeric'], $value));
        }

        return $value;
    }
}
