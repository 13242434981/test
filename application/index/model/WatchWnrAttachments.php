<?php

namespace app\index\model;

use think\Model;

/**
 * 附件表
 * Class WatchWnrAttachments
 * @package app\index\model
 */
class WatchWnrAttachments extends Model {

    public function getAccessoryList( $prj_id , $code_id ) {
        $data = $this->field( [ 'id' , 'name' ] )->where( [
            'delstatus'     => 0 ,
            'prj_id'        => $prj_id ,
            'data_category' => $code_id ,
        ] )->select();

        return $data;
    }

    public function add( $data , $username ) {
        //获取操作人员信息
        $userInfo = $this->table( 'fieldman' )
                         ->where( [ 'username' => $username , 'delstatus' => 0 , 'is_stop' => 0 ] )
                         ->field( 'id,username,nick' )
                         ->find();

        $res = $this->insert( [
            'hash'          => $data['has'] ,
            'prj_id'        => $data['prj_id'] ,
            'data_category' => $data['code_id'] ,
            'name'          => $data['oldFileName'] ,
            'size'          => $data['szie'] ,
            'ext'           => $data['ext'] ,
            'type'          => $data['type'] ,
            'path'          => $data['path'] ,
            'addr'          => $userInfo['nick'] ,
            'text'          => $data['text'] ,
            'created'       => time() ,
        ] );

        if ( !$res ) {
            $this->error = '添加失败';
            return false;
        }

        return true;
    }


    public function delAccessory( $id ) {

    }
}