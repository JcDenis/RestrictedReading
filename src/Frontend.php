<?php

declare(strict_types=1);

namespace Dotclear\Plugin\RestrictedReading;

use ArrayObject;
use Dotclear\App;
use Dotclear\Helper\Process\TraitProcess;
use Dotclear\Database\{ Cursor, MetaRecord };
use Dotclear\Helper\Html\Form\Text;
use Dotclear\Plugin\FrontendSession\FrontendSessionProfil;

/**
 * @brief       RestrictedReading module frontend process.
 * @ingroup     RestrictedReading
 *
 * @author      Jean-Christian Paul Denis
 * @copyright   AGPL-3.0
 */
class Frontend
{
    use TraitProcess;

    public static function init(): bool
    {
        return self::status(My::checkContext(My::FRONTEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        App::behavior()->addBehaviors([
            'coreBlogBeforeGetPostsAddingParameters' => function (ArrayObject $params, string|null $arg = null): void {
                if (My::settings()->get('post_trunk') || App::auth()->check(My::id(), App::blog()->id()) === true) {
                    if (!isset($params['post_status'])) {
                        $params['post_status'] = [];
                    }
                    if (!is_array($params['post_status'])) {
                        $params['post_status'] = [$params['post_status']];
                    }

                    $params['post_status'][] = My::POST_STATUS;
                }
            },
            'coreBlogGetPosts' => function (MetaRecord $rs): void {
                if (My::settings()->get('post_trunk') && App::auth()->check(My::id(), App::blog()->id()) !== true) {
                    $rs->extend(RecordExtendPost::class);
                }
            },
            'FrontendSessionProfil' => function (FrontendSessionProfil $profil): void {
                if (App::auth()->check(My::id(), App::blog()->id())) {
                    $profil->addAction(My::id(), My::name(), [
                        (new Text('p', __('You have access to restricted reading.'))),
                    ]);
                }
            },
            'FrontendSessionAfterSignup' => function (Cursor $cur): void {
                if (My::settings()->get('signup_perm')) {
                    $perms = App::users()->getUserPermissions($cur->user_id);
                    $perms = $perms[App::blog()->id()]['p'] ?? [];
                    $perms[My::id()]  = true;
                    App::auth()->sudo([App::users(), 'setUserBlogPermissions'], $cur->user_id, App::blog()->id(), $perms);
                }
            },
        ]);

        return true;
    }
}
