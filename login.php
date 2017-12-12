 

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Login Form</title>
 <style>
 @import '../../shared/mixins',
        '../../shared/reset',
        '../../shared/about-light';

/*
 * Copyright (c) 2012-2013 Thibaut Courouble
 * http://www.cssflow.com
 *
 * Licensed under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 */

body {
  font: 13px/20px 'Lucida Grande', Tahoma, Verdana, sans-serif;
  color: #404040;
  background: #0ca3d2;
}

.container {
  margin: 80px auto;
  width: 640px;
}

.login {
  position: relative;
  margin: 0 auto;
  padding: 20px 20px 20px;
  width: 310px;
  background: white;
  border-radius: 3px;
  @include box-shadow(0 0 200px rgba(white, .5), 0 1px 2px rgba(black, .3));

  &:before {
    content: '';
    position: absolute;
    top: -8px; right: -8px; bottom: -8px; left: -8px;
    z-index: -1;
    background: rgba(black, .08);
    border-radius: 4px;
  }

  h1 {
    margin: -20px -20px 21px;
    line-height: 40px;
    font-size: 15px;
    font-weight: bold;
    color: #555;
    text-align: center;
    text-shadow: 0 1px white;
    background: #f3f3f3;
    border-bottom: 1px solid #cfcfcf;
    border-radius: 3px 3px 0 0;
    @include linear-gradient(top, whiteffd, #eef2f5);
    @include box-shadow(0 1px #f5f5f5);
  }

  p { margin: 20px 0 0; }
  p:first-child { margin-top: 0; }

  input[type=text], input[type=password] { width: 278px; }

  p.remember_me {
    float: left;
    line-height: 31px;

    label {
      font-size: 12px;
      color: #777;
      cursor: pointer;
    }

    input {
      position: relative;
      bottom: 1px;
      margin-right: 4px;
      vertical-align: middle;
    }
  }

  p.submit { text-align: right; }
}

.login-help {
  margin: 20px 0;
  font-size: 11px;
  color: white;
  text-align: center;
  text-shadow: 0 1px #2a85a1;

  a {
    color: #cce7fa;
    text-decoration: none;

    &:hover { text-decoration: underline; }
  }
}

:-moz-placeholder {
  color: #c9c9c9 !important;
  font-size: 13px;
}

::-webkit-input-placeholder {
  color: #ccc;
  font-size: 13px;
}

input {
  font-family: 'Lucida Grande', Tahoma, Verdana, sans-serif;
  font-size: 14px;
}

input[type=text], input[type=password] {
  margin: 5px;
  padding: 0 10px;
  width: 200px;
  height: 34px;
  color: #404040;
  background: white;
  border: 1px solid;
  border-color: #c4c4c4 #d1d1d1 #d4d4d4;
  border-radius: 2px;
  outline: 5px solid #eff4f7;
  -moz-outline-radius: 3px; // Can we get this on WebKit please?
  @include box-shadow(inset 0 1px 3px rgba(black, .12));

  &:focus {
    border-color: #7dc9e2;
    outline-color: #dceefc;
    outline-offset: 0; // WebKit sets this to -1 by default
  }
}

input[type=submit] {
  padding: 0 18px;
  height: 29px;
  font-size: 12px;
  font-weight: bold;
  color: #527881;
  text-shadow: 0 1px #e3f1f1;
  background: #cde5ef;
  border: 1px solid;
  border-color: #b4ccce #b3c0c8 #9eb9c2;
  border-radius: 16px;
  outline: 0;
  @include box-sizing(content-box); // Firefox sets this to border-box by default
  @include linear-gradient(top, #edf5f8, #cde5ef);
  @include box-shadow(inset 0 1px white, 0 1px 2px rgba(black, .15));

  &:active {
    background: #cde5ef;
    border-color: #9eb9c2 #b3c0c8 #b4ccce;
    @include box-shadow(inset 0 0 3px rgba(black, .2));
  }
}
p.submit {
    text-align: right;
}
label {
    /* min-width: 200px; */
    display: block;
}
.lt-ie9 {
  input[type=text], input[type=password] { line-height: 34px; }
}</style>
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
  <section class="container">
    <div class="login">
      <h1>Login </h1>
      <form method="post" action="<?php $_SERVER['DOCUMENT_ROOT'];?>index.php?c=Utilisateur&a=login">
        <p><label>Utilisateur</label><input type="text" name="login" value="" placeholder="Nom d'utilisateur"></p>
        <p><label>Mot de passe</label><input type="password" name="password" value="" placeholder="Mots de passe"></p>
        <p class="remember_me" style="color:red">
          <?php 
		  if(isset($_GET["error"]))
		  {
			  echo 'Login ou password incorrect';
			  
			 // header("location:login.php");
		  }
		  ?>
        </p>
        <p class="submit"><input type="submit" name="commit" value="Connecter"></p>
      </form>
    </div>

    
  </section>

  
</body>
</html>