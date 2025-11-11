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

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\StringUtil;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsHook('replaceInsertTags')]
readonly class InsertTagsListener
{
    public function __construct(
        private RequestStack $requestStack,
    ) {
    }

    public function __invoke(string $insertTag): string|false
    {
        $parts = StringUtil::trimsplit('::', $insertTag);

        if (!str_starts_with($parts[0], 'scroll')) {
            return false;
        }

        if (3 !== count($parts)) {
            return false;
        }

        if (str_starts_with($parts[1], '#')) {
            $parts[1] = substr($parts[1], 1);
        }

        $request = $this->requestStack->getCurrentRequest();

        return sprintf(
            '<a href="%s#%s" data-scroll="%s" title="%s">%s</a>',
            $request->getUri(),
            $parts[1],
            $parts[1],
            $parts[2],
            $parts[2]
        );
    }
}

