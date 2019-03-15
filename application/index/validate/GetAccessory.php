<?php

namespace app\index\validate;

use think\Validate;

class GetAccessory extends Validate {
    protected $rule = [
        'prj_id'  => 'require|integer' ,
        'code_id' => 'require|integer' ,
    ];

    protected $message = [
        'prj_id.require'  => '项目编号不能为空' ,
        'prj_id.integer'  => '项目编号必须是整数' ,
        'code_id.require' => '类别不能为空' ,
        'cide_id.integer' => '类别编号必须是整数',
    ];
}