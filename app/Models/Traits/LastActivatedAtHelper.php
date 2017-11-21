<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Redis;
use Reids;
use Carbon\Carbon;

trait LastActivatedAtHelper
{
    // cache prefix
    protected $hash_prefix = 'boxuebbs_last_activated_at_';
    protected $field_prefix = 'user_';


    // record activated_at
    public function recordLastActivatedAt()
    {

        // use redis hash
        // hash name
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());

        // field name
        $field = $this->getHashField();

        // get now
        $now = Carbon::now()->toDateTimeString();

        // save data to redis
        Redis::hset($hash, $field, $now);
    }

    // save the data from redis to database
    public function syncUserActivatedAt()
    {
        $hash = $this->getHashFromDateString(Carbon::now()->subDay()->toDateString());

        // get data
        $dates = Redis::hGetAll($hash);

        // foreach the data and save to database
        foreach ($dates as $user_id => $activated_at) {
            $user_id = str_replace($this->field_prefix, '', $user_id);

            if ($user = $this->find($user_id)) {
                $user->last_activated_at = $activated_at;
                $user->save();
            }
        }

        // when data save to database delete the redis data
        Redis::del($hash);
    }

    // get data from database
    public function getLastActivatedAtAttribute($value)
    {

        // set hash name
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());
        // field name
        $field = $this->getHashField();

        // get the data
        $datetime = Redis::hget($hash, $field) ?: $value;

        if ($datetime) {
            return new Carbon($datetime);
        } else {
            return $this->created_at;
        }

    }

    public function getHashFromDateString($date)
    {
        return $this->hash_prefix . $date;
    }

    public function getHashField()
    {
        return $this->field_prefix . $this->id;
    }
}