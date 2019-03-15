<?php

namespace app\index\validate;

use think\Validate;

class User extends Validate {
    protected $rule = [
        'user'  =>  'require',
        'pass' =>  'require',
    ];

    protected $message  =   [
        'name.require' => '用户名不能为空',
        'pass.require'   => '密码不能为空',
    ];
}