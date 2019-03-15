<?php

namespace app\common\controller;

use think\App;
use think\Controller;

class common extends Controller {
    public function __construct( App $app = null ) {
        parent::__construct( $app );

        if ( is_null( session( config( 'config.session_name' ) ) ) ) {
            exit( json_encode( [ 'msg' => '请登录!' , 'status' => 0 ] ) );
        }
    }
}