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
    <iframe src="http://www.free-kassa.ru/merchant/forms.php?gen_form=1&m=107399&default-sum=100&button-text=Оплатить&type=v3&id=252710"  width="590" height="320" frameBorder="0" target="_parent" ></iframe>
    <form method='get' action='http://www.free-kassa.ru/merchant/cash.php'>
        <input type='hidden' name='m' value='{{$merchant_id}}'>
        <input type='hidden' name='oa' value='{{$order_amount}}'>
        <input type='hidden' name='o' value='{{$order_id}}'>
        <input type='hidden' name='s' value='{{$sign}}'>
        <input type='hidden' name='i' value='160'>
        <input type='hidden' name='lang' value='ru'>
        <input type='hidden' name='us_login' value='{{$login}}'>
        <input type='submit' name='pay' value='Оплатить'>
    </form>
</div>
</body>
</html>
