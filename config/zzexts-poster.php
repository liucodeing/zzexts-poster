<?php

// zzexts/poster config

return [
    'database' => [
        'connection' => '',
        'poster_table' => 'posters',// 数据库名称
    ],
    'qrcode_example_url' => 'https://xxxxxxxxx.oss-cn-beijing.aliyuncs.com/xxxxx/lYRGZAlbHD47QnWw0vqgaIpDLvwc4q6iBLmSK1iV.png',// 二维码占位图
    'filesystem_driver' => 'public', // 使用的图片存储位置
    'upload_file_max_size' => 5242880,// 按照字节数量设置，默认5m
];
