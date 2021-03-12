@extends('back.layouts.master')
@section('title','Tüm Kategoriler')
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Yeni Kategori Oluştur</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('admin.category.create')}}">
                        @csrf
                        <div class="form-group">
                            <label> Kategori Adı</label>
                            <input type="text" class="form-control" name="category" required>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block ">Ekle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Kategori ID</th>
                                <th>Kategori Adı</th>
                                <th>Makale Sayısı</th>
                                <th>Durum</th>
                                <th>İşlemler</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{$category->id}}</td>
                                    <td>{{$category->name}}</td>
                                    <td>{{$category->articleCount()}}</td>
                                    <td><input type="checkbox" category-id="{{$category->id}}" @if($category->status==1) checked @endif class="switch " data-offstyle="danger" data-onstyle="success" data-toggle="toggle" data-on="Aktif" data-off="Pasif"></td>
                                    <td>
                                        <a category-id="{{$category->id}}" class="btn btn-sm btn-primary edit-click" title="Kategoriyi Düzenle"><i class="fa fa-edit"></i></a>
                                        <a category-id="{{$category->id}}" category-name="{{$category->name}}" category-count="{{$category->articleCount()}}" class="btn btn-sm btn-danger remove-click" title="Kategoriyi Sil"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
        <!-- Modal -->
        <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Kategoriyi Düzenle</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('admin.category.update')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Kategori Adı:</label>
                                <input id="category" type="text" class="form-control" name="category">
                                <input id="category_id" type="hidden" name="id">
                            </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Modal -->
    <div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Kategoriyi Düzenle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="alert alert-danger" id="articleAlert">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                        <form action="{{route('admin.category.delete')}}" method="post">
                            @csrf
                            <input type="hidden" id="delete_id" name="delete_id">
                            <button type="submit" class="btn btn-primary" id="sil">Sil</button>
                        </form>
                    </div>
                </div>
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
            $('.edit-click').click(function () {
                id = $(this)[0].getAttribute('category-id');
                $.ajax({
                    type:'GET',
                    url:"{{route('admin.category.getdata')}}",
                    data:{id:id},
                    success:function (data) {
                        console.log(data);
                        $('#category').val(data.name);
                        $('#category_id').val(data.id);
                        $('#EditModal').modal();
                    }
                });
            });
            $('.remove-click').click(function () {
                id = $(this)[0].getAttribute('category-id');
                count = $(this)[0].getAttribute('category-count');
                name = $(this)[0].getAttribute('category-name');

                if(id==1){
                    $('#articleAlert').html('<strong> '+name+'</strong>'+' adlı kategori silinemez.');
                    $('#sil').hide();
                    $('#DeleteModal').modal();
                    return;
                }
                    $('#sil').show();
                    $('#delete_id').val(id);
                    $('#articleAlert').html('');
                    if (count > 0) {
                        $('#articleAlert').html('Bu kategoriye ait ' + '<strong> ' + count + '</strong>' + ' makale bulunmaktadır. Yine de ' + '<strong> ' + name + '</strong>' + ' adlı kategoriyi silmek istediğinize emin misiniz ? ');
                    } else {
                        $('#articleAlert').html('<strong> ' + name + '</strong>' + ' adlı kategoriyi silmek istiyor musunuz ?');
                    }

                $('#DeleteModal').modal();

            });
            $('.switch').change(function() {
                id = $(this)[0].getAttribute('category-id');
                statu = $(this).prop('checked');
                $.get("{{route('admin.category.switch')}}",{id:id,statu:statu});
            });
            })
    </script>
@endsection

