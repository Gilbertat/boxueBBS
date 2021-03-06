<?php

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}

function model_admin_link($title, $model)
{
    return model_link($title, $model, 'admin');
}

function model_link($title, $model, $prefix='')
{
    // 获取数据模型的复数蛇形命名
    $model_name = model_plural_name($model);

    // 初始化前缀
    $prefix = $prefix ? "/$prefix/" : '/';

    // 使用站点名拼接URL
    $url = config('app.url') . $prefix . $model_name . '/' . $model->id;

    // 拼接HTML A 标签 并返回
    return '<a href="' . $url . '"target="_blank">' . $title . '</a>';
}

function model_plural_name($model)
{
    // 从实体中获取完成名
    $full_class_name = get_class($model);

    // 获取基类名
    $class_name = class_basename($full_class_name);

    // 蛇形命名
    $snake_case_name = snake_case($class_name);

    // 获取子串的复数形式
    return str_plural($snake_case_name);
}