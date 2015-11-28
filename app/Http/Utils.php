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

    public static function upload_image($requestImage, $uploadName)
    {
        $saveFileName = Utils::get_valid_upload_name($uploadName, 'jpg');
        Image::make($requestImage)
            ->encode('jpg')
            ->heighten(405, function ($constraint) { $constraint->upsize();})
            ->save(Game::$backupImageUploadPath.$saveFileName, 75);
//        $s3->putObject(array(
//            'ACL'        => 'public-read',
//            'Bucket'     => 'topicloop-upload2',
//            'CacheControl' => 'max-age=1814400',
//            'Key'        => Post::getImageUploadPath().$imageUploadedName,
//            'SourceFile' => Post::getBackupImageUploadPath().$imageUploadedName,
//        ));
    }

    private static function get_valid_upload_name($requested_name, $extension)
    {
        return $requested_name.$extension;
    }

}
