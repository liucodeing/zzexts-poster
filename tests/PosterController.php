<?php

namespace Zzexts\Poster\Tests;

use Illuminate\Routing\Controller;
use Zzexts\Poster\Repositories\PosterRepository;

class TestPosterController extends Controller
{
    /**
     * 获取一个，第一个，应该使用的
     * @return array
     */
    public function get()
    {
        $data = PosterRepository::get();
        return compact('data');
    }

    /**
     * 给全部可用的列表
     * @return array
     */
    public function all()
    {
        $data = PosterRepository::all();
        return compact('data');
    }

}
