<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rublik</title>
    <link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,400i,700&amp;subset=cyrillic" rel="stylesheet">
    <link href="{{ mix('css/all.css') }}" rel="stylesheet">
    <!-- <link href="{{ mix('css/app.css') }}" rel="stylesheet"> -->
    
</head>
<body>
<div id="app">
    <app :user="'{{ json_encode($user) }}'"></app>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
