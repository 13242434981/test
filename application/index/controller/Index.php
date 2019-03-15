<?php

namespace app\index\controller;

use app\common\controller\Common;
use app\index\model\PrjBase;
use app\index\model\SystemCodes;
use app\index\model\WatchWnrAttachments;
use app\index\validate\GetAccessory;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\Request;

class Index extends Common {

    /**
     * 首页返回项目列表数据及分类数据
     * @return \think\response\Json
     */
    public function index() {
        $prjBase     = new PrjBase();
        $systemCodes = new SystemCodes();

        $prjBaseData     = $prjBase->getProjectList();
        $systemCodesData = $systemCodes->getClassList();

        $data['data']['menu']     = $prjBaseData;
        $data['data']['sub_menu'] = $systemCodesData;

        return return_json( '查询成功' , 1 , $data );
    }


    /**
     * 获取附件数据
     * @param Request $request
     * @return \think\response\Json
     */
    public function getList( Request $request ) {
        $post     = $request->post();
        $validate = new GetAccessory();

        // 检测数据合法性
        if ( !$validate->check( $post ) ) {
            return return_json( $validate->getError() );
        }

        $model = new WatchWnrAttachments();

        $data = $model->getAccessoryList( $post['menu_id'] , $post['sub_menu_id'] , $post['page'] , $post['limit'] );

        return return_json( '查询成功' , 1 , $data );
    }


    /**
     * 上传附件
     */
    public function upload( Request $request ) {
        $post = $request->post();

        //$validate = new GetAccessory();
//
        //// 检测数据合法性
        //if ( !$validate->check( $post ) ) {
        //    return return_json( $validate->getError() );
        //}

        $path = 'test/';

        $data = [];

        $files = $request->file();
        foreach ( $files['img'] as $file ) {
            // 移动到框架应用根目录/uploads/ 目录下
            $info = $file->validate( [ 'size' => 156781111 , 'ext' => 'jpg,png,gif,txt,doc' ] )
                         ->move( '../../CDM_EX/home/upload/' . $path );
            if ( $info ) {
                $fileInfo             = $info->getInfo();
                $arr['hash']          = $info->sha1();//哈希值
                $arr['name']          = $fileInfo['name'];//文件原名称
                $arr['size']          = $fileInfo['size'];//文件大小
                $arr['ext']           = $info->getExtension();//文件后缀
                $arr['type']          = $fileInfo['type'];
                $arr['path']          = $path . str_replace( '\\' , '/' , $info->getSaveName() );//文件路径
                $arr['text']          = $info->getFilename();//文件名
                $arr['prj_id']        = $post['prj_id'] ?? 1;
                $arr['data_category'] = $post['code_id'] ?? 1;
                array_push( $data , $arr );
            } else {
                // 上传失败获取错误信息
                return return_json( $file->getError() );
            }
        }

        $model = new WatchWnrAttachments();
        return return_json( '测试信息返回' , 1 , $data );
        if ( !$model->add( $data , session( config( 'config.session_name' ) ) ) ) {
            return return_json( $model->getError() );
        }

        return return_json( '添加成功' , 200 );
    }


    /**
     * 删除附件
     */
    public function del( ) {
        $post = $this->request->post();

        $model = new WatchWnrAttachments();

        $model->delAccessory( $post['id'] , session( config( 'config.session_name' ) ) );
    }


    /**
     * 保存
     */
    public function edit() {

    }


    /**
     * 用户退出
     */
    public function quit() {
        session( null );

        return return_json( '退出成功!' , 1 );
    }
}
