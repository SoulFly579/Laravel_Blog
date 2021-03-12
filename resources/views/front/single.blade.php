@extends('front.layouts.master')
@section('title',$article->title)
@section('bg',$article->image)
@section('content')

<!-- Post Content -->
            <div class="col-md-9 mx-auto">
                {!! $article->content !!}
                <span class="float-right"><br/><br/><b>Okunma sayısı:</b>{{$article->hit}}</span>
            </div>

@include('front.widgets.categoryWidgets')

<hr>

@endsection
