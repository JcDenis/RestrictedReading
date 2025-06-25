<?php

declare(strict_types=1);

namespace Dotclear\Plugin\RestrictedReading;

use ArrayObject;
use Dotclear\App;
use Dotclear\Core\Process;
use Dotclear\Helper\Html\Form\{ Checkbox, Div, Fieldset, Img, Label, Legend, Para, Textarea };
use Dotclear\Helper\Html\Html;
use Dotclear\Interface\Core\BlogSettingsInterface;


/**
 * @brief       RestrictedReading module backend process.
 * @ingroup     RestrictedReading
 *
 * @author      Jean-Christian Paul Denis
 * @copyright   AGPL-3.0
 */
class Backend extends Process
{
    public static function init(): bool
    {
        return self::status(My::checkContext(My::BACKEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        // behaviors
        App::behavior()->addBehaviors([
            'adminBlogPreferencesHeaders' => fn (): string => My::jsLoad('backend'),
            'adminPostEditorTags'         => function (string $editor, string $context, ArrayObject $alt_tags, string $format): void {
                if ($context === 'blog_desc') {
                    $alt_tags->append('#' . My::id() . 'post_content');
                }
            },
            'adminBlogPreferencesFormV2'  => function (BlogSettingsInterface $blog_settings): void {
                echo (new Fieldset(My::id() . '_params'))
                    ->legend(new Legend((new Img(My::icons()[0]))->class('icon-small')->render() . ' ' . My::name()))
                    ->items([
                        (new Para())
                            ->items([
                                (new Checkbox(My::id() . 'signup_perm', (bool) $blog_settings->get(My::id())->get('signup_perm')))
                                    ->value(1)
                                    ->label(new Label(__('Add user permission for restricted reading on sign up'), Label::IL_FT)),
                            ]),
                        (new Para())
                            ->items([
                                (new Checkbox(My::id() . 'post_trunk', (bool) $blog_settings->get(My::id())->get('post_trunk')))
                                    ->value(1)
                                    ->label(new Label(__('Show excerpt instead of hiding entire post'), Label::IL_FT)),
                            ]),
                        (new Para())
                            ->items([
                                (new Textarea(My::id() . 'post_content', Html::escapeHTML((string) ($blog_settings->get(My::id())->get('post_content')))))
                                    ->rows(6)
                                    ->class('maximal')
                                    ->label((new Label(__('Text to display instead of post content:'), Label::OL_TF))),
                            ]),
                    ])
                    ->render();
            },
            'adminBeforeBlogSettingsUpdate' => function (BlogSettingsInterface $blog_settings): void {
                $blog_settings->get(My::id())->put('signup_perm', !empty($_POST[My::id() . 'signup_perm']));
                $blog_settings->get(My::id())->put('post_trunk', !empty($_POST[My::id() . 'post_trunk']));
                $blog_settings->get(My::id())->put('post_content', (string) $_POST[My::id() . 'post_content']);
            },
        ]);

        return true;
    }
}
