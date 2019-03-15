<?php

namespace app\index\controller;

class Error{
    public function _empty(){
        return return_json('请求错误!');
    }
}