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
    '0.5',
    [
        'requires'    => [
            ['core', '2.34'],
            ['FrontendSession', '0.28'],
        ],
        'settings'    => ['blog' => '#params.' . $this->id . '_params'],
        'permissions' => 'My',
        'type'        => 'plugin',
        'support'     => 'https://github.com/JcDenis/' . $this->id . '/issues',
        'details'     => 'https://github.com/JcDenis/' . $this->id . '/',
        'repository'  => 'https://raw.githubusercontent.com/JcDenis/' . $this->id . '/master/dcstore.xml',
        'date'        => '2025-06-25T23:10:01+00:00',
    ]
);
