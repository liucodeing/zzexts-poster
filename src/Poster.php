<?php

namespace Zzexts\Poster;

use Encore\Admin\Extension;

class Poster extends Extension
{
    public $name = 'poster';

    public $views = __DIR__.'/../resources/views';

    public $assets = __DIR__.'/../resources/assets';

    public $menu = [
        'title' => 'Poster',
        'path'  => 'poster',
        'icon'  => 'fa-gears',
    ];

    /**
     * {@inheritdoc}
     */
    public static function import()
    {
        parent::createMenu('海报', 'poster', 'fa-adjust');

        parent::createPermission('海报', 'zzext.poster', 'poster*');
    }
}
