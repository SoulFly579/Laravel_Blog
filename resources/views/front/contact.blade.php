@extends('front.layouts.master')
@section('title','İletişim')
@section('bg','https://images.unsplash.com/photo-1485770958101-9dd7e4ea6d93?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2089&q=80')
@section('content')
        <div class="col-md-4">
            <div class="card-header">
                <div class="card-body">
                    ADDRESS: BLA BLA
                </div>
            </div>
        </div>
        <div class=" col-md-8 ">
            @if(session('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <p>Bizimle iletişime geçebilirsiniz.</p>
            <form method="post" action="{{route('contact_post')}}">
                @csrf
                <div class="control-group">
                    <div class="form-group controls">
                        <label>Ad Soyad</label>
                        <input type="text" class="form-control" value="{{old('name')}}" placeholder="Adınız ve Soyadınız" name="name"  >
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-group controls">
                        <label>Email Adresi</label>
                        <input type="email" class="form-control"  value="{{old('email')}}" placeholder="Email Adresiniz" name="email"  >
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-group col-xs-12 controls">
                        <label>Konu</label>
                        <select name="topic" class="form-control">
                            <option @if(old('topic')=='Bilgi') selected @endif>Bilgi</option>
                            <option @if(old('topic')=='Destek') selected @endif>Destek</option>
                            <option @if(old('topic')=='Genel') selected @endif>Genel</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-group controls">
                        <label>Mesajınız</label>
                        <textarea rows="5" class="form-control" placeholder="Mesajınız"  name="message" >{{old('message')}}</textarea>
                    </div>
                </div>
                <br>
                <div id="success"></div>
                <button type="submit" class="btn btn-primary" id="sendMessageButton">Send</button>
            </form>
        </div>


<hr>

@endsection
