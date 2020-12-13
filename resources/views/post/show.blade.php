@extends('post.layout')
@section('title')
    <h1>{{$post->title}}</h1>
@endsection
@section('content')
    <a href="{{ route('posts.edit', ['post'=>$post->id]) }}">Edit Post</a>

    <div class="blog-post">
    <p>{{$post->body}}</p>
</div><!-- /.blog-post -->

<hr>
<ul class="list-group">
    @foreach($post->comments as $comment)
        <li class="list-group-item">
            <strong> {{\Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}</strong>
            {{$comment->comment}}
        </li>
    @endforeach
</ul>

<nav class="blog-pagination">
    <a class="btn btn-outline-primary" href="#">Older</a>
    <a class="btn btn-outline-secondary disabled" href="#">Newer</a>
</nav>
@endsection
