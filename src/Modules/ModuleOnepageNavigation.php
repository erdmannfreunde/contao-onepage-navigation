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

namespace EuF\OnepageNavigation\Modules;
use Contao\BackendTemplate;
use Contao\Module;
use Contao\System;
use Contao\PageModel;
use Contao\ArticleModel;
use Contao\StringUtil;

class ModuleOnepageNavigation extends Module
{
    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'mod_onepage_navigation';

    /**
     * Display a wildcard in the back end.
     *
     * @return string
     */
    public function generate()
    {
        $request = System::getContainer()->get('request_stack')->getCurrentRequest();

        if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request))
        {
            /** @var BackendTemplate|object $objTemplate */
            $objTemplate = new BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### '. $GLOBALS['TL_LANG']['FMD']['onepage_navigation'][0] .' ###';
            $objTemplate->title    = $this->headline;
            $objTemplate->id       = $this->id;
            $objTemplate->link     = $this->name;
            $objTemplate->href     = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id='.$this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }

    /**
     * Generate the module.
     */
    protected function compile()
    {
        // initialize empty array
        $arrNavigation = [];

        // get current page id
        $intPageID = $GLOBALS['objPage']->id;

        // override page ID if a rootPage is defined
        if ($this->defineRoot)
        {
            $PageID    = PageModel::findById($this->rootPage);
            $PageAlias = $PageID->getFrontendUrl('');
            $intPageID = $PageID->id;
        }
        else
        {
            $PageID    = PageModel::findById($intPageID);
            $PageAlias = $PageID->getFrontendUrl('');
        }

        // get articles by page id
        $objArticle = ArticleModel::findByPid($intPageID, ['order' => 'sorting']);

        if (null !== $objArticle)
        {
            // put articles into array if they should be displayed as navigation items
            while ($objArticle->next())
            {
                if ($objArticle->addNavigation && $objArticle->published)
                {
                    if ($objArticle->navigation_title)
                    {
                        $objArticle->title = $objArticle->navigation_title;
                    }

                    // get jumpTo target and add to article so it can be rendered in template
                    $cssID = StringUtil::deserialize($objArticle->cssID);

                    if (empty($cssID[0]))
                    {
                        if ($objArticle->navigation_jumpTo)
                        {
                            $cssID = [$objArticle->navigation_jumpTo, $cssID[1]];
                        }
                        else
                        {
                            $cssID = ['article-'.$objArticle->id, $cssID[1]];
                            $objArticle->navigation_jumpTo = 'article-'.$objArticle->id;
                        }
                    }
                    $objArticle->cssID        = serialize($cssID);
                    $objArticle->onepage_jump = $PageAlias.'#'.$cssID[0];

                    $arrNavigation[] = (object) $objArticle->row();
                }
            }
        }

        if ($arrNavigation)
        {
            // add first and last class to items
            $arrNavigation[0]->css                          = 'first';
            $arrNavigation[\count($arrNavigation) - 1]->css = 'last';

            // send to template
            $this->Template->hasItems   = true;
            $this->Template->navigation = $arrNavigation;
        }
    }
}
