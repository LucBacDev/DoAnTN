<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Change password</h1>
    <a href="{{route('user.reset-password',['gmail'=>$user->email,'token'=>$user->forgot_token])}}" style="padding: 10px; background-color: green color:blue">Click here to change password</a>
</body>
</html>