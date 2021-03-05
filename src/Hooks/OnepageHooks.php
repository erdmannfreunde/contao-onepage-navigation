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

namespace EuF\OnepageNavigation\Hooks;

use Contao\Controller;
use Contao\StringUtil;

class OnepageHooks extends Controller
{
    public function onGetArticle($row): void
    {
        if ($row->addNavigation)
        {
            $cssId      = StringUtil::deserialize($row->cssID, true);
            $cssId[1] .= ' onepage_article';
            $row->cssID = serialize($cssId);
            $anchor     = $row->navigation_jumpTo;
        }

        if ($row->navigation_jumpTo)
        {
            $cssId[0] = $row->navigation_jumpTo;
        }
    }

    public function replaceScrollTag($strTag)
    {
        $value      = false;
        $arrExplode = explode('::', $strTag);

        if ('scroll' === $arrExplode[0] && 3 === \count($arrExplode))
        {
            if ('#' === substr($arrExplode[1], 0, 1))
            {
                $arrExplode[1] = substr($arrExplode[1], 1);
            }

            $value = '<a href="'.\Environment::get('requestUri').'#'.$arrExplode[1].'" data-scroll="'.$arrExplode[1].'" title="'.$arrExplode[2].'">'.$arrExplode[2].'</a>';
        }

        return $value;
    }
}
