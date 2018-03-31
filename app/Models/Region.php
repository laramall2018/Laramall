<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\RegionRepository;

class Region extends Model{

    use RegionRepository;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	
	protected $table = 'region';
    protected $primaryKey = 'region_id';


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取省会信息
    |
    |-------------------------------------------------------------------------------
    */
    public static function province(){

    	return Region::where('region_type',1)->get();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 通过id获取region
    |
    |-------------------------------------------------------------------------------
    */
    public static function name($id){

        $model      = Region::find($id);

        if(empty($model)){

            return '';
        }

        return $model->region_name;

    }
    
}