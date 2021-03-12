<?php

namespace App\Http\Controllers\Back;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('back.categories.index',compact('categories'));
    }

    public function switch(Request $request){
        $category = Category::findOrFail($request->id);
        $category->status = $request->statu=="true" ? 1:0;
        $category->save();
    }

    public function create(Request $request){
        $isExists = Category::where('slug', Str::slug($request->category))->first();
        if($isExists){
            toastr()->error($request->category.' adında bir kategoryi zaten mevcut!');
            return redirect()->back();
        }

        $category = new Category;
        $category->name = $request->category;
        $category->slug = Str::slug($request->category);
        $category->save();
        toastr()->success('Kategori başarıyla oluşturuldu.');
        return redirect()->back();
    }

    public function getdata(Request $request){
        $category = Category::findOrFail($request->id);
        return response()->json($category);
    }

    public function update(Request $request){
        $isExists = Category::where('slug', Str::slug($request->category))->whereNotIn('id',[$request->id])->first();
        if($isExists){
            toastr()->error($request->category.' adında bir kategoryi zaten mevcut!');
            return redirect()->back();
        }
        $category = Category::find($request->id);
        $category->name = $request->category;
        $category->slug = Str::slug($request->category);
        $category->save();
        toastr()->success('Kategori başarıyla güncellendi.');
        return redirect()->back();
    }

    public function delete(Request $request){
        $category = Category::findOrFail($request->delete_id);
        if($category->id == 1 ){
            toastr()->error('Bu kategori silinemez.');
            return redirect()->back();
        }
        $count = $category->articleCount();
        $name = $category->name;
        if($count>0){
            Article::where('category_id',$category->id)->update(['category_id'=>1]);
            toastr()->success('Kategori başarıyla silindi',$name.' kategorisine ait makaleler GENEl kategorisine aktarıldı');
        }
        $category->delete();
        toastr()->success('Kategori başarıyla silindi');
        return redirect()->back();
    }
}
