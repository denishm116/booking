@extends('layouts.layout') <!-- Lecture 5  -->

@section('title', 'Отдых и жильё в Крыму - 2020 г. ')

@section('description', 'Отдых и жильё в Крыму - 2020 г. Аренда жилья без по средников. Цена от собственника. Без комиссии')
@section('content') <!-- Lecture 5  -->
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">

                        <div class="col-xs-12 col-sm-3">
                            <img src="{{ $user->photos->first()->path ?? $placeholder /* Lecture 23 */ }}" alt="" class="img-circle img-responsive">
                        </div>
                        <div class="col-xs-12 col-sm-9">
                            <h2>{{ $user->FullName }}</h2>

                        </div>


                        <div class="col-sm-12 top-buffer">
                            <button class="btn btn-success btn-block"><span class="fa fa-plus-circle"></span> {{ $user->objects->count() /* Lecture 23 */ }} liked objects </button>
                            <ul class="list-group">

                            @foreach( $user->objects as $object ) <!-- Lecture 23 -->
                                <li class="list-group-item">
                                    <a href="{{ route('object',['id'=>$object->id]) }}<?php /* Lecture 23 */?>">  {{ $object->name }}</a>

                                </li>
                            @endforeach <!-- Lecture 23 -->

                            </ul>
                        </div>
                        <div class="col-sm-12">
                            <button class="btn btn-info btn-block"><span class="fa fa-user"></span> {{ $user->larticles->count() /* Lecture 23 */ }} liked articles </button>
                            <ul class="list-group">

                            @foreach( $user->larticles as $article ) <!-- Lecture 23 -->
                                <li class="list-group-item">
                                    <a href="{{ route('article',['id'=>$article->id]) }}<?php /* Lecture 23 */?>">  {{ $article->title }}</a>

                                </li>
                            @endforeach <!-- Lecture 23 -->

                            </ul>
                        </div>
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-primary btn-block"><span class="fa fa-gear"></span> {{ $user->comments->count() /* Lecture 23 */ }} Comments </button>
                            <ul class="list-group">

                            @foreach( $user->comments as $comment ) <!-- Lecture 23 -->
                                <li class="list-group-item">

                                {{ $comment->content }} <!-- Lecture 23 -->

                                    <a href="{{ $comment->commentable->link /* Lecture 23 */ }}">{{ $comment->commentable->type /* Lecture 23 */ }}</a>

                                </li>
                            @endforeach <!-- Lecture 23 -->

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection <!-- Lecture 5  -->






