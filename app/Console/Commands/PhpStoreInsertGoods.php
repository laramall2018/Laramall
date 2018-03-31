<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class PhpStoreInsertGoods extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phpstore:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '启用PhpStore命令行批量导入商品数据信息';

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
        
        if($this->confirm('您确认导入测试商品数据吗? [y|N]')){

            $goods_list         = \Install\Common::goods_list();
            $insert_count       = 0;
            $bar                = $this->output->createProgressBar(count($goods_list));
            foreach($goods_list as $goods){

                if($goods){

                    if($id = DB::table('goods')->insertGetId($goods)){

                        $insert_count ++;
                        $this->info("您已导入商品数据: " . $insert_count);
                        $bar->advance();
                    }
                }
            }

            $this->info("您已经成功添加完商品数据.");
            $bar->finish();
        }

    }



}
