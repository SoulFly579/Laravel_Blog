@extends('back.layouts.master')
@section('title',$article->title.' Makalesini Güncelle')
@section('css')
@endsection
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
        </div>
        <div class="card-body">
            <form action="{{route('admin.makaleler.update',$article->id)}}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label>Makale Başlığı</label>
                    <input type="text" name="title" class="form-control" value="{{$article->title}}" required>
                </div>
                <div class="form-group">
                    <label>Makale Kategorisi</label>
                    <select name="category" class="form-control" required>
                        <option value="">Seçim Yapınız</option>
                        @foreach($categories as $category)
                            <option @if($article->category_id == $category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <label>Makale Resmi</label> <br>
                <img src="{{asset($article->image)}}" width="200" height=""> <br><br>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" name="image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Makale Başlığı</label>
                    <textarea name="content" id="editor" cols="30" rows="10" >{!! $article->content !!}</textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block" type="submit">Makaleyi Oluştur</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'editor' );
    </script>
@endsection
