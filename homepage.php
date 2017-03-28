<?php
     session_start();
     if(isset($_SESSION['username'])){ //Redirects to a site depending on what type of user logged in
          if ($_SESSION['userType_id'] == 1)
               header("location: views/admin_site");
          else if ($_SESSION['userType_id'] == 2)
               header("location: views/warehouse_site");
          else if ($_SESSION['userType_id'] == 3)
               header("location: views/services_site");
          else if ($_SESSION['userType_id'] == 4)
               header("location: views/manager_site");
          else if ($_SESSION['userType_id'] == 5)
               header("location: views/serviceView_site");
          else if ($_SESSION['userType_id'] == 6)
               header("location: views/warehouseView_site");                 
     }
?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>Nichiyu Asialift</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/nichiyu.ico">
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="assets/css/homepage.css" />
    <style>
     #loginForm .modal-header {
          /*background-color: #5cb85c;*/
          /*color: #fff;*/
          font-weight: bold;
          text-align: center;
     }    
    </style>       
  </head>
  <body>
<!--      <button class="btn btn-success btn" data-toggle-tooltip="tooltip" data-placement="top" title="" data-toggle="modal" data-target="#addNewItem">
      <span class="glyphicon glyphicon-plus"></span> New Item
    </button> -->

    <!-- Header -->
      <header id="header">
        <nav class="left">
          <a href="#menu"><span>Menu</span></a>
        </nav>
        <a href="index.html" class="logo"><img src="images/nichiyu.png" style="padding-top: 12px; max-height=100%; "></a>
        <nav class="right">
          <a class="button alt" data-toggle-tooltip="tooltip" data-placement="top" title="" data-toggle="modal" data-target="#loginForm">Log in</a>
        </nav>
      </header>
<!-- <button class="btn btn-success btn-md" data-toggle-tooltip="tooltip" data-placement="top" title="" data-toggle="modal" data-target="#loginForm">
                          <span class="glyphicon glyphicon-user"></span>&nbsp; New user
                        </button>   -->
    <!-- Menu -->
      <nav id="menu">
        <ul class="links">
          <li><a href="index.php">Home</a></li>
          <li><a href="#two">About Us</a></li>
          <li><a href="#footer">Contact Us</a></li>
        </ul>
        <ul class="actions vertical">
          <li><a href="login-form.php" class="button fit">Login</a></li>
        </ul>
      </nav>

    <!-- Banner -->
      <section id="banner">
        <div class="content">
          <h1>Nichiyu Asialift Philippines Inc.</h1>
          <p style="color: #fff;">The market leader for battery forklifts in Japan, China, and Southeast Asia. <br/>Producing quality products using high technologies and research and development expertise.</p>
          <ul class="actions">
            <li><a href="#two" class="button scrolly">ABOUT US</a></li>
          </ul>
        </div>
      </section>

    <!-- Two -->
      <section id="two" class="wrapper style1">
        <div class="inner">
          <header class="align-center">
            <h1>About Us</h1>
            <p>A dependable truck that can be operated indoors or outdoors, in almost any weather</p>
          </header>
          <div class="image fit">
            <!-- <img src="images/pic05.jpg" alt="" /> -->
          </div>
          <p>Nichiyu is the pioneer in battery forklifts. Since developing the first battery forklift in Japan in 1937, we have spent more than 60 years refining and marketing a succession of outstanding models, each of which is capable of solving a particular loading or unloading issue.</p>

          <p>As a manufacturer specializing in battery forklifts, we take pride in offering user oriented products that ensure unmatched customer satisfaction.</p>

          <p>Today, Nichiyu is proud of having garnered a leading share of the markets in Japan, China and Southeast Asia. Demand for battery forklifts is increasing worldwide in light of growing interest in environmental issues. In the future, we will remain committed to developing products designed with the customer in mind while responding to the needs of the environment. Through this approach, we will contribute greatly to the efficiency of our customers' businesses and contribute to the needs of environmental preservation around the world.</p>
        </div>
      </section>

    <!-- Three -->
      <section id="three" class="wrapper">
        <div class="inner flex flex-3">
          <div class="flex-item box">
            <div class="image fit">
              <!-- <img src="images/pic02.jpg" alt="" /> -->
            </div>
            <div class="content">
              <h3>An Appealing Design with Well-Rounded Features</h3>
              <p>Featuring exception comfort and advanced functions. This new design encompasses all the elements necessary to maximize overall safety, durability, and the versatility to handle any work environment.</p>
            </div>
          </div>
          <div class="flex-item box">
            <div class="image fit">
              <!-- <img src="images/pic03.jpg" alt="" /> -->
            </div>
            <div class="content">
              <h3>A Full Range of Customer Services</h3>
              <p>Nichiyu has highly trained service staff in every country in which we sell our products. Should you experience a sudden malfunction or problem, simply contact us and our service staff will quickly visit wherever needed in order to provide the required service.</p>
            </div>
          </div>
          <div class="flex-item box">
            <div class="image fit">
              <!-- <img src="images/pic04.jpg" alt="" /> -->
            </div>
            <div class="content">
              <h3>Satisfying Customer Transactions</h3>
              <p>We try to keep our company system and procedureas simole as possible although we utilize most modern tools and equipments available. All our service vehicles and senior service technicians are equipped with mobile phones for convenient monitoring.</p>
            </div>
          </div>
        </div>
      </section>

    <!-- Footer -->
      <footer id="footer">
        <div class="inner">
          <h2>Get In Touch</h2>
          <ul class="actions">
<!--             <li><span class="icon fa-phone"></span> <a href="#">(000) 000-0000</a></li>
            <li><span class="icon fa-envelope"></span> <a href="#">information@untitled.tld</a></li>
            <li><span class="icon fa-map-marker"></span> 123 Somewhere Road, Nashville, TN 00000</li> -->
          </ul>
        </div>
        <div class="copyright">
          &copy; CODEX Developers Group
        </div>
      </footer>


    <!-- Scripts -->
      <script src="assets/js/jquery-1.10.2.js"></script>
      <script src="assets/js/bootstrap.min.js"></script>
      <script src="assets/js/jquery.scrolly.min.js"></script>
      <script src="assets/js/skel.min.js"></script>
      <script src="assets/js/util.js"></script>
      <script src="assets/js/homepage.js"></script>
      <script src="assets/js/jquery-1.10.2.js"></script>

  </body>
</html>
    <!--  ADD NEW USER -->
    <div class="modal fade" id="loginForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <form role="form" class="form-horizontal" action="login.php" method="post">
              <div class="modal-body">
            <h4 class="modal-title" id="exampleModalLabel">Login Form</h4><br>
                <div class="row">
                   <div class="col-sm-2">                    
                   </div>            
                   <div class="col-sm-8">
                        <div class="form-group">
                          <label for="recipient-name" class="">Username:</label>
                          <input type="text" class="form-control" name="username" id="username" autocomplete="off" required autofocus>
                        </div>
                        <div class="form-group">
                          <label for="message-text" class="">Password:</label>
                          <input type="password" class="form-control" name="password" id="password" placeholder="●●●●●●●●●●" autocomplete="off" required>
                        </div>
                   </div>
                   <div class="col-sm-2">                    
                   </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-primary">Login</button>
              </div>
          </form>
        </div>
      </div>
    </div>   