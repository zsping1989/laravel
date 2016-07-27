{!! $php !!}
/**
 * {{$table_comment}}模型
 */
namespace {{$namespace}};
use App\BaseModel;
@if ($tree)
use MarginTree\TreeModel;
@endif
@if ($softDeletes)
use Illuminate\Database\Eloquent\SoftDeletes;
@endif

class {{$class}} extends BaseModel
{
@if ($table)
    protected $table = '{{$table}}'; //数据表名称
@endif

@if ($tree)
    use TreeModel; //树状结构
@endif
@if ($softDeletes)
    use SoftDeletes; //软删除
@endif

@if ($fields)
    //批量赋值白名单
    protected $fillable = [{!! $fillable !!}];
    //输出隐藏字段
    protected $hidden = [{!! $delete !!}];
    //日期字段
    protected $dates = [{!! $dates !!}];
  @endif

  }
