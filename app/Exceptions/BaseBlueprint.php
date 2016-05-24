<?php
/**
 * 使用 PhpStorm 创建.
 * 创建人: zhang
 * 日期: 16-5-8
 * 时间: 下午9:20
 * Blueprint 扩展契约
 */

namespace App\Exceptions;



trait BaseBlueprint{
    public function marginTree(){
        $this->integer('parent_id')->default(0)->comment('父级ID');
        $this->smallInteger('level')->default(0)->comment('层级');
        $this->integer('left_margin')->default(0)->comment('左边界');
        $this->integer('right_margin')->default(0)->comment('右边界');
    }

    public function dropMarginTree()
    {
        $this->dropColumn('parent_id', 'level','left_margin','right_margin');
    }

} 