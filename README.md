zzexts/poster
======
一个可以直接修改的海报图。需要前端配合进行

require laravel,laravel-admin

## 安装

```shell
$ composer require zzexts/poster
```

#### 发布静态文件到public目录
同时生成配置文件`config/zzexts-poster.php`
```shell
$ php artisan vendor:publish --provider=Zzexts\\Poster\\PosterServiceProvider
```

可修改配置文件 `config/zzexts-poster.php`

```phpt
    'database' => [
        'connection' => '',
        'poster_table' => 'posters',//数据库名称
    ],
    'qrcode_example_url' => 'https://xxxxxxxxx.oss-cn-beijing.aliyuncs.com/xxxxx/lYRGZAlbHD47QnWw0vqgaIpDLvwc4q6iBLmSK1iV.png',// 二维码占位图
    'filesystem_driver' => 'public', // 使用的图片存储位置
```

#### 迁入数据库

```shell
$ php artisan admin:poster-install
```

#### 完成！

浏览器访问 `http://your-host/admin/poster`

## 有需要

#### 导入laravel-admin菜单

```shell
$ php artisan admin:import poster
```

