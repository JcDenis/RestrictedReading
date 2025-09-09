<?php

declare(strict_types=1);

namespace Dotclear\Plugin\RestrictedReading;

use Dotclear\App;
use Dotclear\Helper\Process\TraitProcess;
use Exception;

/**
 * @brief       RestrictedReading module install class.
 * @ingroup     RestrictedReading
 *
 * @author      Jean-Christian Paul Denis
 * @copyright   AGPL-3.0
 */
class Install
{
    use TraitProcess;

    public static function init(): bool
    {
        return self::status(My::checkContext(My::INSTALL));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        try {
            My::settings()->put('signup_perm', true, 'boolean', 'Add user permission to retricted reading on sign up', false, true);
            My::settings()->put('post_trunk', false, 'boolean', 'Show posts excerpts instead of hiding them', false, true);
            My::settings()->put('post_content', "This article is reserved to registered user. You must be logged in to your account.", 'text', 'Text to display instead of post content', false, true);

            return true;
        } catch (Exception $e) {
            App::error()->add($e->getMessage());

            return false;
        }
    }
}
