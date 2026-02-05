<?php
$message ="";

if (isset($_post['login']))

    {

 $username = $_post('username');
        $password = $_post('password');

        // user login pass//
        if ($username === "admn" && $password === "123")
        {

         header{"localtion: utama.php"};
         exit();

}
 else
{

    $message = "username atau password salah!"

}

}

    }
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>login</title>
    </head>
    <body>
        <H2>form login serhana</H2>
        <p style="color:red;"><?php echo $message ?></p>
        <form
    </body>
    </html>
    