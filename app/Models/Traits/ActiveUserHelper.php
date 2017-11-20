<?php

namespace App\Models\Traits;

use Carbon\Carbon;
use Cache;
use DB;

trait ActiveUserHelper
{
    // 临时存放user数据
    protected $users = [];

    // 配置信息
    protected $topic_weight = 4; // 话题
    protected $reply_weight = 1; // 回复
    protected $pass_days = 7; // 取出数据周期
    protected $user_number = 8; // 每次取的用户数

    // 缓存配置
    protected $cache_key = "boxue_active_users";
    protected $cache_expire_in_minutes = 65; // 缓存过期时间



}