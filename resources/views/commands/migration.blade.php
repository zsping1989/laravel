{!! $php !!}

use Illuminate\Database\Migrations\Migration;

class Create{{$class}}Table extends Migration
{
    /**
     * Run the migrations.
     *
     * 返回: void
     */
    public function up()
    {
        DB::statement("{!! $create !!}");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('drop table '.config('database.connections.mysql.prefix').'{{$table}}');
    }
}
