<?php   
    include "credentials.php";
    include "config.php";
?>
<head>
    <title>Blog Login</title>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
</head>
<div class="container">
    <form method="post" action="logincheck.php">
        <input type=text name="user" placeholder="Username">
        <input type="password" name="pass" placeholder="Password">
        <input type="submit" name="login" class="btn" value="Log in">
    </form>

            <form method="post">
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="password" placeholder="Password">
                <input type="email" name="email" placeholder="Epost">
                <input type="text" name="name" placeholder="Name">
                <input type="text" name="website" placeholder="Website">
                <input type="submit" name="reg" class="btn" value="Send">
            </form>
                <?php
                    if( isset($_POST["reg"]) ) {

                        if( !empty($_POST["username"]) && !empty($_POST["password"] ) ) {
                            $nohash = strip_tags($_POST["password"]);
                            $up = password_hash($nohash, PASSWORD_DEFAULT);
                            // Strip tags and post to database
                            $un = strip_tags($_POST["username"]);
                            $email = strip_tags($_POST["email"]);
                            $name = strip_tags($_POST["name"]);
                            $website = strip_tags($_POST["website"]);

                            // Steg 1: Upprätta en databas-anslutning
                            $conn = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            } 
                            $query = "INSERT INTO blog_members(username, password, email, name, website)
                            VALUES ('$un', '$up', '$email', '$name','$website')";

                            // Steg 3: Kör frågan mot databasen och gör en insättning
                            mysqli_query($conn, $query);
                            if ($conn->query($query) === TRUE) {
                                echo "<h2>Du har registrerats! Logga In ovan!</h2>";
                            } else {
                                echo "Error: " . $query . "<br>" . $conn->error;
                            }
                        }
                    }
                ?>
</div>