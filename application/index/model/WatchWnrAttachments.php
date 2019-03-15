<?php

namespace app\index\model;

use think\Exception;
use think\exception\DbException;
use think\exception\PDOException;
use think\Model;

/**
 * 附件表
 * Class WatchWnrAttachments
 * @package app\index\model
 */
class WatchWnrAttachments extends Model {

    public function getAccessoryList( $prj_id , $code_id , $page , $limit ) {
        try {
            $where = [ 'delstatus' => 0 , 'prj_id' => $prj_id , 'data_category' => $code_id , ];

            $data['data'] = $this->field( [ 'id' , 'name' ] )
                                 ->where( $where )
                                 ->page( ( $page ?? 1 ) , $limit ?? 10 )
                                 ->select();

            $data['count'] = $this->where( $where )->count( 'id' );
            return $data;
        } catch ( DbException $exception ) {
            trace( $exception->getMessage() );
            return [];
        }
    }

    public function add( $data , $nick ) {
//        //获取操作人员信息
//        try {
//            $userInfo = $this->table( 'fieldman' )
//                             ->where( [ 'username' => $username , 'delstatus' => 0 , 'is_stop' => 0 ] )
//                             ->field( 'id,username,nick' )
//                             ->find();
//        } catch ( DbException $exception ) {
//            trace( $exception->getMessage() );
//            $this->error = '添加失败';
//            return false;
//        }
        // # insertAll()
        $res = $this->insert( [
            'hash'          => $data['has'] ,
            'prj_id'        => $data['prj_id'] ,
            'data_category' => $data['code_id'] ,
            'name'          => $data['oldFileName'] ,
            'size'          => $data['szie'] ,
            'ext'           => $data['ext'] ,
            'type'          => $data['type'] ,
            'path'          => $data['path'] ,
            'addr'          => $nick ,
            'text'          => $data['text'] ,
            'created'       => time() ,
        ] );

        if ( !$res ) {
            $this->error = '添加失败';
            return false;
        }

        return true;
    }


    public function saveAccessory($id) {
        try{
            //$this->where('id',$id)->update([]);
            return true;
        }catch (Exception $exception){
            trace( $exception->getMessage() );
            $this->error = '系统异常，请稍后再试';
            return false;
        }
    }


    public function delAccessory( $id , $name ) {
        try {
            $userInfo = $this->table( 'fieldman' )->where( 'username' , $name )->field( 'id,username,nick' )->find();
            $this->startTrans();
            $res = $this->whereIn( 'id' , $id )->update( [
                'delstatus' => 1 ,
                'del_uid'   => $userInfo['id'] ,
                'del_uname' => $userInfo['username'] ,
                'del_time'  => date( 'Y-m-d H:i:s' , time() ),
            ] );

            if ( $res ) {
                $this->commit();
                return true;
            } else {
                $this->rollback();
                $this->error = '删除失败';
                return false;
            }
        } catch ( PDOException  $exception ) {
            trace( $exception->getMessage() );
            $this->error = '系统异常，请稍后再试';
            return false;
        }catch (Exception $exception){
            trace( $exception->getMessage() );
            $this->error = '系统异常，请稍后再试';
            return false;
        }
    }
}