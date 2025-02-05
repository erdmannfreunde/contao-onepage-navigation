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

use EuF\OnepageNavigation\Controller\FrontendModule\OnepageNavigationController;

/*
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_module']['palettes'][OnepageNavigationController::TYPE] = '{title_legend},name,headline,type;{reference_legend:hide},defineRoot;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;';
