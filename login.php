<?php
include ("config/config.php");
session_start();

try {
    $databaseConnection = new PDO('mysql:host=localhost;dbname=stock', 'root', '');
    $databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}


if(isset($_POST['submit'])){
    $errMsg = '';
    //username and password sent from Form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if($username == '')
        $errMsg .= 'veuillez entrez votre identifiant<br>';

    if($password == '')
        $errMsg .= 'veuillez entrez votre mot de passe<br>';


    if($errMsg == '')
    {
        $records = $databaseConnection->prepare('SELECT * FROM  users WHERE name = :username LIMIT 1');
        $records->bindParam(':username', $username);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);
        if(count($results) > 0 && $password==$results['password'])
        {
            $_SESSION['login'] = $results['name'];
            $_SESSION['user_id']= $results['id'];
            $_SESSION['fonction'] = $results['fonction'];
            header('location:'.$url."/home");
            exit;
        }else{
            $errMsg .= 'veuillez entrez les bonnes informations<br>';
        }
    }

}



?>
<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="UTF-8">
    <title>login form</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="dist/css/style1.css">

    <style>
        /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */
        * {
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        body {
            background: #333;
            font: 100%/1 "Helvetica Neue", Arial, sans-serif;
        }

        .login {
            position: absolute;
            top: 50%;
            left: 50%;
            margin: -10rem 0 0 -10rem;
            width: 20rem;
            height: 20rem;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            overflow: hidden;
        }
        .login:hover > .login-header, .login.focused > .login-header {
            width: 2rem;
        }
        .login:hover > .login-header > .text, .login.focused > .login-header > .text {
            font-size: 1rem;
            transform: rotate(-90deg);
        }
        .login.loading > .login-header {
            width: 20rem;
        }
        .login.loading > .login-header > .text {
            display: none;
        }
        .login.loading > .login-header > .loader {
            display: block;
        }

        .login-header {
            position: absolute;
            left: 0;
            top: 0;
            z-index: 1;
            width: 20rem;
            height: 20rem;
            background: #30c9ff;
            transition: width 0.5s ease-in-out;
        }
        .login-header > .text {
            display: block;
            width: 100%;
            height: 100%;
            font-size: 5rem;
            text-align: center;
            line-height: 20rem;
            color: #fff;
            transition: all 0.5s ease-in-out;
        }
        .login-header > .loader {
            display: none;
            position: absolute;
            left: 5rem;
            top: 5rem;
            width: 10rem;
            height: 10rem;
            border: 2px solid #fff;
            border-radius: 50%;
            animation: loading 2s linear infinite;
        }
        .login-header > .loader:after {
            content: "";
            position: absolute;
            left: 4.5rem;
            top: -0.5rem;
            width: 1rem;
            height: 1rem;
            background: #fff;
            border-radius: 50%;
            border-right: 2px solid orange;
        }
        .login-header > .loader:before {
            content: "";
            position: absolute;
            left: 4rem;
            top: -0.5rem;
            width: 0;
            height: 0;
            border-right: 1rem solid #fff;
            border-top: 0.5rem solid transparent;
            border-bottom: 0.5rem solid transparent;
        }
        h1{ text-align: center;
            background-color: #3d8fd8;

        }

        @keyframes loading {
            50% {
                opacity: 0.5;
            }
            100% {
                transform: rotate(360deg);
            }
        }
        .login-form {
            margin: 0 0 0 2rem;
            padding: 0.5rem;
        }

        .login-input {
            display: block;
            width: 100%;
            font-size: 2rem;
            padding: 0.5rem 1rem;
            box-shadow: none;
            border-color: #ccc;
            border-width: 0 0 2px 0;
        }
        .login-input + .login-input {
            margin: 10px 0 0;
        }
        .login-input:focus {
            outline: none;
            border-bottom-color: orange;
        }

        .login-btn {
            position: absolute;
            right: 1rem;
            bottom: 1rem;
            width: 5rem;
            height: 5rem;
            border: none;
            background: orange;
            border-radius: 50%;
            font-size: 0;
            border: 0.6rem solid transparent;
            transition: all 0.3s ease-in-out;
        }
        .login-btn:after {
            content: "";
            position: absolute;
            left: 1rem;
            top: 0.8rem;
            width: 0;
            height: 0;
            border-left: 2.4rem solid #fff;
            border-top: 1.2rem solid transparent;
            border-bottom: 1.2rem solid transparent;
            transition: border 0.3s ease-in-out 0s;
        }
        .login-btn:hover, .login-btn:focus, .login-btn:active {
            background: #fff;
            border-color: orange;
            outline: none;
        }
        .login-btn:hover:after, .login-btn:focus:after, .login-btn:active:after {
            border-left-color: orange;
        }

    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>



</head>
<body>
<div class="login">
    <h1><img src="<?php echo $url;?>/dist/img/logo-website_new.png" alt="logo_opentech"/> </h1>
    <header class="login-header"><span class="text">LOGIN</span><span class="loader"></span></header>
    <form class="login-form" method="post" action="">
        <p class="remember_me" style="color:red">

            <?php
            if (isset($_GET["error"])) : ?>
        <div style = "color:red;">Erreur de connexion</div>
        <?php endif; ?>
        <?php
        if(isset($errMsg)){
            echo '<div style="color:#FF0000;text-align:center;font-size:15px;">'.$errMsg.'</div>';
        }
        ?>
        </p>
        <input class="login-input" required type="text" name="username" placeholder="Username"/>
        <input class="login-input" required type="password" name="password" placeholder="Password"/>
        <button class="login-btn" type="submit" name="submit">login</button>
    </form>
</div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script  src="dist/index.js"></script>


</body>
</html>