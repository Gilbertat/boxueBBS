<?php

use Spatie\Permission\Models\Permission;

return [
    'title' => '权限',
    'single' => '权限',
    'model' => Permission::class,

    'permission' => function () {
        return Auth::user()->can('manage_users');
    },

    // CRUD 单独权限控制
    'action_permissions' => [
        // 允许新建
        'create' => function ($model) { return true; },

        // 允许更新
        'update' => function ($model) { return true; },

        // 禁止删除
        'delete' => function ($model) { return false; },

        // 允许查看
        'view' => function ($model) { return true; },
    ],

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title' => '标示',
        ],
        'operation' => [
            'title' => '管理',
            'sortable' => false,
        ],
    ],

    'edit_field' => [
        'name' => [
            'title' => '标示(请慎重修改)',
            // 表单旁的提示信息
            'hint' => '修改权限标识会影响代码的调用，请不要轻易更改!',
        ],

        'roles' => [
            'type' => 'relationship',
            'title' => '角色',
            'name_field' => 'name',
        ],
    ],

    'filters' => [
        'name' => [
            'title' => '标示',
        ],
    ],
];