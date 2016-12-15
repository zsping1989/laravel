<?php
/**
 * 图片处理
 */

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class ImgController extends Controller
{


    /**
     * 二维码图片输出
     * @return mixed
     */
    public function getQrcodePng($level=0,$size = 3, $margin =4){
        if(!in_array($level,[0,1,2,3])){
            $level = 0;
        }
        return response(\PHPQRCode\QRcode::png(Request::input('content'),false,$level,$size,$margin),200)->header('Content-Type', 'image/png');
    }
}
