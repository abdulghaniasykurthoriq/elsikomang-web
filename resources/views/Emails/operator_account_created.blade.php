<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Akun Operator Anda</title>
</head>
<body>
    <h2>Halo {{ $name }},</h2>
    <p>Akun operator Anda telah berhasil dibuat dengan rincian sebagai berikut:</p>

    <ul>
        <li>Email: {{ $email }}</li>
        <li>Password: {{ $password }}</li>
        <li>Role: Operator {{ $role }}</li>
    </ul>

    <p>Silakan login ke sistem dan segera ubah password Anda.</p>

    <br><br>
    <p>Terima kasih.</p>
</body>
</html>



