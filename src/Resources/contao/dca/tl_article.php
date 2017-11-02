<?php 

/**
 * @package     Onepage Navigation
 * @author      Sascha Brandhoff (https://github.com/Sascha-Brandhoff/onepage-navigation)
 * @author      Basti Buck (http://www.bastibuck.de)
 * @license     LGPLv3
 * @copyright   Erdmann & Freunde (https://erdmann-freunde.de)
 */


/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_article']['palettes']['__selector__'][]   = 'addNavigation';
$GLOBALS['TL_DCA']['tl_article']['palettes']['default']          = str_replace("{layout_legend}", "{onepage_legend},addNavigation;{layout_legend}", $GLOBALS['TL_DCA']['tl_article']['palettes']['default']);
$GLOBALS['TL_DCA']['tl_article']['subpalettes']['addNavigation'] = 'navigation_title,navigation_jumpTo';

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_article']['fields']['addNavigation'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_article']['addNavigation'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
    'eval'                    => array
    (
        'submitOnChange'    => true, 
        'doNotCopy'         => true
    ),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['navigation_title'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['navigation_title'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'search'                  => true,
    'eval'                    => array
    (
        'mandatory'         => false,
        'decodeEntities'    => true,
        'maxlength'         => 255,
        'tl_class'          => 'w50'
    ),
	'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['navigation_jumpTo'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['navigation_jumpTo'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'search'                  => true,
    'eval'                    => array
    (
        'maxlength'         => 255,
        'tl_class'          => 'w50',
        'rgxp'              => 'alias'
    ),
	'sql'                     => "varchar(255) NOT NULL default ''"
);