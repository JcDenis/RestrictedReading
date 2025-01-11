<?php

declare(strict_types=1);

namespace Dotclear\Plugin\RestrictedReading;

use Dotclear\App;
use Dotclear\Module\MyPlugin;

/**
 * @brief       The module helper.
 * @ingroup     RestrictedReading
 *
 * @author      Jean-Christian Denis (latest)
 * @copyright   GPL-3.0
 */
class My extends MyPlugin
{
    public const USER_PERMISSION = 'RestrictedReading';
    public const POST_STATUS     = -150;
}
