<?php

declare(strict_types=1);

namespace Dotclear\Plugin\RestrictedReading;

use Dotclear\App;
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
     * Gets the post's content.
     *
     * This overload Dotclear\Schema\Extension\PostPublic::getContent()
     *
     * @param      MetaRecord   $rs             Invisible parameter
     * @param      bool|int     $absolute_urls  Use absolute urls
     */
    public static function getContent(MetaRecord $rs, $absolute_urls = false): string
    {
        return ((int) $rs->f('post_status')) == My::POST_STATUS ? My::settings()->get('post_content') : PostPublic::getContent($rs, $absolute_urls);
    }
}
