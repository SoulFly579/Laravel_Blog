<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Carbon\Traits\Test;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;
use App\Models\Page;
use App\Models\Contact;
use Validator;

class Homepage extends Controller
{
    public function __construct()
    {
        view()->share('pages',Page::orderBy('order','ASC')->get());
        view()->share('categories',Category::inRandomOrder()->get());
    }

    public function index(){
        $data['articles'] = Article::orderBy('id','DESC')->paginate(2);
        $data['categories']= Category::inRandomOrder()->get(); // if u want random and limited add ->take(2)
        return view('front.homepage',$data);
    }

    public function single($category,$slug){
        $category=Category::whereSlug($category)->first() ?? abort(403,'Böyle bir kategori yok.');
        $article = Article::where('slug',$slug)->where('category_id',$category->id)->first() ?? abort(403,'Böyle bir kategori bulunamadı...');
        $article->increment('hit');
        $data['article'] = $article;
        return view('front.single',$data);
    }
    public function category($slug){
        $category=Category::whereSlug($slug)->first() ?? abort(403,'Böyle bir kategori bulunamadı.');
        $data['category'] = $category;
        $data['articles']=Article::where('category_id',$category->id)->orderBy('id','DESC')->paginate(2) ?? abort(403,'Böyle bir makele yok.');
        return view('front.category',$data);
    }
    public function page($slug){
        $page = Page::where('slug',$slug)->first() ?? abort(403,'Böyle bir sayfa bulunamadı.');
        $data['page']=$page;
        return view('front.page',$data);
    }
    public function contact(){
        return view('front.contact');
    }
    public function contact_post(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5',
            'email'=>'required|email:rfc,dns',
            'topic'=>'required',
            'message'=>'required|min:10',
        ]);

        if($validator->fails()){
            return redirect()->route('contact')->withErrors($validator)->withInput();
        }

        $contact = new Contact;
        $contact->name=$request->name;
        $contact->email=$request->email;
        $contact->topic=$request->topic;
        $contact->message=$request->message;
        $contact->save();
        return redirect()->route('contact')->with('success','İletişim mesajınız bize iletildi.En kısa sürede geri dönüş yapılacaktır.');
    }
}
