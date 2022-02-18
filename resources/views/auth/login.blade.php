<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        @csrf
        @if ($errors->has('username'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('username') }}</strong>
        </span>
        @endif
        <table>
            <tr>
                <td>email:</td>
                <td><input type="text" name="email" id=""></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password" id=""></td>
            </tr>
            <tr>
            <td colspan="2" align="center">Remember me<input type="checkbox" name="remember" id=""></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" value="Login"></td>
            </tr>
        </table>
        </form>

</body>
</html>
