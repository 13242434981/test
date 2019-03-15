<?php

namespace app\index\model;

use think\Model;

/**
 * 项目表
 * Class PrjBase
 * @package app\index\model
 */
class PrjBase extends Model {

    protected $pk = 'prj_id';

    /**
     * 获取项目列表信息
     */
    public function getProjectList() {
        $prjBaseData = $this->field( [ 'prj_id'=>'id' , 'prj_name'=>'title' , ] )->where( [ 'status' => 100 , 'delstatus' => 0 ] )->select();

        return $prjBaseData;
    }
}