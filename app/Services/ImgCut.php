<?php
/**
 * Created by PhpStorm.
 * User: Hermit
 * Date: 2016/11/4
 * Time: 16:13
 */

namespace App\Services;


class ImgCut
{
    function cut($source_path, $x, $y, $w, $h, $real_width, $real_height)
    {
        $source_info = getimagesize($source_path);

        $src_width = $source_info[0];
        $src_height = $source_info[1];
        $src_mime = $source_info['mime'];

        $w_scale = $src_width / $real_width;
        $h_scale = $src_height / $real_height;

        $x1 = $x * $w_scale;
        $y1 = $y * $h_scale;
        $w1 = $w * $w_scale;
        $h1 = $h * $h_scale;

        switch($src_mime){
            case 'image/gif':
                $source_image = imagecreatefromgif($source_path);
                break;
            case 'image/jpeg':
                $source_image = imagecreatefromgif($source_path);
                break;
            case 'image/png':
                $source_image = imagecreatefromgif($source_path);
                break;
            default:
                return false;
        }

        $target_img = imagecreatetruecolor($src_width, $src_height);

        imagecopy($target_img, $source_image, 0, 0, $x1, $y1, $w, $h);

        header('Content-Type: image/jpeg');

        imagejpeg($target_img);

        Storage::disk('public')->put(
            $source_path,
            $target_img
        );
    }

}