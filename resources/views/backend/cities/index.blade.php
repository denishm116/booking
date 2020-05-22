
@extends('layouts.backend')
@section('content')
    <h1>Курорты крыма  <small><a class="btn btn-success" href="{{ route('cities.create')  }}" data-type="button"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Добавить курорт </a></small></h1>

    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <tr>
                <th>Название</th>
                <th>Правка / Удалить</th>
            </tr>
        @foreach( $cities as $city )
            <tr>
                <td>{{ $city->name   }}</td>
                <td>
                    <a href="{{ route('cities.edit',['id'=>$city->id]) }}"><i class="far fa-edit"></i></a>


                    <form style="display: inline;" method="POST" action="{{ route('cities.destroy',['id'=>$city->id]) }}">
                        {{--<button onclick="return confirm('НИ В КОЕМ СЛУЧАЕ');" class="btn  btn-xs" type="submit"><i class="fas fa-ban"></i></button>--}}
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                    </form>

                </td>
            </tr>
        @endforeach
        </table>
    </div>

@endsection








