<?php

declare(strict_types=1);

/*
 * Contao Onepage Navigation for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2025, Erdmann & Freunde
 * @author     Erdmann & Freunde <https://erdmann-freunde.de>
 * @license    MIT
 * @link       https://github.com/erdmannfreunde/contao-onepage-navigation
 */

use Contao\CoreBundle\DataContainer\PaletteManipulator;

/*
 * Palettes
 */
PaletteManipulator::create()
    ->addLegend('onepage_legend', 'layout_legend', PaletteManipulator::POSITION_BEFORE)
    ->addField('addNavigation', 'onepage_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_article');

$GLOBALS['TL_DCA']['tl_article']['palettes']['__selector__'][] = 'addNavigation';
$GLOBALS['TL_DCA']['tl_article']['subpalettes']['addNavigation'] = 'navigation_title,navigation_jumpTo';

/*
 * Fields
 */
$GLOBALS['TL_DCA']['tl_article']['fields']['addNavigation'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'submitOnChange' => true,
        'doNotCopy' => true,
    ],
    'sql' => [
        'type' => 'string',
        'length' => 1,
        'fixed' => true,
        'default' => '',
    ],
];

$GLOBALS['TL_DCA']['tl_article']['fields']['navigation_title'] = [
    'exclude' => true,
    'inputType' => 'text',
    'search' => true,
    'eval' => [
        'mandatory' => false,
        'decodeEntities' => true,
        'maxlength' => 255,
        'tl_class' => 'w50',
    ],
    'sql' => [
        'type' => 'string',
        'default' => '',
    ],
];

$GLOBALS['TL_DCA']['tl_article']['fields']['navigation_jumpTo'] = [
    'exclude' => true,
    'inputType' => 'text',
    'search' => true,
    'eval' => [
        'maxlength' => 255,
        'tl_class' => 'w50',
        'rgxp' => 'alias',
    ],
    'sql' => [
        'type' => 'string',
        'default' => '',
    ],
];
