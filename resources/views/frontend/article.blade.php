@extends('layouts.layout') <!-- Lecture 5  -->

@section('title', 'Отдых и жильё в Крыму - 2020 г. ')

@section('description', 'Отдых и жильё в Крыму - 2020 г. Аренда жилья без по средников. Цена от собственника. Без комиссии')
@section('content') <!-- Lecture 5  -->
<div class="container">

    <h1>Article <small>about: <a href="{{ route('object',['id'=>$article->object->id]/* Lecture 22 */) }}">{{ $article->object->name /* Lecture 22 */ }}</a> object</small></h1>
    <p>{{ $article->content /* Lecture 22 */ }}</p>


    <a class="btn btn-primary top-buffer" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        Article is liked <span class="badge">{{ $article->users->count() /* Lecture 22 */ }}</span>
    </a>
    <div class="collapse" id="collapseExample">
        <div class="well">

            <ul class="list-inline">
            @foreach( $article->users as $user ) <!-- Lecture 22 -->
                <li><a href="{{ route('person',['id'=>$user->id]/* Lecture 22 */) }}"><img title="{{ $user->FullName /* Lecture 22 */ }}" class="media-object img-responsive" width="50" height="50" src="{{ $user->photos->first()->path ?? $placeholder /* Lecture 22 */ }}" alt="..."> </a></li>

            @endforeach <!-- Lecture 22 -->
            </ul>


        </div>
    </div>

    <h3>Comments</h3>

@foreach( $article->comments as $comment ) <!-- Lecture 22 -->
    <div class="media">
        <div class="media-left media-top">
            <a href="{{ route('person',['id'=>$comment->user->id]/* Lecture 22 */) }}">
                <img class="media-object" width="50" height="50" src="{{ $comment->user->photos->first()->path ?? $placeholder /* Lecture 22 */ }}" alt="...">
            </a>
        </div>
        <div class="media-body">
            {{ $comment->content /* Lecture 22 */ }}
        </div>
    </div>
    <hr>
@endforeach <!-- Lecture 22 -->

    <!-- Lecture 24 -->
    @auth

        @if( $article->isLiked() )
            <a href="{{ route('unlike',['id'=>$article->id,'type'=>'App\Article']) }}" class="btn btn-primary btn-xs top-buffer">Unlike this article</a>
        @else
            <a href="{{ route('like',['id'=>$article->id,'type'=>'App\Article']) }}" class="btn btn-primary btn-xs top-buffer">Like this article</a>
        @endif

    @else

        <p><a href="{{ route('login') }}">Login to like this article</a></p>

    @endauth


    <br><br>

    <!-- Lecture 25 -->
    @auth
        <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2">
            Add comment
        </a>
    @else
        <p><a href="{{ route('login') }}">Login to add a comment</a></p>
    @endauth


    <div class="collapse" id="collapseExample2">
        <div class="well">


            <form method="POST" action="{{ route('addComment',['article_id'=>$article->id, 'App\Article']) /* Lecture 25 */ }}" class="form-horizontal">
                <fieldset>

                    <div class="form-group">
                        <label for="textArea" class="col-lg-2 control-label">Comment</label>
                        <div class="col-lg-10">
                            <textarea required name="content" class="form-control" rows="3" id="textArea"></textarea>
                            <span class="help-block">Add a comment about this article.</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </fieldset>
            {{ csrf_field() }} <!-- Lecture 25 -->
            </form>

        </div>
    </div>


</div>
@endsection <!-- Lecture 5  -->



