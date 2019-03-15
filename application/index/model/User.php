<?php
/**
 * Date: 2019/3/13
 * Time: 21:55
 */

namespace app\index\model;

use think\Exception;
use think\exception\DbException;
use think\Model;

class User extends Model {
    protected $table = 'fieldman';

    public function check( $user , $pass ) {

        try {
            $model = $this->field( 'username,id,password,nick' )->where( 'username' , $user )->find();
        } catch ( DbException $exception ) {
            $this->setError( '系统异常，请稍后再试!' );
            trace( $exception->getMessage() , 'info' );
            return false;
        }

        if ( empty( $user ) || is_null( $model ) ) {
            $this->setError( '用户不存在' );
            return false;
        }
        if ( $model->password != pass_md5( $pass ) ) {
            $this->setError( '密码错误' );
            return false;
        }
        return $model;
    }


    public function updateUserInfo( $user ) {
        try {
            $model = $this->where( 'username' , $user )->setField( 'end_login' , date( 'Y-m-d H:i:s' , time() ) );

            if ( $model == 0 ) {
                $this->setError( '更新登录时间失败!' );
                $this->rollback();
                return false;
            }
            $this->commit();

            return true;
        } catch ( Exception $exception ) {
            trace( $exception->getMessage() , 'info' );
            $this->setError('系统异常，请稍后再试！');
            return false;
        }
    }


    public function setError( $error ) {
        $this->error = $error;
    }
}