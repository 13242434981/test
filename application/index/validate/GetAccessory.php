<?php

namespace app\index\validate;

use think\Validate;

class GetAccessory extends Validate {
    protected $rule = [
        'menu_id'  => 'require|integer' ,// # 项目ID -> prj_id
        'sub_menu_id' => 'require|integer' ,//  # 类别ID -> code_id
    ];

    protected $message = [
        'menu_id.require'  => '项目编号不能为空' ,
        'menu_id.integer'  => '项目编号必须是整数' ,
        'sub_menu_id.require' => '类别不能为空' ,
        'sub_menu_id.integer' => '类别编号必须是整数',
    ];
}