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

/*
 * Frontend-Modules
 **/
Contao\ArrayUtil::arrayInsert($GLOBALS['FE_MOD']['navigationMenu'], \count($GLOBALS['FE_MOD']['navigationMenu']), [
    'onepage_navigation'     => 'EuF\OnepageNavigation\Modules\ModuleOnepageNavigation',
]);

/*
 * Hooks
 */
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = ['EuF\OnepageNavigation\Hooks\OnepageHooks', 'replaceScrollTag'];
$GLOBALS['TL_HOOKS']['getArticle'][]        = ['EuF\OnepageNavigation\Hooks\OnepageHooks', 'onGetArticle'];
