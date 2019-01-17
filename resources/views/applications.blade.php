<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rublik</title>
    <link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,400i,700&amp;subset=cyrillic" rel="stylesheet">
</head>
<body>
<div id="app">
    <table border="1">
        <caption>Таблица заказов</caption>
        <tr>
            <th>#</th>
            <th>purse</th>
            <th>desc</th>
            <th>currency</th>
            <th>user name</th>
            <th>status</th>
            <th>action</th>
        </tr>
        @foreach ($applications as $application)
            <tr>
                <td>{{$application->id}}</td>
                <td>{{$application->purse}}</td>
                <td>{{$application->desc}}</td>
                <td>{{$application->currency}}</td>
                <td>{{$application->user->first_name}} {{$application->user->last_name}}</td>
                <td>
                    @if ($application->status)
                        Выведена
                    @else
                        Новая
                    @endif
                </td>
                <td><a href="http://rublik.money/applications/{{$application->id}}"></a></td>
            </tr>
        @endforeach
    </table>

</div>
</body>
</html>
