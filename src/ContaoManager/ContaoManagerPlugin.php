<?php

/*
 * Contao Onepage Navigation for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2025, Erdmann & Freunde
 * @author     Erdmann & Freunde <https://erdmann-freunde.de>
 * @license    MIT
 * @link       https://github.com/erdmannfreunde/contao-onepage-navigation
 */

namespace EuF\OnepageNavigation\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
// load dependencies
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use EuF\OnepageNavigation\EuFOnepageNavigationBundle;

class ContaoManagerPlugin implements BundlePluginInterface
{
    /**
     * Register Bundle in application.
     *
     * @return array
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(EuFOnepageNavigationBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
