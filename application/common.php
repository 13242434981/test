<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

if ( !function_exists( 'return_json' ) ) {
    /**
     * 返回json数据
     * @param string $msg
     * @param int $code
     * @param array $data
     * @return \think\response\Json
     */
    function return_json( $msg = '' , $code = 0 , $data = [] ) {
        if(!empty($data)){
            $data = array_merge( [ 'msg' => $msg , 'status' => $code ] , $data );
        }else{
            $data = [ 'msg' => $msg , 'status' => $code ];
        }

        return json( $data );
    }
}


if ( !function_exists( 'pass_md5' ) ) {
    /**
     * 加密字符串
     * @param $pass
     * @param string $key
     * @return string
     */
    function pass_md5( $pass , $key = '' ) {
        if ( empty( $key ) ) {
            return md5( $pass . config( 'config.pass_key' ) );
        }
        return md5( $pass . $key );
    }
}