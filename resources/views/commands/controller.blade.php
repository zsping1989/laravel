{!! $php !!}

namespace {{$namespace}};

use App\Exceptions\ResourceController;
use App\Http\Controllers\Controller;
use App\{{$model}};

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
@endif


}