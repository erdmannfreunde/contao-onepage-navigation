<?php

/**
 * @package     Onepage Navigation
 * @author      Sascha Brandhoff (https://github.com/Sascha-Brandhoff/onepage-navigation)
 * @author      Basti Buck (http://www.bastibuck.de)
 * @license     LGPLv3
 * @copyright   Erdmann & Freunde (https://erdmann-freunde.de)
 */

namespace EuF\OnepageNavigation\ContaoManager;

use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

// load dependencies
use Contao\CoreBundle\ContaoCoreBundle;
use EuF\OnepageNavigation\EuFOnepageNavigationBundle;

class ContaoManagerPlugin implements BundlePluginInterface
{
    /**
     * Register Bundle in application
     *
     * @param ParserInterface $parser
     * @return ConfigInterface[]
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(EuFOnepageNavigationBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class])
        ];
    }
}


