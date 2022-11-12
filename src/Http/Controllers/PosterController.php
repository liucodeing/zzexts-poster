<?php

namespace Zzexts\Poster\Http\Controllers;

use Carbon\Carbon;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Zzexts\Poster\Models\Poster;

class PosterController extends Controller
{

    public function index(Content $content)
    {
        $content->body($this->grid());
        return $content->header('海报')->description('列表');
    }

    protected function grid()
    {
        $grid = new Grid(new Poster());
        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', __('ID'));
        $grid->logo_src('主图')->lightbox(['width' => 50, 'height' => 50]);
        $grid->column('sort', __('优先'))->editable();
        $states = [
            'on' => ['value' => null, 'text' => '启用', 'color' => 'success'],
            'off' => ['value' => Carbon::now()->toDateTimeString(), 'text' => '禁用', 'color' => 'danger'],
        ];
        $grid->disabled_at('状态')->switch($states);
//        $grid->column('created_at', __('创建时间'));
        $grid->disableExport();
        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->append('<div class="btn-group  " style="margin:  0px 10px"><a href="' . route('poster.edit', ['id' => $actions->row->id]) . '" class="btn btn-sm btn-default" title="主图更换"><span class="hidden-xs"> 主图更换</span></a></div>');
            $actions->append('<div class="btn-group  " style="margin:  0px 10px"><a href="' . route('poster.design', ['id' => $actions->row->id]) . '" class="btn btn-sm btn-default" title="效果设计"><span class="hidden-xs"> 效果设计</span></a></div>');
        });
        $grid->disableFilter();

        $grid->disableRowSelector();
        //大图动态加载
        $script = <<<SCRIPT
$('.grid-popup-link').magnificPopup({
"type":"image",
"gallery":{
    "enabled":true,
    "preload":[0,2],
    "navigateByImgClick":true,
    "arrowMarkup":"<button title=\"%title%\" type=\"button\" class=\"mfp-arrow mfp-arrow-%dir%\"><\/button>",
    "tPrev":"Previous (Left arrow key)",
    "tNext":"Next (Right arrow key)",
    "tCounter":"<span class=\"mfp-counter\">%curr% of %total%<\/span>"
    },
"mainClass":"mfp-with-zoom",
"zoom":{"enabled":true,"duration":300,"easing":"ease-in-out"}
});
$('.show_img_box').click(function(){
    var objImg=$(this).next().find('img')
    objImg.attr('src', objImg.data('src'))
    $(this).next().show()
    $(this).hide()
    objImg.parent().click()
});
SCRIPT;
        Admin::script($script);
        return $grid;
    }

    public function create(Content $content)
    {
        $content->body($this->form());
        return $content->header('海报')->description('主图更换');
    }

    public function edit($id = null, Content $content)
    {
        $content->body($this->form($id)->edit($id));
        return $content->header('海报')->description('主图更换');
    }

    protected function form($id = null)
    {
        $form = new Form(new Poster());
        $form->image('logo_src', __('主图'))->help("请上传模板图片;图片大小请控制在10M以内;长宽尺寸控制在1000px以内")->required();
        $form->number('sort', __('优先级'))->default(0)->help("优先级按照数值升序排列");
        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
            $footer->disableReset();
        });

        $form->setAction($id ? route('poster.update', ['id' => $id]) : route('poster.store'));
        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
            $tools->disableDelete();
//            $tools->disableList();
        });
        return $form;
    }

    public function store($id = null, Request $request)
    {

        $data = $request->all();
        (int)$poster_id = $id ?? 0;
        $poster = Poster::query()->find($poster_id);

        $image_url = null;
        if ($request->file('logo_src')) {
            list($file_result, $file_msg) = file_size_limit_check($request->file('logo_src'));
            if (!$file_result) {
                admin_error('编辑失败', $file_msg);
                return redirect()->back();
            }
            $image_src = Storage::disk(config('zzexts-poster.filesystem_driver'))->put('share', $request->file('logo_src'));
            $image_url = Storage::disk(config('zzexts-poster.filesystem_driver'))->url($image_src);
            if (!$image_url) {
                admin_error('编辑失败', '图片上传失败');
                return redirect()->back();
            }
        }
        if (!$poster) {
            $poster = new Poster();
        }

        $poster->logo_src = $image_url;
        $poster->sort = $data['sort'];
        $result = $poster->save();
        if (!$result) {
            admin_error('添加失败', '添加模板图片失败');
            return redirect()->back();
        }
        admin_toastr('添加成功', 'success', ['timeOut' => 3000]);
        return Redirect::route('poster.index');
    }

    /**
     * 效果设计
     * @param $id
     * @param Content $content
     * @return Content
     */
    public function design($id, Content $content)
    {

        $request_url = route('poster.design_get', ['id' => $id]);
        return $content
            ->title('海报')
            ->description('效果设计')
            ->body(view('poster::design', ['id' => $id, 'request_url' => $request_url]));
    }

    /**
     * 获取数据
     */
    public function design_get($id, Request $request)
    {
        (int)$poster_id = $id;
        $poster = Poster::query()->find($poster_id);
        if (!$poster) {
            return $this->returnJson(1, '找不到要设计的效果！', []);
        }

        $data['bg'] = $poster->logo_src;
        $data['arr'] = [];
        $path = json_decode($poster->path, true);
        if (isset($path['arr'])) {
            foreach ($path['arr'] as $path_item) {
                if (isset($path_item['editKey']) && $path_item['editKey'] == "jg-logo") {
                    if ($path_item['img']) {
                        $imagedetails = getimagesize($path_item['img']);
                        $path_item["height"] = $path_item["width"] / $imagedetails[0] * $imagedetails[1];
                    }
                }
                if ($path_item['type'] == 'text') {
                    if ($path_item['lineHeight'] % 2) {
                        $path_item['lineHeight'] += 1;
                    }
                    if ($path_item['letterSpacing'] % 2) {
                        $path_item['letterSpacing'] += 1;
                    }
                }
                $data['arr'][] = $path_item;
            }
        }

        $data['typefont'] = [];

        // 二维码图片地址 ,不能没有
        $data['configure']['cy-code']["path"] = config('zzexts-poster.qrcode_example_url');
        if ($data['configure']['cy-code']["path"]) {
            list($width, $height, $type, $attr) = getimagesize($data['configure']['cy-code']["path"]);
            $data['configure']['cy-code']["width"] = $width;
            $data['configure']['cy-code']["height"] = $height;
        }
        return $this->returnJson(0, '', ['data' => $data]);
    }

    /**
     * 保存设计数据
     * @param $id
     * @param Request $request
     */
    public function design_store($id, Request $request)
    {
        (int)$poster_id = $id;
        $poster = Poster::query()->find($poster_id);
        if (!$poster) {
            return $this->returnJson(1, '找不到要设计的效果！', []);
        }

        $data = $request->input('template_data', '');
        $path = json_decode($data, true);

        if (!isset($path['bg'])) {
            return $this->returnJson(1, '无效的效果设计！', []);
        }

        $poster->mix_src = '';
        $poster->path = json_encode($path);
        $poster->save();
        return $this->returnJson(0, '保存成功', []);
    }

    // 返回json数据
    public function returnJson($err, $msg, $data)
    {
        return compact('err', 'msg', 'data');
        //['err'=>1,'msg'=>'提示信息','data'=>['id'=>1]]
    }
}
