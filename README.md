zzexts/poster
======
一个可以直接修改的海报图。需要前端配合进行

require laravel,laravel-admin

## 安装

```shell
$ composer require zzexts/poster
```

#### 发布静态文件到public目录
后台提供编辑海报的前端源码进行发布，
同时生成配置文件`config/zzexts-poster.php`

```shell
$ php artisan vendor:publish --provider=Zzexts\\Poster\\PosterServiceProvider
```

可修改配置文件 `config/zzexts-poster.php`。需要配置二维码展位图地址。图片位置默认使用的是本次存储，可按照自己的需要修改。

```phpt
    'database' => [
        'connection' => '',
        'poster_table' => 'posters',//数据库名称
    ],
    'qrcode_example_url' => 'https://xxxxxxxxx.oss-cn-beijing.aliyuncs.com/xxxxx/lYRGZAlbHD47QnWw0vqgaIpDLvwc4q6iBLmSK1iV.png',// 二维码占位图
    'filesystem_driver' => 'public', //使用的图片存储位置
    'upload_file_max_size' => 5242880,// 按照字节数量设置，默认5m
```

#### 迁入数据库
数据库增加表 `posters`
```shell
$ php artisan admin:poster-install
```

#### 安装完成！

## 使用

文件存储配置 `config/filesystems.php`。 可以使用public配置。使用七牛，oss需按照laravel文件存储配置。

```phpt
....
'public' => [
    'driver' => 'local',
    'root' => storage_path('app/public'),
    'url' => env('APP_URL').'/storage',
    'visibility' => 'public',
],
....
```

浏览器访问 `http://your-host/admin/poster`

## 有需要可以导入菜单，或者手动增加

#### 导入laravel-admin菜单

```shell
$ php artisan admin:import poster
```

