<?php

use App\Models\User;

return [
    // 页面标题
    'title' => '用户',

    'single' => '用户',
    // 数据模型
    'model' => User::class,

    // 权限认证
    'permission' => function () {
        return Auth::user()->can('manage_users');
    },

    // 渲染columns
    'columns' => [
        'id',
        'avatar' => [
            'title' => '头像',
            // 默认直接输出数据，也可定制输出内容
            'output' => function ($avatar, $model) {
                return empty($avatar) ? 'N/A' : '<img src="' . $avatar . '"width="40">';
            },

            // 是否允许排序
            'sortable' => false,
        ],


        'name' => [
            'title' => '用户名',
            'sortable' => false,
            'output' => function ($name, $model) {
                return '<a href="/users/' . $model->id . '"target=_blank>' . $name . '</a>';
            },
        ],

        'email' => [
            'title' => '邮箱',
        ],

        'operation' => [
            'title' => '管理',
            'sortable' => false,
        ],
    ],

    // 模型表单设置项
    'edit_fields' => [
        'name' => [
            'title' => '用户名',
        ],
        'email' => [
            'title' => '邮箱',
        ],
        'password' => [
            'title' => '密码',
            'type' => 'password',
        ],
        'avatar' => [
            'title' => '用户头像',
            'type' => 'image',
            // 上传图片的路径
            'location' => public_path() . '/uploads/images/avatars',
        ],
        'roles' => [
            'title' => '用户角色',
            // 指定数据类型为关联模型
            'type' => 'relationship',
            // 关联模型字段
            'name_field' => 'name',
        ],
    ],

    // 数据过滤设置
    'filters' => [
        'id' => [
            'title' => '用户ID',
        ],
        'name' => [
            'title' => '用户名',
        ],
        'email' => [
          'title' => '邮箱',
        ],
    ],
];