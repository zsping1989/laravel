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
    public function getQrcodePng(){
        return response(\PHPQRCode\QRcode::png(Request::input('content')),200)->header('Content-Type', 'image/png');
    }
}
