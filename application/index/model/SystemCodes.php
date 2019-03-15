<?php

namespace app\index\model;

use think\Model;

/**
 * 类别表
 * Class SystemCodes
 * @package app\index\model
 */
class SystemCodes extends Model {

    protected $pk = 'code_id';

    public function getClassList() {
        $data = $this->field('code_id,codes_name')->where( [ 'codes_no' => 'data_category' , 'delstatus' => 0 ] )->select();
        return $data;
    }
}