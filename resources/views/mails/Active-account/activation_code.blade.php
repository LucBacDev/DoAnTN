<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Your account activation code is</h1>
    <h2>{{$token}}</h2>
    <a href="{{route('user.activation',['gmail'=>$user->email])}}" style="padding: 10px; background-color: green color:blue">Click here to activate your account</a>
</body>
</html>