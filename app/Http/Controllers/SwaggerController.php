<?php
/**
 * @Swagger(
 *     schemes={"http"},
 *     basePath="/data/",
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
namespace App\Http\Controllers;


use App\Http\Requests;

class SwaggerController extends Controller
{

    public function doc()
    {
        $swagger = \Swagger\scan(realpath(__DIR__.'/../../'));
        return response()->json($swagger);
    }
}
