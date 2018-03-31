<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        
        'search',
        'admin/color/img-del',//后台删除属性图片
        'admin/goods/image/redo',//批量处理商品图片尺寸
        'category-ajax',//商品分类页ajax排序
        'ajax-buy',//商品页 立即购买+立即加入购物车
        'ajax-tag',//ajax添加标签
        'admin/product/ajax',//货品ajax
        'front/product/ajax',//前台货品查询
        'auth/captcha-check',//ajax检测验证码
        'auth/register-check',//ajax检测用户重名
        'captcha-ajax',//刷新验证码
        'cart-ajax-mobile',//购物车ajax操作,
        'demo',//查看演示
        'api/*',//api接口相关
        'cart-checked',//购物车更新商品是否被选中
        'cart-checked-all',//购物车全部取消或者被选中
        'admin/goods/*',//后台管理商品相关的ajax
        'cart-number-update',//购物车数量更新
        'admin/theme-json',//系统所有权限
        'admin/theme-add',//添加主题
        'admin/theme-delete',//删除主题
        'admin/theme-default',//设置默认主题
        'admin/goods-attr-delete',//删除商品的属性值
        'cart-json',//前台获取购物车信息
        'cart-delete',//删除购物车
    ];
}
