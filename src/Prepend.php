<?php

declare(strict_types=1);

namespace Dotclear\Plugin\RestrictedReading;

use ArrayObject;
use Dotclear\App;
use Dotclear\Core\PostType;
use Dotclear\Core\Process;
use Dotclear\Helper\Stack\Status;

/**
 * @brief       The module prepend process.
 * @ingroup     RestrictedReading
 *
 * @author      Jean-Christian Denis (latest)
 * @copyright   GPL-3.0
 */
class Prepend extends Process
{
    public static function init(): bool
    {
        return self::status(My::checkContext(My::PREPEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        // Add "Posts subscriber" user permission
        App::auth()->setPermissionType(My::USER_PERMISSION, __('Restricted reading'));

        // Add post status
        if (App::status()->post()->set(
            (new Status(My::POST_STATUS , My::id(), 'Restricted reading', 'Restricted reading (>1)', My::fileURL('icon.svg'))),
        )) {
            App::behavior()->addBehaviors([
                'coreBlogBeforeGetPostsAddingParameters' => self::coreBlogBeforeGetPostsAddingParameters(...),
            ]);

            return true;
        }

        return false;
    }

    /**
     * Add signin post status.
     * 
     * This adds post marked with status _Restricted reading_ 
     * to Frontend if user is loggued and has _Restricted reading_ right.
     *
     * @param   ArrayObject<string, mixed>     $params     Parameters
     */
    public static function coreBlogBeforeGetPostsAddingParameters(ArrayObject $params, string|null $arg = null): void
    {
        if (App::task()->checkContext('FRONTEND') && App::auth()->check(My::USER_PERMISSION, App::blog()->id()) === true) {
            if (!isset($params['post_status'])) {
                $params['post_status'] = [];
            }
            if (!is_array($params['post_status'])) {
                $params['post_status'] = [$params['post_status']];
            }

            //$params['post_status'][] = App::status()->post()::PUBLISHED;
            $params['post_status'][] = My::POST_STATUS;
        }
    }
}
