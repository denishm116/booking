@component('mail::message')
    # Добрый день
    Пришла заявка на замер мебели.<br>
    Имя: {{$request->name}}
    Адрес: {{$request->address}}
    Телефон: {{$request->phone}}
    Комментарий: {{$request->comment}}

    @component('mail::panel')
        This is the panel content.
    @endcomponent

    @component('mail::table')
        | Laravel       | Table         | Example  |
        | :------------ |:-------------:| --------:|
        | Col 2 is      | Centered      | $10      |
        | Col 3 is      | Right-Aligned | $20      |
    @endcomponent

    Желаем удачи,<br>
    {{ config('app.name') }}

    @component('mail::button', ['url' => ''])
        Перейти на сайт
    @endcomponent

@endcomponent