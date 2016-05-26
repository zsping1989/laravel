<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 14-11-24
 * Time: 下午10:39
 * 边界数据结构扩展契约
 */

namespace App\Exceptions\MarginTree;



use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;

trait TreeModel{

    /**
     * 变量:边界数操作服务对象
     */
    protected $nestend;


    /**
     * 变量: array 自定义树状结构相关字段
     */
    protected $treeField = [
        "level_key"=>"level",
        "left_key"=>"left_margin",
        "right_key"=>"right_margin",
        "parent_key"=>"parent_id"
    ];

    /**
     * 初始化方法
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootTreeModel()
    {

    }


    /**
     * 注册服务
     * param NestedSetsService $nestedSetsService
     */

    public function treeInit(NestedSetsService $nestedSetsService){
        $this->treeField['primary_key'] = $this->getKeyName();
        $nestedSetsService->init(env('DB_PREFIX').$this->getTable(), $this->treeField);
        $this->nestend = $nestedSetsService;
    }


    /**
     * 重写插入方法
     * param Builder $query
     * param $attributes
     */
    protected function insertAndSetId(Builder $query, $attributes)
    {
        //默认父ID
        $attributes[$this->treeField['parent_key']] = array_get($attributes,$this->treeField['parent_key'],1);

        //初始化配置
        $this->treeInit(app('NestedSetsService'));

        //开启事务,处理边界
        DB::beginTransaction();

        //边界处理,返回修改值
        $attributes = $this->nestend->insert($attributes[$this->treeField['parent_key']],$attributes,'bottom');

        //保存数据
        $id = $query->insertGetId($attributes, $keyName = $this->getKeyName());

        //结果提交
        if($attributes!==false && $id){
            DB::commit();
        }else{
            DB::rollback();
            return false;
        }

        //赋值
        $this->setAttribute($keyName, $id);
        $this->setAttribute($this->treeField['parent_key'], $attributes[$this->treeField['parent_key']]);
        $this->setAttribute($this->treeField['level_key'], $attributes[$this->treeField['level_key']]);
        $this->setAttribute($this->treeField['left_key'], $attributes[$this->treeField['left_key']]);
        $this->setAttribute($this->treeField['right_key'], $attributes[$this->treeField['right_key']]);
    }


    /**
     * 重写更新数据
     * Perform a model update operation.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $options
     * @return bool
     */
    protected function performUpdate(Builder $query, array $options = [])
    {
        $dirty = $this->getDirty();

        if (count($dirty) > 0) {
            // If the updating event returns false, we will cancel the update operation so
            // developers can hook Validation systems into their models and cancel this
            // operation if the model does not pass validation. Otherwise, we update.
            if ($this->fireModelEvent('updating') === false) {
                return false;
            }

            // First we need to create a fresh query instance and touch the creation and
            // update timestamp on the model which are maintained by us for developer
            // convenience. Then we will just continue saving the model instances.
            if ($this->timestamps && Arr::get($options, 'timestamps', true)) {
                $this->updateTimestamps();
            }

            // Once we have run the update operation, we will fire the "updated" event for
            // this model instance. This will allow developers to hook into these after
            // models are updated, giving them a chance to do any special processing.
            $dirty = $this->getDirty();

            if (count($dirty) > 0) {
                $move_result = true;

                //有修改父节点
                if(isset($dirty[$this->treeField['parent_key']]) && $dirty[$this->treeField['parent_key']]){
                    //初始化配置
                    $this->treeInit(app('NestedSetsService'));

                    //开启事务,处理边界
                    DB::beginTransaction();

                    //进行移动
                    $move_result = $this->nestend->moveUnder($this->getAttribute($this->getKeyName()),$dirty[$this->treeField['parent_key']]);

                    //移动结果判断
                    if($move_result===false){
                        DB::rollback();
                        return false;
                    }
                }

                $numRows = $this->setKeysForSaveQuery($query)->update($dirty);

                if($move_result && $numRows!==false){
                    DB::commit();
                }else{
                    DB::rollback();
                    return false;
                }

                $this->fireModelEvent('updated', false);
            }
        }

        return true;
    }


    /**
     * 重写删除方法
     * Delete the model from the database.
     *
     * return bool|null
     *
     * throws \Exception
     */
    public function delete()
    {
        if (is_null($this->getKeyName())) {
            throw new Exception('No primary key defined on model.');
        }

        if ($this->exists) {
            if ($this->fireModelEvent('deleting') === false) {
                return false;
            }

            // Here, we'll touch the owning models, verifying these timestamps get updated
            // for the models. This will allow any caching to get broken on the parents
            // by the timestamp. Then we will go ahead and delete the model instance.
            $this->touchOwners();

            //删除子节点
            $this->deleteChilds();

            $this->performDeleteOnModel();

            $this->exists = false;

            // Once the model has been deleted, we will fire off the deleted event so that
            // the developers may hook into post-delete operations. We will then return
            // a boolean true as the delete is presumably successful on the database.
            $this->fireModelEvent('deleted', false);

            return true;
        }
    }


    /**
     * 删除子节点
     * 返回: bool
     */
    public function deleteChilds(){
        //边界获取
        $left = $this->getAttribute($this->treeField['left_key']);
        $right = $this->getAttribute($this->treeField['right_key']);

        //没有边界,或没有子节点
        if((!$left && !$right) || ($left+1==$right)){
            return 0;
        }

        //没有使用软删除
        if(!isset($this->forceDeleting)){
            return $this->newQueryWithoutScopes()->where($this->treeField['left_key'],'>',$left)->where($this->treeField['right_key'],'<',$right)->delete();

        //真删除
        }elseif($this->forceDeleting) {
            return $this->newQueryWithoutScopes()->where($this->treeField['left_key'],'>',$left)->where($this->treeField['right_key'],'<',$right)->forceDelete();

        //软删除
        }else{
            $query = $this->newQueryWithoutScopes()->where($this->treeField['left_key'],'>',$left)->where($this->treeField['right_key'],'<',$right);

            $this->{$this->getDeletedAtColumn()} = $time = $this->freshTimestamp();

            $query->update([$this->getDeletedAtColumn() => $this->fromDateTime($time)]);
        }
    }

    public function childs(){
        $left = $this->getAttribute($this->treeField['left_key']);
        $right = $this->getAttribute($this->treeField['right_key']);
        //没有边界,或没有子节点
        if((!$left && !$right) || ($left+1==$right)){
            return collect([]);
        }
        return self::where($this->treeField['left_key'],'>',$left)->where($this->treeField['right_key'],'<',$right)->orderBy($this->treeField['left_key'])->get();
    }

    public function parents($self = false){
        $left = $this->getAttribute($this->treeField['left_key']);
        $right = $this->getAttribute($this->treeField['right_key']);
        $self AND $self = '=';
        return self::where($this->treeField['left_key'],'<'.$self,$left)->where($this->treeField['right_key'],'>'.$self,$right)->orderBy($this->treeField['left_key'])->get();
    }





}