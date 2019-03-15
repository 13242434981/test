<?php

namespace app\index\controller;

use app\index\model\User;
use think\Request;

class Login {

    public function _empty() {
        return return_json( '请求错误!' );
    }

    /**
     * 登陆验证
     * @param Request $request
     * @return \think\response\Json
     */
    public function index( Request $request ) {
        $post = $request->post();
        //数据合法性验证
        $validate = new \app\index\validate\User;
        if ( !$validate->check( $post ) ) {
            return return_json( $validate->getError() );
        }

        //数据合理性验证
        $model = new User();
        if ( !$userInfo = $model->check( $post['user'] , $post['pass'] ) ) {
            return return_json( $model->getError() );
        }

        //更新用户信息
        if ( !$model->updateUserInfo( $post['user'] ) ) {
            return return_json( $model->getError() );
        }


        session( config( 'config.session_name' ) , $request->post( 'user' ) );
        session( 'nick' , $userInfo['nick'] );


        return return_json( '登陆成功!' , 1 );
    }
}
