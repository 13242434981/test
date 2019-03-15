<?php

namespace app\index\model;

use think\exception\DbException;
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
        try {
            $prjBaseData = $this->field( [ 'prj_id' => 'id' , 'prj_name' => 'title' , ] )->where( [
                'status'    => 100 ,
                'delstatus' => 0,
            ] )->select();
            return $prjBaseData;
        } catch ( DbException $exception){
            trace($exception->getMessage());
            return [];
        }
    }
}