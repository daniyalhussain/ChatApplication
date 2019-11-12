<!doctype html>
<html lang="en">
  <head>
    <title>Chat Application by Daniyal Hussain</title>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="developer" content="Daniyal Hussain">

    <!-- Main css -->
    <link href="assets/css/main.css" rel="stylesheet">
    <!-- Google Font-->
    <link href="http://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>

  <?php
    // Setup Session
    @session_start();

    $_SESSION["user"] = isset($_GET['user']) ? $_GET['user'] : $_SESSION["user"];
  ?>

  <body>
    <?php include 'parts/_header.php' ?>

    <!-- Content -->
        <div id="app"></div>
    <!-- End Content -->

    <?php include 'parts/_footer.php' ?>
    <script type="text/javascript" src="javascript/assets/bundle/main.bundle.js"></script>
  </body>
</html>