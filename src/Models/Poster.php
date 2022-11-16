<?php

namespace Zzexts\Poster\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Intervention\Image\Gd\Font;

class Poster extends Model
{
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        $this->setConnection(config('zzexts-poster.database.connection') ?: config('database.default'));

        $this->setTable(config('zzexts-poster.database.poster_table', 'posters'));
    }


    public function getPathInfoAttribute()
    {
        $path_info = json_decode($this->path);
        $path_info->bg = $this->logo_src;
        return $path_info;
    }
}
