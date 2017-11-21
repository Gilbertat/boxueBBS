<?php

namespace App\Observers;

use App\Models\Link;
use Cache;

class LinkObserver
{
    // 资源变更后清除redis缓存
    public function saved(Link $link)
    {
        Cache::forget($link->cache_key);
    }
}