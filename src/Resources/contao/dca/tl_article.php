<?php

declare(strict_types=1);

/*
 * Contao Onepage Navigation for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2021, Erdmann & Freunde
 * @author     Erdmann & Freunde <https://erdmann-freunde.de>
 * @license    MIT
 * @link       http://github.com/erdmannfreunde/contao-onepage-navigation
 */

use Contao\Backend;

/*
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_article']['palettes']['__selector__'][]   = 'addNavigation';
$GLOBALS['TL_DCA']['tl_article']['palettes']['default']          = str_replace('{layout_legend}', '{onepage_legend},addNavigation;{layout_legend}', $GLOBALS['TL_DCA']['tl_article']['palettes']['default']);
$GLOBALS['TL_DCA']['tl_article']['subpalettes']['addNavigation'] = 'navigation_title,navigation_jumpTo';

/*
 * Fields
 */
$GLOBALS['TL_DCA']['tl_article']['fields']['addNavigation'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_article']['addNavigation'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => [
        'submitOnChange'    => true,
        'doNotCopy'         => true,
    ],
    'sql'                     => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_article']['fields']['navigation_title'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_article']['navigation_title'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'search'                  => true,
    'eval'                    => [
        'mandatory'         => false,
        'decodeEntities'    => true,
        'maxlength'         => 255,
        'tl_class'          => 'w50',
    ],
    'sql'                     => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_article']['fields']['navigation_jumpTo'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_article']['navigation_jumpTo'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'search'                  => true,
    'eval'                    => [
        'maxlength'         => 255,
        'tl_class'          => 'w50',
        'rgxp'              => 'alias',
    ],
    'save_callback' => array(array('OnepageArticle', 'generateAlias')),
    'sql'                     => "varchar(255) NOT NULL default ''",
];

class OnepageArticle extends Backend {
    /**
     * Auto-generate the navigation_jumpTo if it has not been set yet
     *
     * @param mixed         $varValue
     * @param DataContainer $dc
     *
     * @return string
     *
     * @throws Exception
     */
    public function generateAlias($varValue, DataContainer $dc)
    {
        // Generate alias if there is none
        if (!$varValue)
        {
            $varValue = System::getContainer()->get('contao.slug')->generate($dc->activeRecord->navigation_title, ArticleModel::findByPk($dc->activeRecord->pid)->jumpTo, $aliasExists);
        }
        elseif (preg_match('/^[1-9]\d*$/', $varValue))
        {
            throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasNumeric'], $varValue));
        }

        return $varValue;
    }
}