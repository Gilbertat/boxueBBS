<?php

use Spatie\Permission\Models\Role;

return [
    'title' => '角色',
    'single' => '角色',
    'model' => Role::class,

    'permission' => function()
    {
        return Auth::user()->can('manage_users');
    },

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],

        'name' => [
            'title' => '标识'
        ],

        'permission' => [
            'title' => '权限',
            'output' => function ($value, $model) {
                $model->load('permission');
                $result = [];
                foreach ($model->permission as $permission) {
                    $result[] = $permission->name;
                }
                return empty($result) ? 'N/A' : implode($result, '|');
            },
            'sortable' => false,
        ],

        'operation' => [
            'title' => '管理',
            'output' => function ($value, $model) {
                return $value;
            },
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'name' => [
            'title' => '标识',
        ],
        'permission' => [
            'type' => 'relationship',
            'title' => '权限',
            'name_field' => 'name',
        ],
    ],

    'filters' => [
        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title' => '标识',
        ]
    ],

    // 表单验证规则
    'rules' => [
        'name' => 'required|max:15|unique:roles,name',
    ],

    // 表单验证错误的提示消息
    'messages' => [
        'name.required' => '标识不能为空',
        'name.unique' => '标识已存在',
    ]
];