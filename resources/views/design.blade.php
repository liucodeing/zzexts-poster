<style type="text/css">
    .page-iframe {
        width: 100%;
        height: 100vh;
        border: none;
    }
</style>
<iframe src="{{asset('vendor/zzexts/poster')}}/index.html?template_id={{$id??0}}"
        class="page-iframe"></iframe>
<script>
    $('.page-iframe').parent().removeClass('col-sm-8');
    document.getElementsByClassName('page-iframe')[0].focus()

    // 保存成功后调用
    window.goBack = function () {
        location.href = '{{route('poster.index')}}';
    }

    // 数据
    window.template_id = {{$id??0}};
    window.request_url = '{{$request_url??''}}';
    window.posterData = function () {
        let Da = {};


        return Da;
    }

</script>
