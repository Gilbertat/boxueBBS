<?php

namespace App\Handlers;

use Image;

class ImageUploadHandler
{
    // 允许上传的图片格式
    protected $allowed_ext = ["png", "jpg", "gif", "jpeg"];

    public function save($file, $folder, $file_prefix, $max_width=false)
    {
        // 文件夹存储规则
        $folder_name = "uploads/images/$folder/" . date("Ym", time()) . '/' . date("d", time()) . '/';

        // 文件存储路径
        $upload_path = public_path() . '/' . $folder_name;

        // 获取文件扩展名
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        // 拼接文件名
        $filename = $file_prefix . '_' . time() . '_' . str_random(10) . '.' . $extension;

        // 上传图片不符合规则，终止操作
        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }

        // 移动图片到存储路径
        $file->move($upload_path, $filename);

        if ($max_width && $extension != 'gif') {
            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }

        return [
            'path' => config('app.url') . "/$folder_name/$filename"
        ];
    }

    public function reduceSize($file_path, $max_width)
    {
        $image = Image::make($file_path);

        $image->resize($max_width, null, function ($constraint) {

            $constraint->aspectRatio();

            $constraint->upsize();
        });

        $image->save();
    }
}