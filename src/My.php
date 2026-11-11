<?php

declare(strict_types=1);

namespace Dotclear\Plugin\RestrictedReading;

use Dotclear\App;
use Dotclear\Module\MyPlugin;

/**
 * @brief       RestrictedReading module helper.
 * @ingroup     RestrictedReading
 *
 * @author      Jean-Christian Denis (latest)
 * @copyright   GPL-3.0
 */
class My extends MyPlugin
{
    public const POST_STATUS = -150;

    /**
     * Get the URL of a status icon.
     *
     * A status is declared on every page load, but backend URLs do not exist
     * in some backend contexts (installation, upgrade, command line): no icon there.
     *
     * @param   string  $resource   The icon path in module
     */
    public static function statusIcon(string $resource): string
    {
        if (App::task()->checkContext('BACKEND') && !App::backend()->url()->dumpUrls()->offsetExists('load.plugin.file')) {
            return '';
        }

        return self::fileURL($resource);
    }
}
