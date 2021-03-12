@if(count($articles)>0)
    @foreach($articles as $article)
        <div class="post-preview">
            <a href="{{route('single',[$article->getCategory->slug,$article->slug])}}">
                <h2 class="post-title">
                    {{$article->title}}
                </h2>
                <img src="{{$article->image}}" width="750" height="350" alt="">
                <h3 class="post-subtitle">
                    {!! Str::limit($article->content,75) !!}
                </h3>
            </a>
            <p class="post-meta"> Kategori :
                <a href="#">{{$article->getCategory->name}}</a>
                <span class="float-right">{{$article->created_at->diffForHumans()}}</span>
            </p>
        </div>
        @if(!$loop->last)
            <hr>
        @endif

    @endforeach
@else
    <div class="alert alert-danger">Bu kategoriye ilişkin bir post bulunamadı.</div>
@endif

<div class="d-flex justify-content-center">
    {!! $articles->links() !!}
</div>
