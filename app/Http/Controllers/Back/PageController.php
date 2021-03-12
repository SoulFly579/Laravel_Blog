<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index(){
        $pages = Page::orderBy('id','DESC')->get();
        return view('back.pages.index', compact('pages'));
    }

    public function create(){
        return view('back.pages.create');
    }
    public function edit($id){
        $page = Page::findOrFail($id);
        return view('back.pages.update',compact('page'));
    }
    public function switch(Request $request){
        $page = Page::findOrFail($request->id);
        $page->status = $request->statu=='true' ? 1 : 0;
        $page->save();
    }
    public function editPost(Request $request){
        $page = Page::findOrFail($request->id);
        $page->title = $request->title;
        $page->content = $request->content;
        $page->slug = Str::slug($request->title);

        if($request->hasFile('image')){
            $imageName = Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $page->image = '/uploads/'.$imageName;
        }
        $page->save();
        toastr()->success('Sayfa başarıyla güncellendi.','Success');
        return redirect()->route('admin.page.index');
    }
    public function delete($id){
        $page = Page::findOrFail($id);
        if($page_image_path = public_path().$page->image){
            unlink($page_image_path);
        }
        $page->delete();
        toastr()->success('Sayfa başarıyla silindi.');
        return redirect()->route('admin.page.index');
    }

    public function post(Request $request){
        $last = Page::orderBy('order','DESC')->first();
        $page = new Page;
        $page->title = $request->title;
        $page->order = $last->order+1;
        $page->content = $request->content;
        $page->slug = Str::slug($request->title);

        if($request->hasFile('image')){
            $imageName = Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $page->image = '/uploads/'.$imageName;
        }
        $page->save();
        toastr()->success('Sayfa başarıyla oluşturuldu.','Success');
        return redirect()->route('admin.page.index');
    }
}
