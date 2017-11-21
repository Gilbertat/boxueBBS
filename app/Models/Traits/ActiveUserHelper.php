<?php

namespace App\Models\Traits;

use App\Models\Reply;
use App\Models\Topic;
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


    // 从缓存中获取数据,如果有则直接读取，没有则计算，并将数据写入到缓存中
    public function getActiveUsers()
    {
        return Cache::remember($this->cache_key, $this->cache_expire_in_minutes, function () {
           return $this->calculateActiveUsers();
        });
    }

    public function calculateAndCacheActiveUsers()
    {
        // 获取活跃用户
        $active_users = $this->calculateActiveUsers();
        // 缓存活跃用户
        $this->cacheActiveUsers($active_users);
    }

    // 计算活跃用户
    private function calculateActiveUsers()
    {
        $this->calculateTopicScore();
        $this->calculateReplyScore();

        // 将数组按照积分排序
        $users = array_sort($this->users, function ($user) {
            return $user['score'];
        });

        // 数组倒序,高分在前
        $users = array_reverse($users, true);

        // 获取指定数量的用户
        $users = array_slice($users, 0, $this->user_number, true);

        // 新建空集合
        $active_users = collect();

        foreach ($users as $user_id => $user) {
            // 判断能否找到用户
            $user = $this->find($user_id);

            if (count($user)) {
                $active_users->push($user);
            }
        }

        return $active_users;
    }


    // 计算话题得分
    private function calculateTopicScore()
    {
        $topic_users = Topic::query()
            ->select(DB::raw('user_id, count(*) as topic_count'))
            ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
            ->groupBy('user_id')
            ->get();

        // 根据话题数量计算得分
        foreach ($topic_users as $value) {
            $this->users[$value->user_id]['score'] = $value->topic_count * $this->topic_weight;
        }
    }

    // 计算评论得分
    private function calculateReplyScore()
    {
        $reply_users = Reply::query()
            ->select(DB::raw('user_id, count(*) as reply_count'))
            ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
            ->groupBy('user_id')
            ->get();

        // 计算回复数量得分
        foreach ($reply_users as $value) {
            $reply_score = $value->reply_count * $this->reply_weight;
            if (isset($this->users[$value->user_id])) {
                $this->users[$value->user_id]['score'] += $reply_score;
            } else {
                $this->users[$value->user_id]['score'] = $reply_score;
            }
        }
    }

    // 将活跃用户添加到缓存中
    private function cacheActiveUsers($active_users)
    {
        // 将数据放入缓存中
        Cache::put($this->cache_key, $active_users, $this->cache_expire_in_minutes);
    }

}