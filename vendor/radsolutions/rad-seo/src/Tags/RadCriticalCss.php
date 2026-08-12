<?php

namespace RadSolutions\RadSeo\Tags;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Statamic\Tags\Tags;

class RadCriticalCss extends Tags
{
    /**
     * The {{ rad_critical_css }} tag.
     */
    public function index()
    {
        $template = $this->context->value('current_template');
        $template = Str::slug((string) $template);

        $cssFile = resource_path("css/{$template}_critical.min.css");

        if (File::exists($cssFile)) {
            return '<style>' . File::get($cssFile) . '</style>';
        }

        return '';
    }
}
