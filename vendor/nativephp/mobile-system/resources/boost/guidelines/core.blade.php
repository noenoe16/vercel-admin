## nativephp/system

System-level operations for NativePHP Mobile apps.

### PHP Usage (Livewire/Blade)

@verbatim
<code-snippet name="System Operations" lang="php">
use Native\Mobile\Facades\System;

// Open app settings
System::openAppSettings();
</code-snippet>
@endverbatim

### JavaScript Usage (Vue/React/Inertia)

@verbatim
<code-snippet name="System Operations in JavaScript" lang="javascript">
import { system } from '#nativephp';

// Open app settings
await system.openAppSettings();
</code-snippet>
@endverbatim

### Methods

- `System::openAppSettings()` - Opens app's settings screen in device settings

### Use Cases

Direct users to grant permissions after initial denial, allow users to change notification preferences, enable users to manage app-specific settings.