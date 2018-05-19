@extends('layouts.admin')
@section('content')
<div class="x-body">
    <form class="layui-form">

        <div class="layui-form-item">
            <label for="username" class="layui-form-label">
                <span class="x-red">*</span>标题
            </label>
            <div class="layui-input-block">
                <input type="text" name="title" required="" value="{{$data->title}}" autocomplete="off" class="layui-input">
            </div>
        </div>
        {{csrf_field()}}
        <input type="hidden" name="_method" value="put">
        <input type="hidden" name="id" value="{{$data->id}}">
        <div class="layui-form-item">
            <label for="phone" class="layui-form-label">
                <span class="x-red">*</span>链接
            </label>
            <div class="layui-input-block">
                <input type="text" name="url" required="" value="{{$data->url}}" autocomplete="off" class="layui-input">
            </div>
        </div>

        <input type="hidden" name="smallimg" id="mpicture">
        <div class="layui-form-item">
            <label for="phone" class="layui-form-label">
                <span class="x-red">*</span>图片
            </label>
            <div class="layui-upload-drag" id="test10">
                <img width="100px" height="100px" id="loadimg" @if ($data->smallimg == '')style="display:none;"@endif>
                <i class="layui-icon" id="icon"></i>
                <p id="notic">点击上传，或将文件拖拽到此处</p>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="phone" class="layui-form-label">
                <span class="x-red">*</span>发布者
            </label>
            <div class="layui-input-block">
                <input type="text" name="author" value="{{$data->author}}" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_pass" class="layui-form-label">
                <span class="x-red">*</span>简介
            </label>
            <div class="layui-input-block">
                <textarea placeholder="请输入内容" class="layui-textarea" name="description">{{$data->description}}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button  class="layui-btn" lay-filter="add" lay-submit="">
                更新
            </button>
        </div>

    </form>
</div>
<script>
layui.use(['form','layer','upload'], function(){
    $ = layui.jquery;
    var form = layui.form
    ,layer = layui.layer
    ,upload = layui.upload;

    //拖拽上传
    upload.render({
        elem: '#test10'
        ,url: '{{url("admin/upload")}}'
        ,data: {'timestamp' : '<?php echo time();?>',
                '_token'    : "{{csrf_token()}}",
                'name'      : "music"
            }
        ,field: "upfile"
        ,done: function(res){
            //如果上传失败
            if(res.code !=  200){
                return layer.msg(res.msg);
            }else {
                //上传成功
                $('#mpicture').val(res.msg);
                $('#icon').hide();
                $('#notic').hide();
                $('#loadimg').show();
                $('#loadimg').attr('src',res.msg);

            }
        }
    });

    //监听提交
    form.on('submit(add)', function(data){
        //发异步，把数据提交给php
        $.post("{{url('admin/music/'.$data->id)}}",data.field,function(res){

    		if(res.code == 200){
                layer.alert(res.msg, {icon: 6},function () {
                    // 获得frame索引
                    var index = parent.layer.getFrameIndex(window.name);
                    //关闭当前frame
                    parent.layer.close(index);
                });
            }else{
    			layer.msg(res.msg, {time: 2000});
    		}
        },'json');

        return false;
    });
});
</script>
@endsection
