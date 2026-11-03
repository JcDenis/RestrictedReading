<?php

declare(strict_types=1);

namespace Dotclear\Plugin\RestrictedReading;

use Dotclear\Database\MetaRecord;
use Dotclear\Schema\Extension\PostPublic;

/**
 * @brief       RestrictedReading module posts record extension.
 * @ingroup     RestrictedReading
 *
 * @author      Dotclear team
 * @copyright   AGPL-3.0
 */
class RecordExtendPost
{
    /**
     * Posts record extensions set before this one.
     *
     * @var     array<string, mixed>    $brother_extensions
     */
    public static array $brother_extensions = [];

    /**
     * Gets the post's content.
     *
     * This overload Dotclear\Schema\Extension\PostPublic::getContent()
     * and other plugins getContent() extensions.
     *
     * @param      MetaRecord   $rs             Invisible parameter
     * @param      bool|int     $absolute_urls  Use absolute urls
     */
    public static function getContent(MetaRecord $rs, $absolute_urls = false): string
    {
        if ($rs->intField('post_status') === My::POST_STATUS) {
            return (string) My::settings()->getStr('post_content');
        }

        // Call previous getContent() extension
        $ext  = static::$brother_extensions;
        $func = isset($ext['getContent']) && is_callable($ext['getContent']) ? $ext['getContent'] : PostPublic::getContent(...);

        $res = call_user_func($func, $rs, $absolute_urls);

        return is_string($res) ? $res : '';
    }
}
