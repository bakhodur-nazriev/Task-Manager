<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Our Application</title>
</head>
<body>
    <h1>Welcome to Our Application</h1>
    <p>Thank you for registering. Here are your login details:</p>
    <p><strong>Login:</strong> {{ $login }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>
    <p>Please click the link below to verify your email address:</p>
    <a href="{{ route('verification.notice') }}">Verify Email</a>
</body>
</html>
