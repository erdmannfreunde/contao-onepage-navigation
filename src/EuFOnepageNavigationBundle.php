<?php

declare(strict_types=1);

/*
 * Contao Onepage Navigation for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2024, Erdmann & Freunde
 * @author     Erdmann & Freunde <https://erdmann-freunde.de>
 * @license    MIT
 * @link       https://github.com/erdmannfreunde/contao-onepage-navigation
 */

namespace EuF\OnepageNavigation;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EuFOnepageNavigationBundle extends Bundle
{
    public function getPath(): string
    {
        return dirname(__DIR__);
    }
}
