@extends('back.layouts.master')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><strong>{{$articles->count()}} Makale Bulunudu.</strong>
                <a href="{{route('admin.trashed.article')}}" class="float-right btn btn-warning btn-sm"><i class="fa fa-trash"></i> Silinen Makaleler</a>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Makale Fotoğrafı</th>
                        <th>Makale Başlığı</th>
                        <th>Kategori</th>
                        <th>Hit</th>
                        <th>Oluşturulma Tarihi</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articles as $article)
                    <tr>
                        <td>
                            <img src="{{$article->image}}" width="200" height="100" alt="">
                        </td>
                        <td>{{$article->title}}</td>
                        <td>{{$article->getCategory->name}}</td>
                        <td>{{$article->hit}}</td>
                        <td>{{$article->created_at->diffForHumans()}}</td>
                        <td><input type="checkbox" article-id="{{$article->id}}" @if($article->status==1) checked @endif class="switch" data-offstyle="danger" data-onstyle="success" data-toggle="toggle" data-on="Aktif" data-off="Pasif"></td>
                        <td>
                            <a target="_blank" href="{{route('single',[$article->getCategory->slug,$article->slug])}}" title="Görüntüle" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                            <a href="{{route('admin.makaleler.edit',$article->id)}}" title="Düzenle" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i></a>
                            <a href="{{route('admin.deletearticle',$article->id)}}" title="Sil" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('js')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
        $(function() {
            $('.switch').change(function() {
                id = $(this)[0].getAttribute('article-id');
                statu = $(this).prop('checked');
                $.get("{{route('admin.switch')}}",{id:id,statu:statu});
            })
        })
    </script>
@endsection
