<?php

namespace Zzexts\Poster\Repositories;

use Illuminate\Support\Facades\Validator;
use Zzexts\Poster\Models\Poster as Model;

class PosterRepository
{
    public static function validate($request)
    {
        return Validator::make($request,
            [
                //'ad_scene_id' => 'required',
                'template_id' => 'required',
                'name' => 'required',
                'sort' => 'numeric|required',
            ], [
                'template_id.required' => '请选择模板',
                'name.required' => '请输入图片名称',
                'sort.numeric' => '请输入正确的排序值',
                'sort.required' => '请填写排序值',
            ]
        );
    }

    static function get()
    {

    }

    static function first()
    {

    }
}
