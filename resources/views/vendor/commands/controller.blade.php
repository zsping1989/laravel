{!! $php !!}

namespace {{$namespace}};


use App\Http\Controllers\Controller;
@if ($resource)
use Custom\Commands\Controllers\ResourceController;
use App\{{$model}};
@endif

class {{$class}} extends Controller
{
@if ($resource)
    use ResourceController; //资源控制器

    /**
    * 模型绑定
    * MenuController constructor.
    * 参数: Menu $bindModel
    */
    public function __construct({{$modelName}} $bindModel){
        $this->bindModel = $bindModel;
    }

    /**
    * 新增或修改,验证规则获取
    * 返回: array
    */
    protected function getValidateRule(){
        return [{!! $validates !!}];
    }
@endif


}