<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class GiftCard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phpstore:card';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '插入礼品卡数据';

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
        if($this->confirm('您确认插入测试礼品卡数据吗? [y|N]')){

            $card_list          = $this->get_card_list();
            $insert_count       = 0;
            $bar                = $this->output->createProgressBar(count($card_list));
            foreach($card_list as $item){

                if($item){

                    if($id = DB::table('card')->insertGetId($item)){

                        $insert_count ++;
                        $this->info("您已导入数据: " . $insert_count);
                        $bar->advance();
                    }
                }
            }

            $this->info("您已经成功添加完所有数据.");
            $bar->finish();
        }
    }


    public function get_card_list(){

        $row            = [];

        for($i = 0; $i < 10000;$i++){

            $row[]          = [

                                    'card_sn'       =>md5(uniqid().time()),
                                    'price'         => $i,
                                    'add_time'      =>time(),
                                    'end_time'      =>time(),
                                    'pay_time'      =>time(),
                                    'tag'           =>0,
                                    'sort_order'    => 0,

            ];
        }

        return $row;
    }
}
