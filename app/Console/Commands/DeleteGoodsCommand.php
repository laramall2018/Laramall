<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\Goods;

class DeleteGoodsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phpstore:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '删除批量导入的商品数据';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
         $goods_list    = DB::table('goods')->where('goods_name','like','%西门子%')->get();
         $del_count     = 0;
         $bar           = $this->output->createProgressBar(count($goods_list));

         foreach($goods_list as $item){


                $goods      = Goods::find($item->id);
                if($goods){

                    if($goods->delete()){

                        $del_count ++;
                        $this->info('成功删除商品数据第:'.$del_count.'条');
                        $bar->advance();
                    }
                }
         }

         $this->info("您已经成功删除完商品数据.");
         $bar->finish();


    }
}
