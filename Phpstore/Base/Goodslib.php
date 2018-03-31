<?php namespace Phpstore\Base;

use App\Models\Category;
use App\Models\Goods;
use HTML;
use Config;
use DB;
use URL;
use Cache;
class Goodslib{

    /*
    |-------------------------------------------------------------------------------
    |
    |    * 获得指定分类同级的所有分类以及该分类下的子分类
    |    *
    |    * @access  public
    |    * @param   integer     $id     分类编号
    |    * @return  array
    |
    |-------------------------------------------------------------------------------
    */
    public static function get_categories_tree($id = 0)
    {

        if ($id > 0)
        {
            $parent_id = Category::find($id)->parent_id;
        }
        else
        {
            $parent_id = 0;
        }

        /*
         判断当前分类中全是是否是底级分类，
         如果是取出底级分类上级分类，
         如果不是取当前分类及其下的子分类
        */
    

        $count = Category::where('parent_id','=',$parent_id)->where('is_show','=',1)->count();

        if ($count || $parent_id == 0)
        {

            /* 获取当前分类及其子分类 */
            $res = Category::where('parent_id','=',$parent_id)->where('is_show','=',1)->orderBy('sort_order','ASC')->get();

            foreach ($res AS $row)
            {
                if ($row['is_show'])
                {
                    $cat_arr[$row['id']]['id']   = $row['id'];
                    $cat_arr[$row['id']]['name'] = $row['cat_name'];
                    $cat_arr[$row['id']]['cat_pic'] = $row['cat_pic'];
                    
                    if (isset($row['id']) != NULL)
                    {
                        $cat_arr[$row['id']]['id'] = self::get_child_tree($row['id']);
                    }
                }
            }
        }

        if(isset($cat_arr))
        {
            return $cat_arr;
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |    * 获得指定分类同级的所有分类以及该分类下的子分类
    |    *
    |    * @access  public
    |    * @param   integer     $id     分类编号
    |    * @return  array
    |
    |-------------------------------------------------------------------------------
    */
    public static function get_child_tree($tree_id = 0)
    {
        $three_arr = array();

        $count = Category::where('parent_id','=',$tree_id)->where('is_show','=',1)->count();
        
        if ( $count || $tree_id == 0)
        {
            
            //取得当前分类下的子类
            $res = Category::where('parent_id','=',$tree_id)->where('is_show','=',1)->orderBy('sort_order','ASC')->get();
            foreach ($res AS $row)
            {
                if ($row['is_show'])

                $three_arr[$row['id']]['id']   = $row['id'];
                $three_arr[$row['id']]['name'] = $row['cat_name'];
                $three_arr[$row['id']]['cat_pic'] = $row['cat_pic'];

                if (isset($row['id']) != NULL)
                {
                       $three_arr[$row['id']]['id'] = self::get_child_tree($row['id']);

               }
           }
        }
        
        return $three_arr;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |        * 获得指定分类下的子分类的数组
    |        *
    |        * @access  public
    |        * @param   int     $id     分类的ID
    |        * @param   int     $selected   当前选中分类的ID
    |        * @param   boolean $re_type    返回的类型: 值为真时返回下拉列表,否则返回数组
    |        * @param   int     $level      限定返回的级数。为0时返回所有级数
    |        * @param   int     $is_show_all 如果为true显示所有分类，如果为false隐藏不可见分类。
    |        * @return  mix
    |
    |-------------------------------------------------------------------------------
    */

    public static function cat_list2($id = 0, $selected = 0, $re_type = true, $level = 0, $is_show_all = true)
    {
    
        static $res = NULL;

        //获取数据库的前缀
        $prefix = Config::get('database.connections.mysql.prefix');

        if ($res === NULL)
        {

            //拼接category数据表 找出所有分类 并统计该分类的子类
            $row            = DB::table('category as c')
                                ->leftjoin('category as s','s.parent_id','=','c.id')
                                ->select('c.*',DB::raw('count('.$prefix.'s.id) as has_children'))
                                ->groupBy('c.id')
                                ->orderBy('c.parent_id','asc')
                                ->orderBy('c.sort_order','asc')
                                ->get();

            $arr            =  [
                                    'id',
                                    'cat_name',
                                    'measure_unit',
                                    'parent_id',
                                    'is_show',
                                    'show_in_nav',
                                    'grade',
                                    'sort_order',
                                    'has_children',
                                ];

            //把row转化成数组
            foreach($row as $key=>$item){

                foreach($arr as $arr_item){

                    $res[$key][$arr_item]       = $item->$arr_item;

                }
            }

            /*
            //在商品表中找出所有分类下面的直接商品个数
            $sql = "SELECT id, COUNT(*) AS goods_num " .
                    " FROM " . $mwdb->table('goods') .
                    " WHERE is_delete = 0 AND is_on_sale = 1 " .
                    " GROUP BY id";
            $res2 = $mwdb->getAll($sql);
            */

            $res2       = DB::table('goods as g')
                            ->select('g.id',DB::raw('count('.$prefix.'g.id) as goods_num'))
                            ->where('g.is_delete',0)
                            ->where('g.is_on_sale',1)
                            ->groupBy('g.id')
                            ->get();


            /*
            //查找扩展分类下商品的个数
            $sql = "SELECT gc.id, COUNT(*) AS goods_num " .
                    " FROM " . $mwdb->table('goods_cat') . " AS gc , " . $mwdb->table('goods') . " AS g " .
                    " WHERE g.id = gc.goods_id AND g.is_delete = 0 AND g.is_on_sale = 1 " .
                    " GROUP BY gc.id";
            $res3 = $mwdb->getAll($sql);
            */

            $res3       = DB::table('goods_cat as gc')
                            ->leftjoin('goods as g','g.id','=','gc.goods_id')
                            ->select('gc.id',DB::raw('count('.$prefix.'gc.id) as goods_num'))
                            ->where('g.is_delete',0)
                            ->where('g.is_on_sale',1)
                            ->groupBy('gc.id')
                            ->get();




            
            //取得分类下的商品总个数 （普通分类下商品，扩展分类下商品）
            $newres = array();
            foreach($res2 as $k=>$v)
            {
                $newres[$v->id] = $v->goods_num;
                foreach($res3 as $ks=>$vs)
                {
                    if($v->id == $vs->id)
                    {
                    $newres[$v->id] = $v->goods_num + $vs->goods_num;
                    }
                }
            }
            
            //给每个分类增加一项：该分类下的商品个数
            foreach($res as $k=>$v)
            {
                $res[$k]['goods_num'] = !empty($newres[$v['id']]) ? $newres[$v['id']] : 0;
            }
        
        }


        

        if (empty($res) == true)
        {
            return $re_type ? '' : array();
        }

        

        $options = self::cat_options($id, $res); // 获得指定分类下的子分类的数组

        $children_level = 99999; //大于这个分类的将被删除
        if ($is_show_all == false)
        {
        foreach ($options as $key => $val)
        {
            if ($val['level'] > $children_level)
            {
                unset($options[$key]);
            }
            else
            {
                if ($val['is_show'] == 0)
                {
                    unset($options[$key]);
                    if ($children_level > $val['level'])
                    {
                        $children_level = $val['level']; //标记一下，这样子分类也能删除
                    }
                }
                else
                {
                    $children_level = 99999; //恢复初始值
                }
            }
        }
        }

        /* 截取到指定的缩减级别 */
        if ($level > 0)
        {
        if ($id == 0)
        {
            $end_level = $level;
        }
        else
        {
            $first_item = reset($options); // 获取第一个元素
            $end_level  = $first_item['level'] + $level;
        }

        /* 保留level小于end_level的部分 */
        foreach ($options AS $key => $val)
        {
            if ($val['level'] >= $end_level)
            {
                unset($options[$key]);
            }
        }
        }

        if ($re_type == true)
        {
        $select = '';
        foreach ($options AS $var)
        {
            $select .= '<option value="' . $var['id'] . '" ';
            $select .= ($selected == $var['id']) ? "selected='ture'" : '';
            $select .= '>';
            if ($var['level'] > 0)
            {
                $select .= str_repeat('&nbsp;', $var['level'] * 4);
            }
            $select .= htmlspecialchars(addslashes($var['cat_name']), ENT_QUOTES) . '</option>';
        }

        return $select;
        }
        else
        {
        foreach ($options AS $key => $value)
        {
            //$options[$key]['url'] = build_uri('category', array('cid' => $value['id']), $value['cat_name']);
            $options[$key]['url'] = URL::to('/category/'.$value['id']);
        }

        return $options;
        }
    }

    /**
    * 获得指定分类下的子分类的数组
    *
    * @access  public
    * @param   int     $cat_id     分类的ID
    * @param   int     $selected   当前选中分类的ID
    * @param   boolean $re_type    返回的类型: 值为真时返回下拉列表,否则返回数组
    * @param   int     $level      限定返回的级数。为0时返回所有级数
    * @param   int     $is_show_all 如果为true显示所有分类，如果为false隐藏不可见分类。
    * @return  mix
    */
    public static function cat_list($id = 0, $selected = 0, $re_type = true, $level = 0, $is_show_all = true)
    {
        
        static $res = NULL;
        if ($res === NULL)
        {

               if(Cache::has('category_list')){

                    $res        = Cache::get('category_list');
               }
               else{

                    $res     = self::get_all_category_info();
                    Cache::put('category_list',$res,3600);
               }
        }

        if (empty($res) == true)
        {
            return $re_type ? '' : array();
        }

        $options = self::cat_options($id, $res); // 获得指定分类下的子分类的数组

        $children_level = 99999; //大于这个分类的将被删除

        if ($is_show_all == false)
        {
            foreach ($options as $key => $val)
            {
                if ($val['level'] > $children_level)
                {
                    unset($options[$key]);
                }
                else
                {
                    if ($val['is_show'] == 0)
                    {
                        unset($options[$key]);
                        if ($children_level > $val['level'])
                        {
                            $children_level = $val['level']; //标记一下，这样子分类也能删除
                        }
                    }
                    else
                    {
                        $children_level = 99999; //恢复初始值
                    }
                }
            }
        }

        /* 截取到指定的缩减级别 */
        if ($level > 0)
        {
            if ($id == 0)
            {
                $end_level = $level;
            }
            else
            {
                $first_item = reset($options); // 获取第一个元素
                $end_level  = $first_item['level'] + $level;
            }

            /* 保留level小于end_level的部分 */
            foreach ($options AS $key => $val)
            {
                if ($val['level'] >= $end_level)
                {
                    unset($options[$key]);
                }
            }
        }

        if ($re_type == true)
        {
            $select = '';
            foreach ($options AS $var)
            {
                    $select .= '<option value="' . $var['id'] . '" ';
                    $select .= ($selected == $var['id']) ? "selected='ture'" : '';
                    $select .= '>';
                    if ($var['level'] > 0)
                    {
                        $select .= str_repeat('&nbsp;', $var['level'] * 4);
                    }
                    $select .= htmlspecialchars(addslashes($var['cat_name']), ENT_QUOTES) . '</option>';
            }

            return $select;
        }
        else
        {
            foreach ($options AS $key => $value)
            {
                $options[$key]['url'] = url('category/',$value['id']);
            }

            return $options;
        }
    }


    /**
     * 过滤和排序所有分类，返回一个带有缩进级别的数组
     *
     * @access  private
     * @param   int     $id     上级分类ID
     * @param   array   $arr        含有所有分类的数组
     * @param   int     $level      级别
     * @return  void
     */
     public static function cat_options($spec_id, $arr)
    {
        //定义一个静态数组
        static $cat_options = array();

        //如果定义了上级分类id 则返回以上级分类id为键值的静态数组
        if (isset($cat_options[$spec_id]))
        {
            return $cat_options[$spec_id];
        }
        

        if (!isset($cat_options[0]))
        {
            $level = $last_id = 0;
            $options = $id_array = $level_array = array();

            

            
                //如果二位数组非空
                while (!empty($arr))
                {
                    foreach ($arr AS $key => $value)
                    {
                        $id = $value['id'];
                        if ($level == 0 && $last_id == 0)
                        {   
                            //如果不为一级分类 则终止循环
                            if ($value['parent_id'] > 0)
                            {
                                break;
                            }

                            //如果是一级分类 则把数据存入数组
                            $options[$id]          = $value;
                            $options[$id]['level'] = $level;
                            $options[$id]['id']    = $id;
                            $options[$id]['name']  = $value['cat_name'];

                            //写入新数组的数据  从原来数组中删除
                            unset($arr[$key]);
                            
                            //如果没有子结点 则继续循环 不执行下面的代码
                            if ($value['has_children'] == 0)
                            {
                                continue;
                            }
                            $last_id  = $id;
                            $id_array = array($id);
                            $level_array[$last_id] = ++$level;
                            continue;
                        }

                        if ($value['parent_id'] == $last_id)
                        {
                            $options[$id]          = $value;
                            $options[$id]['level'] = $level;
                            $options[$id]['id']    = $id;
                            $options[$id]['name']  = $value['cat_name'];
                            unset($arr[$key]);

                            if ($value['has_children'] > 0)
                            {
                                if (end($id_array) != $last_id)
                                {
                                    $id_array[] = $last_id;
                                }
                                $last_id    = $id;
                                $id_array[] = $id;
                                $level_array[$last_id] = ++$level;
                            }
                        }
                        elseif ($value['parent_id'] > $last_id)
                        {
                            break;
                        }
                    }

                    $count = count($id_array);
                    if ($count > 1)
                    {
                        $last_id = array_pop($id_array);
                    }

                    elseif ($count == 1)
                    {
                        if ($last_id != end($id_array))
                        {
                            $last_id = end($id_array);
                        }
                    else
                        {
                            $level = 0;
                            $last_id = 0;
                            $id_array = array();
                            continue;
                        }
                    }

                    if ($last_id && isset($level_array[$last_id]))
                    {
                        $level = $level_array[$last_id];
                    }
                    else
                    {
                        $level = 0;
                    }
                }
                
            //
            $cat_options[0] = $options;
        }
        else
        {
            $options = $cat_options[0];
        }

        if (!$spec_id)
        {
            return $options;
        }
        else
        {
            if (empty($options[$spec_id]))
            {
                return array();
            }

            $spec_id_level = $options[$spec_id]['level'];

            foreach ($options AS $key => $value)
            {
                if ($key != $spec_id)
                {
                    unset($options[$key]);
                }
                else
                {
                    break;
                }
            }

            $spec_id_array = array();
            foreach ($options AS $key => $value)
            {
                if (($spec_id_level == $value['level'] && $value['id'] != $spec_id) ||
                    ($spec_id_level > $value['level']))
                {
                    break;
                }
                else
                {
                    $spec_id_array[$key] = $value;
                }
            }
        
            $cat_options[$spec_id] = $spec_id_array;

            return $spec_id_array;
        }
    }



    public static function get_arr(){

        $mwdb = new Mwdb();

        $sql = "SELECT c.id, c.cat_name, c.measure_unit, c.parent_id, c.is_show, c.show_in_nav, c.grade, c.sort_order, COUNT(s.id) AS has_children ".
                'FROM ' . $mwdb->table('category') . " AS c ".
                "LEFT JOIN " . $mwdb->table('category') . " AS s ON s.parent_id=c.id ".
                "GROUP BY c.id ".
                'ORDER BY c.parent_id, c.sort_order ASC';
            $res = $mwdb->getAll($sql);

        Cache::put('res',$res, 3600);
        return $res;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |    * 自定义函数 获取所有分类树
    |    *
    |    * @access  public
    |    * @param   integer     $id     分类编号
    |    * @return  array
    |
    |-------------------------------------------------------------------------------
    */

    public static function category(){

        // 获取所有一级分类
        $row = Category::where('parent_id','=',0)->get();

        foreach($row as $value){

            //获取该分类下的所有之类
            $row->child = self::category_children($value->id);
            //给一级分类设置级别数字标记 
            $row->level = 1;
        }

        //返回所有分类树对象
        return $row;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |    * 递归查询分类的所有子分类树对象
    |    *
    |    * @access  public
    |    * @param   integer     $id     分类编号
    |    * @return  array
    |
    |-------------------------------------------------------------------------------
    */

    public static function category_children($id){

        //查询分类下子类数量

        $count = Category::where('parent_id','=',$id)->count();

        if($count > 0){

            //取得当前分类下的所有子类
            $row = Category::where('parent_id','=',$id)->get();

            foreach($row as $value){

                $row->child = self::category_children($value->id);
                //$row->level = self::get_cat_level($value->id);
            }


            return $row;
        }

        return '';
    }

    

    
    /*
    |-------------------------------------------------------------------------------
    |
    |    * 返回分类商品的上级分类名称
    |
    |-------------------------------------------------------------------------------
    */

    public static function get_parent_name($id){


        if($id == 0){

            return '';
        }

        $parent_name  = '顶级分类';

        $cat         = Category::find($id);
        $parent_id   = $cat->parent_id;

        if($parent_id > 0){

            $parent_name = Category::find($parent_id)->cat_name;

        }

        return $parent_name;


    }

    /*
    |-------------------------------------------------------------------------------
    |
    |    * 判断分类是否为叶子分类
    |
    |-------------------------------------------------------------------------------
    */

    public static function is_leaf($id){

        $child  = Category::where('parent_id','=',$id)->first();

        if($child){

            return false;
        }
        else{

            return true;
        }

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |    * 判断分类下是否有商品
    |
    |-------------------------------------------------------------------------------
    */

    public static function has_goods($id){

        $goods = Goods::where('id','=', $id)->first();

        if($goods){

            return true;
        }
        else{

            return false;
        }
    }




    /*
    |-------------------------------------------------------------------------------
    |
    |    * 获取商品缩略图
    |
    |-------------------------------------------------------------------------------
    */
    public function get_goods_thumb($goods_id){

        $goods_thumb  = '';

        $goods        = \Goods::find($goods_id);

        if($goods){

            if($goods->goods_thumb){

                $goods_thumb        = $goods->goods_thumb;
            }

            else{


                    $goods_gallery  = \Goodsgallery::where('goods_id','=',$goods_id)->first();

                    if($goods_gallery){

                        $goods_thumb        = $goods_gallery->thumb_url;
                    }

            }

        }

        if($goods_thumb){

            return HTML::image($goods_thumb, '',['class'=>'thumb']);
        }

        return '';
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |    * 获取分类名称
    |
    |-------------------------------------------------------------------------------
    */
    public function get_cat_name($id){

        $cat        = \Category::find($id);

        if($cat){

            return $cat->cat_name;
        }

        return '';
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |    * 获取品牌名称
    |
    |-------------------------------------------------------------------------------
    */

    public function get_brand_name($brand_id){

        if($brand_id == 0){

            return '';
        }

        $brand      = \Brand::find($brand_id);

        if($brand){

            return $brand->brand_name;
        }

        return '';

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |    * 获取 是否显示字段
    |
    |-------------------------------------------------------------------------------
    */
    public function get_is_show($tag){

        $tag = intval($tag);

        if($tag == 1){


            return '<i class="fa fa-check"></i>';
        }
        

        return '<i class="fa fa-close"></i>';

    }


        /*
        |-------------------------------------------------------------------------------
        |
        |   获取商品的前台访问链接 如果设置了自定义链接
        |
        |-------------------------------------------------------------------------------
        */
        public function get_goods_url($goods_id){

            $preview_url        = 'goods/id/'.$goods_id;

            $goods              = \Goods::find($goods_id);
            $diy_url            = $goods->diy_url;

            if(!empty($diy_url)){

                $preview_url    = $diy_url;
            }


            return HTML::link($preview_url,'查看',['class'=>'act','target'=>'_blank']);
        }



        /*
        |-------------------------------------------------------------------------------
        |
        |   获取商品是否显示项目
        |
        |-------------------------------------------------------------------------------
        */
        public function get_is_show_tag($tag , $class_name ,$goods_id){

            $tag        = intval($tag);

            if($tag == 1){

                return '<span class="goods-tag-btn '.$class_name.'" data-goods_id="'.$goods_id.'"><i class="fa fa-check"></i></span>';
            }

                return '<span class="goods-tag-btn '.$class_name.'" data-goods_id="'.$goods_id.'"><i class="fa fa-close"></i></span>';

        }


        /*
        |-------------------------------------------------------------------------------
        |
        |   获取商品库存string
        |
        |-------------------------------------------------------------------------------
        */
        public function get_goods_input_str($tag , $tag_value , $goods_id){

            $goods          = \Goods::find($goods_id);

            if($goods)
            {


           
                $tag_value      = $goods->$tag;
                $goods_name     = $goods->goods_name;



                $str  = '<span class="'.$tag.'" id="'.$tag.'-'
                     .$goods_id.'"' 
                     .'data-goods_id="'.$goods_id.'"'
                     .'data-goods_name="'.$goods_name.'"'
                     .'>'
                     
                     .$tag_value
                     .'</span>'
                     .'<div id="'.$tag.'-content'.$goods_id.'" style="display:none;">'
                     .'<input type="text" name="'.$tag.'" id="tag_value-'.$tag.$goods_id.'" value="'.$tag_value.'">'
                     .'<span class="goods-edit-btn" id="'.$tag.'-edit-'.$goods_id.'" data-tag="'.$tag.'" data-goods_id="'.$goods_id.'">修改</span>'
                     .'</div>';

                return $str;
            }

            return '';
        }



        /*
        |-------------------------------------------------------------------------------
        |
        |   获取商品分类下的子类
        |
        |-------------------------------------------------------------------------------
        */
        function get_children($cat = 0)
        {
            
            return ' id ' . $this->db_create_in(array_unique(array_merge(array($cat), array_keys(self::cat_list($cat, 0, false)))));
        }

        /*
        |-------------------------------------------------------------------------------
        |
        |   获取商品分类编号和其所有子类编号数组
        |
        |-------------------------------------------------------------------------------
        */
        public function get_cat_array($cat = 0){

            return array_unique(array_merge(array($cat), array_keys(self::cat_list($cat, 0, false))));
        }


        /*
        |-------------------------------------------------------------------------------
        |
        |   创建类似 in(a,b)之类的sql语句
        |
        |-------------------------------------------------------------------------------
        */
        function db_create_in($item_list, $field_name = '')
        {
            if (empty($item_list))
            {
                return $field_name . " IN ('') ";
            }
            else
            {
                if (!is_array($item_list))
                {
                    $item_list = explode(',', $item_list);
                }

                $item_list = array_unique($item_list);
                $item_list_tmp = '';
                foreach ($item_list AS $item)
                {
                    if ($item !== '')
                    {
                        $item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
                    }
                }
                if (empty($item_list_tmp))
                {
                    return $field_name . " IN ('') ";
                }
                else
                {
                    return $field_name . ' IN (' . $item_list_tmp . ') ';
                }
            }
        }




        /*
        |-------------------------------------------------------------------------------
        |
        |   获取订单中商品列表
        |
        |-------------------------------------------------------------------------------
        */
        public function get_order_goods($order_id){


            $row            = \OrderGoods::where('order_id',$order_id)->get();

            foreach($row as $item){

                $item['xj']         = $item->goods_price * $item->goods_number;
            }

            return $row;
        }



        /*
        |-------------------------------------------------------------------------------
        |
        |   获取所有商品分类 并统计该分类下子类的数量
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_all_category_array(){

            $prefix = Config::get('database.connections.mysql.prefix');
            //拼接数据表category 找出所有分类 并统计该分类下的直接子类
            $row            = DB::table('category as c')
                                ->leftjoin('category as s','s.parent_id','=','c.id')
                                ->select('c.*',DB::raw('count('.$prefix.'s.id) as has_children'))
                                ->groupBy('c.id')
                                ->orderBy('c.parent_id','asc')
                                ->orderBy('c.sort_order','asc')
                                ->get();
            
            $arr            =  [
                                    'id',
                                    'cat_name',
                                    'measure_unit',
                                    'parent_id',
                                    'is_show',
                                    'is_nav',
                                    'grade',
                                    'sort_order',
                                    'has_children',
                                ];
            $res            = [];

            foreach($row as $k=>$v){
                foreach($arr as $item){

                    $res[$k][$item]           = $v->$item;
                }
            }

            return $res;
        }



        /*
        |-------------------------------------------------------------------------------
        |
        |   获取商品分类的直接商品编号数量
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_cat_goods_num_list(){

            $prefix = Config::get('database.connections.mysql.prefix');
            $res            = DB::table('goods as g')
                                ->select('g.cat_id',DB::raw('count('.$prefix.'g.id) as goods_num'))
                                ->where('g.is_delete',0)
                                ->where('g.is_on_sale',1)
                                ->groupBy('g.cat_id')
                                ->get();
            return $res;
        }


        /*
        |-------------------------------------------------------------------------------
        |
        |   获取扩展分类下商品数量
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_other_cat_goods_num_list(){


            $prefix         = Config::get('database.connections.mysql.prefix');

            $res            = DB::table('goods_cat as gc')
                                ->leftjoin('goods as g','gc.goods_id','=','g.id')
                                ->select('gc.cat_id',DB::raw('count('.$prefix.'gc.goods_id) as goods_num'))
                                ->where('g.is_delete',0)
                                ->where('g.is_on_sale',1)
                                ->groupBy('gc.cat_id')
                                ->get();
            return $res;


        }

        /*
        |-------------------------------------------------------------------------------
        |
        |   获取所有商品分类 包括：该分类下的直接子类 和该分类下的商品数量
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_all_category_info(){

            //获取所有的商品分类 并统计该分类下的直接子类数量
                $res            = self::get_all_category_array();

                //获取每个商品分类下的直接商品编号数量
                $res2           = self::get_cat_goods_num_list();
                //获取扩展分类下商品数量的个数
                $res3           = self::get_other_cat_goods_num_list();

                $newres         = [];

                //把扩展分类和普通分类上的商品编号数量都统计上
                foreach($res2 as $k=>$v)
                {
                    $newres[$v->cat_id] = $v->goods_num;

                    foreach($res3 as $ks=>$vs)
                    {
                        if($v->cat_id == $vs->cat_id)
                        {
                            $newres[$v->cat_id] = $v->goods_num + $vs->goods_num;
                        }
                    }
                }

                foreach($res as $k=>$v)
                {
                    $res[$k]['goods_num'] = !empty($newres[$v['id']]) ? $newres[$v['id']] : 0;
                }

                return $res;
        }
}


