<?php

declare(strict_types=1);

namespace Dotclear\Plugin\RestrictedReading;

use Dotclear\App;
use Dotclear\Helper\Process\TraitProcess;
use Dotclear\Helper\Stack\Status;

/**
 * @brief       RestrictedReading module prepend process.
 * @ingroup     RestrictedReading
 *
 * @author      Jean-Christian Denis (latest)
 * @copyright   GPL-3.0
 */
class Prepend
{
    use TraitProcess;

    public static function init(): bool
    {
        __('Restricted reading', 'Restricted reading (>1)');

        return self::status(My::checkContext(My::PREPEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        // Add "Restricted reading" user permission
        App::auth()->setPermissionType(My::id(), My::name());

        // Add post status
        $status = App::status()->post()->set(new Status(
            My::POST_STATUS ,
            My::id(),
            'Restricted reading',
            'Restricted reading (>1)',
            My::fileURL('icon.svg'))
        );

        return $status;
    }
}
