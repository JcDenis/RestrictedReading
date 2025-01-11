<?php
/**
 * @file
 * @brief       The plugin RestrictedReading definition
 * @ingroup     RestrictedReading
 *
 * @defgroup    RestrictedReading Plugin RestrictedReading.
 *
 * Add status for your posts.
 *
 * @author      Jean-Christian Denis (latest)
 * @copyright   GPL-3.0
 */
declare(strict_types=1);

$this->registerModule(
    'Restricted reading',
    'Show some entries to registred users only',
    'Jean-Christian Denis and Contributors',
    '0.0.1',
    [
        'requires'    => [['core', '2.33']],
        'permissions' => 'My',
        'type'        => 'plugin',
        'support'     => 'https://git.dotclear.watch/JcDenis/' . $this->id . '/issues',
        'details'     => 'https://git.dotclear.watch/JcDenis/' . $this->id . '/src/branch/master/README.md',
        'repository'  => 'https://git.dotclear.watch/JcDenis/' . $this->id . '/raw/branch/master/dcstore.xml',
    ]
);
