<?php
/**
 * 通过 PhpStorm 创建.
 * 创建人: zhangshiping
 * 日期: 16-5-20
 * 时间: 下午6:21
 */

namespace App;
use Illuminate\Database\Eloquent\Model;


class BaseModel extends Model{
    public function scopeOptions($query,array $options=[])
    {
        //条件筛选
        collect($options['where'])->each(function($item,$key) use(&$query){
            $val = $item->exp=='like' ? '%'.preg_replace('/([_%])/','\\\$1', $item->val).'%' : $item->val;
            $item and $query->where($key,$item->exp,$val);
        });
        //排序
        collect($options['order'])->each(function($item,$key) use (&$query){
            $item and $query->orderBy($key,$item);
        });
        return $query;
    }




} 