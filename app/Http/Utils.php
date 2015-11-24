<?php

namespace App\Http;


class Utils
{
    public static function get_image_url($fileName)
    {
        return '/images/'.$fileName;
    }

    public static function preg_grep_keys($pattern, $input, $flags = 0)
    {
        return array_intersect_key($input, array_flip(preg_grep($pattern, array_keys($input), $flags)));
    }



}
