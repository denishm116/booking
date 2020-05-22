
@extends('layouts.backend') <!-- Lecture 5 -->

@section('content') <!-- Lecture 5 -->
<h1>Курорты крыма <small><a class="btn btn-success" href="#" data-type="button"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Добавить курорт </a></small></h1>

<div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th>Название</th>
            <th>Правка / Удалить</th>
        </tr>
        <?php for($i=1;$i<=10;$i++): ?>
        <tr>
            <td>Paris</td>
            <td>
                <a href=""><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                <a onclick="return confirm('Вы уверены?');" href=""><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
            </td>
        </tr>
        <?php endfor; ?>
    </table>
</div>



<h1>Create / edit new city</h1>
<form method="POST" action="#">
    <h3>Name * </h3>
    <input class="form-control" type="text" required name="name"><br>
    <button class="btn btn-primary" type="submit">Create</button>
</form>
@endsection <!-- Lecture 5 -->








