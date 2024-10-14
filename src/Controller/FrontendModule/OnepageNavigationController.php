<?php

/*
 * Contao Onepage Navigation for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2024, Erdmann & Freunde
 * @author     Erdmann & Freunde <https://erdmann-freunde.de>
 * @license    MIT
 * @link       https://github.com/erdmannfreunde/contao-onepage-navigation
 */

namespace EuF\OnepageNavigation\Controller\FrontendModule;

use Contao\ArticleModel;
use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\CoreBundle\Routing\ContentUrlGenerator;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\ModuleModel;
use Contao\PageModel;
use Contao\StringUtil;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsFrontendModule(category: 'navigationMenu')]
class OnepageNavigationController extends AbstractFrontendModuleController
{
    public const string TYPE = 'onepage_navigation';

    public function __construct(
        private readonly ContentUrlGenerator $contentUrlGenerator,
    ) {
    }

    protected function getResponse(FragmentTemplate $template, ModuleModel $model, Request $request): Response
    {
        // initialize empty array
        $arrNavigation = [];

        // get current page id
        $pageId = $this->getPageModel()->id;

        // override page ID if a rootPage is defined
        if ($model->defineRoot) {
            $objPage = PageModel::findById($model->rootPage);
            $pageAlias = $this->contentUrlGenerator->generate($objPage);
            $pageId = $objPage->id;
        } else {
            $objPage = $this->getPageModel();

            if ('error_404' === $objPage->type) {
                $pageAlias = $objPage->alias;
            } else {
                $pageAlias = $this->contentUrlGenerator->generate($objPage);
            }
        }

        // get articles by page id
        $objArticle = ArticleModel::findByPid($pageId, ['order' => 'sorting']);

        if (null !== $objArticle) {
            while ($objArticle->next()) {
                if ($objArticle->addNavigation && $objArticle->published) {
                    if ($objArticle->navigation_title) {
                        $objArticle->title = $objArticle->navigation_title;
                    }

                    // get jumpTo target and add to article so it can be rendered in template
                    $cssID = StringUtil::deserialize($objArticle->cssID);

                    if (empty($cssID[0])) {
                        if ($objArticle->navigation_jumpTo) {
                            $cssID = [$objArticle->navigation_jumpTo, $cssID[1]];
                        } else {
                            $cssID = ['article-'.$objArticle->id, $cssID[1]];
                            $objArticle->navigation_jumpTo = 'article-'.$objArticle->id;
                        }
                    }

                    $objArticle->cssID = serialize($cssID);
                    $objArticle->onepage_jump = $pageAlias.'#'.$cssID[0];

                    $arrNavigation[] = $objArticle->current();
                }
            }
        }

        if (!empty($arrNavigation)) {
            // add first and last class to items
            $arrNavigation[0]->css = 'first';

            $arrNavigation[count($arrNavigation) - 1]->css = 'last';
        }

        $template->set('hasItems', !empty($arrNavigation));
        $template->set('navigation', $arrNavigation);

        return $template->getResponse();
    }
}
