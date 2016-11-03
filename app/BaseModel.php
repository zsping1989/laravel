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
            if(!$item || $item['val']===''){
                return ;
            }
            //like匹配
            if($item['exp']=='like'){
                $val = '%'.preg_replace('/([_%\'"])/','\\\$1', $item['val']).'%';
                //时间戳处理
            }else if(isset($item['type'])&&($item['type']=='dateStart' || $item['type']=='dateEnd')){
                //dd($item['val']);
                $val = $item['type']=='dateStart' ? strtotime($item['val'].' 00:00:00') : strtotime($item['val'].' 23:59:59');
                //其它
            }else{
                $val = $item['val'];
            }

            if($item['exp']=='in'){
                $query->whereIn($item['key'],is_array($val) ? $val : explode(',',$val));
            }elseif($item['exp']=='like'){
                $fileds = explode('|',$item['key']);
                if(count($fileds)>1){
                    $item['key'] = 'concat(`'.implode('`,`',$fileds).'`)';
                    $query->whereRaw($item['key'].' like "'.$val.'"');
                }else{
                    $query->where($item['key'],$item['exp'],$val);
                }
            }else{
                $query->where($item['key'],$item['exp'],$val);
            }
        });
        //排序
        isset($options['order']) AND collect($options['order'])->each(function($item,$key) use (&$query){
            $item and $query->orderBy($key,$item);
        });
        return $query;
    }




} 