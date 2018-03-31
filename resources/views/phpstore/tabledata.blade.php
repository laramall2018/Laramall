@extends('phpstore.layout.common')
@section('title')
{!!$title!!}
@stop

@section('description')
{!!$description!!}
@stop

@section('keywords')
{!!$keywords!!}
@stop

@section('appname')
{!!$appname!!}
@stop


@section('content')
	
    <div class="content">
    	
        <h2>phpstore搜索ajax grid模块</h2>
    	<p>系统ajax搜索排序分页显示表格grid组件 有三个组件组成</p>
        <p>TableData类:痛过页面递交的搜索条件 输出相应的数据结果</p>
        <p>{!!HTML::image('/static/img/tabledata-hand.png','tabledata手绘稿')!!}</p>
        <p>{!!HTML::image('/static/img/tabledata.png','tabledata类')!!}</p>
        <p>keywords 搜索关键字 属于 like搜索</p>
        <p>sort_name / sort_value  记录点击排序的对值</p>
        <p>fieldRow 里面记录了等于一组条件数组值 这里是完全匹配搜索数组</p>
        <p>table为相应的数据表</p>
        <p>col:对应数据表中要显示的字段 以及用于格式化的别名</p>
        <p>page分页类：根据给定的四个参数 输出分页结果:current_page ,last_page , per_page ,total</p>
        <p>whereIn搜索 类似商品分类 比如：cat_id 不光要搜索该分类下商品 还要搜索该分类下子类商品</p>
        <p>data属性 用于记录：格式化输出结果</p>
        <p>total:系统总记录数 给page类做参数</p>
        <p>toArray():根据所有搜索条件输出搜索结果</p>
        <p>toArray()给的数据结果 通过函数 getData来格式化</p>
        <p>可视化下刚才的搜索过程</p>
        <p>{!!HTML::image('/static/img/tabelist.png','显示表格')!!}</p>
        
        
    
    </div>
@stop