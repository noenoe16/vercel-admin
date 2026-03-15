# Filament Collapsible Sidebar

A Filament plugin that adds a collapsible sidebar with icon-only view when collapsed.

## Features

- 🎯 Easy toggle button
- 🎨 Icon-only view when collapsed
- 💾 State persistence (localStorage)
- 🌙 Dark mode support
- ⚡ Smooth animations
- 📱 Desktop only (hidden on mobile)

## Requirements

- PHP 8.2+
- Filament 4.0+

## Installation

Install via Composer:
```bash
composer require slym758/filament-collapsible-sidebar
```

## Usage

Add the plugin to your panel provider:
```php
use Slym758\CollapsibleSidebar\CollapsibleSidebarPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            CollapsibleSidebarPlugin::make(),
        ]);
}
```

That's it! A toggle button will appear in your sidebar.

## Screenshots

*Add screenshots here*

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Credits

- [Süleyman](https://github.com/slym758)
