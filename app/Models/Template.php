<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\ConfigRepository;
class Template extends Model{

	use ConfigRepository;
	protected $table = 'template_config';

}