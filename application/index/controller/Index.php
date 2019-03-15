<?php

namespace app\index\controller;

use app\common\controller\Common;
use app\index\model\PrjBase;
use app\index\model\SystemCodes;
use app\index\model\WatchWnrAttachments;
use app\index\validate\GetAccessory;
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

        $data = $model->getAccessoryList( $post['menu_id'] , $post['sub_menu_id'] );

        return return_json( '查询成功' , 1 , $data );
    }


    /**
     * 上传附件
     * @param Request $request
     */
    public function upload( Request $request ) {
        $post = $request->post();

        $path = 'test/';

        $files = $request->file();
        foreach ( $files as $file ) {
            // 移动到框架应用根目录/uploads/ 目录下
            $info = $file->validate( [ 'size' => 15678 , 'ext' => 'jpg,png,gif,txt' ] )
                         ->move( '../../CDM_EX/home/upload/' . $path );

            if ( $info ) {
                $fileInfo     = $info->getInfo();
                $data['hash'] = $info->sha1();//哈希值
                $data['name'] = $fileInfo['name'];//文件原名称
                $data['size'] = $fileInfo['size'];//文件大小
                $data['ext']  = $info->getExtension();//文件后缀
                $data['type'] = $fileInfo['type'];
                $data['path'] = $path . str_replace( '\\' , '/' , $info->getSaveName() );//文件路径
                $data['text'] = $info->getFilename();//文件名
            } else {
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }

        $model                 = new WatchWnrAttachments();
        $data['prj_id']        = $post['prj_id'];
        $data['data_category'] = $post['code_id'];

        if ( !$model->add( $data , session( config( 'config.session_name' ) ) ) ) {
            return return_json( $model->getError() );
        }

        return return_json( '添加成功' , 200 );
    }


    /**
     * 删除附件
     * @param Request $request
     */
    public function del( Request $request ) {
        $post = $request->post();


        $model = new WatchWnrAttachments();

        $model->delAccessory( $post['id'] );
    }


    /**
     * 保存
     */
    public function edit() {

    }


    /**
     * 用户退出
     */
    public function quit(){
        session(null);

        return return_json('退出成功!',1);
    }
}
