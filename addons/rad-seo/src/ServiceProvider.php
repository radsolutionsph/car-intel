<?php

namespace RadSolutions\RadSeo;

use RadSolutions\RadSeo\Tags\RadCriticalCss;
use RadSolutions\RadSeo\Tags\RadStructured;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $viewNamespace = 'rad-seo';

    protected $tags = [
        RadCriticalCss::class,
        RadStructured::class,
    ];

    public function bootAddon()
    {
        $existing = (array) config('statamic.system.view_config_allowlist', ['@default']);
        $packageKeys = [
            'rad-seo.force-critical',
            'rad-seo.opengraph-image',
        ];

        config()->set(
            'statamic.system.view_config_allowlist',
            array_values(array_unique([...$existing, ...$packageKeys]))
        );
    }
}
