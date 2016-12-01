<?php
/**
 * @Swagger(
 *     schemes={"http"},
 *     basePath="",
 *     consumes={"application/json"},
 *     tags={
 *         @SWG\Tag(
 *             name="API",
 *             description="API接口"
 *         )
 *     }
 * )
 *
 * @Info(
 *  title="API文档",
 *  version="0.1"
 * )
 *
 * @return mixed
 */
namespace App\Http\Controllers\Home;


use App\Http\Controllers\Controller;
use App\Http\Requests;

class SwaggerController extends Controller
{

    public function doc()
    {
        $swagger = \Swagger\scan(app_path());
        return response()->json($swagger);
    }
}
