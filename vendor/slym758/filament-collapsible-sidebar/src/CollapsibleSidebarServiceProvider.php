<?php

namespace Slym758\CollapsibleSidebar;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Panel;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CollapsibleSidebarServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('collapsible-sidebar');
    }

    public function packageBooted(): void
    {
        FilamentAsset::register([
            Css::make('collapsible-sidebar-styles', __DIR__.'/../resources/css/collapsible-sidebar.css'),
            Js::make('collapsible-sidebar-scripts', __DIR__.'/../resources/js/collapsible-sidebar.js'),
        ], package: 'slym758/filament-collapsible-sidebar');

        // Config'i JS'e aktar
        FilamentAsset::registerScriptData([
            'collapsibleSidebar' => [
                'rememberState' => true,
                'defaultCollapsed' => false,
            ],
        ], 'slym758/filament-collapsible-sidebar');
    }
}
