@extends('post.layout')
@section('title')
<h1>المقالات</h1>
@endsection
@section('content')
    @if(count($posts))

@foreach($posts as $post)
<div class="blog-post">
    <h2 class="blog-post-title">{{$post->title}}</h2>
    <p class="blog-post-meta">{{\Carbon\Carbon::parse($post->created_at)->diffForHumans()}} by <a href="#">{{$post->user->name}}</a></p>
    {{$post->excerpt}}
{{--    //في حال استخدام الطريقة الاولى من ملف المسارات لعرض المقال نستخدم هذه الطريقة--}}
{{--    <a href="/posts/{{$post->id}} "> المزيد </a>--}}
{{--    //في حال استخدام الطريقة الثانية من ملف المسارات لعرض المقال بالاسم نستخدم هذه الطريقة--}}
    <a href="{{ route('posts.show', $post->id) }}">المزيد</a>

</div><!-- /.blog-post -->
@endforeach
    @else
        <h1>لا توجد مقالات</h1>
    @endif

<nav class="blog-pagination">
    <a class="btn btn-outline-primary" href="#">Older</a>
    <a class="btn btn-outline-secondary disabled" href="#">Newer</a>
</nav>
@endsection
