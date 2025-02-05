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

namespace EuF\OnepageNavigation\EventListener;

use Contao\ArticleModel;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\StringUtil;

#[AsHook('getArticle')]
class GetArticleListener
{
    public function __invoke(ArticleModel $article): void
    {
        if (true === (bool) $article->addNavigation) {
            $cssId = StringUtil::deserialize($article->cssID, true);

            if ($anchor = $article->navigation_jumpTo) {
                $cssId[0] = $anchor;
            }

            $cssId[1] .= ' onepage_article';

            $article->cssID = serialize($cssId);
        }
    }
}
