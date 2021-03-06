<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
  -->

<?php
session_start();

$emailErr = $passwordErr = "";
$someErr = False;
$email = $password = $hashedPass = $passwordGiven = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $someErr = True;
    }
    else {
        $email = ($_POST["email"]);
        $db = pg_connect("host=ec2-54-163-255-1.compute-1.amazonaws.com port=5432 dbname=d78258r6re094d user=jseqocrbelozuq password=ac7f8466905190ad89da55ed63559f6b09331b96164ac16cfcd27ea02af30536");
        $password_query = 'SELECT password FROM user_database WHERE email = $1';
        $email_result = pg_query_params($db, 'SELECT password FROM user_database WHERE email = $1', array($_POST["email"]));
        $rows = pg_num_rows($email_result);
        if ($rows > 0) {
            $row2 = pg_fetch_row($email_result);
            $hashedPass = $row2[0];
            $email = ($_POST["email"]);
        }
        else {
            $emailErr = "That email is not in use";
            $someErr = True;
        }
        if (empty($_POST["password"])) {
            $passwordErr = "Password is required";
            $someErr = True;
        } else {
            $passwordGiven = $_POST["password"];
        }
    }
    if (!$someErr) {
        // assert that the two passwords are the same
        if (password_verify($passwordGiven, $hashedPass)) {
            //Start cookie here***
            $_SESSION["user_email"] = $email; //keep track of user email for database requests
            header("Location: https://simple-eggs.herokuapp.com/site/member_page.php");
            exit();
        }
        else {
            $someErr = True;
            $passwordErr = "Incorrect password given";
        }
    }
}
?>



<html>
	<head>
		<title>SimplEggs - Log In</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<div id="main">
						<div class="inner">

							<!-- Header -->
								<header id="header">
									<a href="index.php" class="logo"><img src="images/SimplEggs_Logo.png" alt="SimplEggs" style="height:35px;width:auto;"> by Kieran Heese, Nick Newton, and Zane Alpher</a>
									<ul class="icons">
										<li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
										<li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
										<li><a href="#" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
									</ul>
								</header>

							<!-- Content -->
								<section>
									<header class="main">
										<h1>Log In</h1>
                                        <?php //check to see if already logged in -> add link to member page
                                        if (isset($_SESSION['user_email'])) {
                                            echo "<p style='font-size:70%;'>You are already logged in as " . $_SESSION['user_email'] . ". To access the member page please use <a href=member_page.php>this link</a> or <a href=logout.php>log out</a>.</p>";
                                        }
                                        ?>
									</header>

									<form method="post" action="login.php">
									  <div class="row gtr-uniform">
									    <div class="col-6 col-12-xsmall">
									      <input type="text" name="email" id="email" value="" placeholder="Email" />
									       <?php if ($someErr) {
										echo "
										<p style='font-size:70%;color:red;'>$emailErr</p>";
														    }
														    ?>
									    </div>
									    <div class="col-6 col-12-xsmall">
									      <input type="password" name="password" id="password" value="" placeholder="Password" />
									      <?php if ($someErr) {
									       echo "
									       <p style='font-size:70%;color:red;'>$passwordErr</p>";
									       }
									       ?>
									    </div>
									    <!-- Break -->
									    <div class="col-12">
									      <ul class="actions">
										<li><input type="submit" value="Log In" class="primary" /></li>
										<li><input type="reset" value="Reset" /></li>
									      </ul>
									    </div>
									  </div>
									</form>
								</section>
								<!-- maybe keep this -->
								<span class="image object" style="align:center">
								  <img src="images/eggs_1.jpg" alt="" style="width:70%;"/>
								</span>
						</div>
					</div>

			<!-- Sidebar -->
					<div id="sidebar">
					  <div class="inner">

					    <!-- Search -->
					    <section id="search" class="alt">
					      <form method="post" action="#">
						<input type="text" name="query" id="query" placeholder="Search" />
					      </form>
					    </section>

					    <!-- Menu -->
					    <nav id="menu">
					      <header class="major">
						<h2>Menu</h2>
					      </header>
					      <ul>
						<li><a href="index.php">Homepage</a></li>
						<li><a href="login.php">Log In</a></li>
						<li><a href="sign_up.php">Sign Up</a></li>
						<li><a href="products.php">Products</a></li>
						<li><a href="about_us.php">About Us</a></li>
						<li><a href="contact_us.php">Contact Us</a></li>	
					      </ul>
					    </nav>

					    <!-- Section -->
					    <section>
					      <header class="major">
						<h2>Articles</h2>
					      </header>
					      <div class="mini-posts">
						<article>
						  <a href="https://www.nytimes.com/2009/08/04/business/04chickens.html" class="image"><img src="images/nyt_chickens.jpg" alt="" /></a>
						  <h2>Keeping Their Eggs in Backyard Nests</h2>
						  <p>As layoffs increase, Americans are seeking a self-sustained food option for when the bills can't be paid. - <i> New York Times </i></p>
						</article>
						<article>
						  <a href="https://www.cdc.gov/salmonella/backyardpoultry-05-19/index.html" class="image"><img src="images/backyard_chicken_1.jpg" alt="" /></a>
						  <h2>Don't Kiss Your Chickens!</h2>
						  <p>Outbreaks of Salmonella infections linked to backyard poultry - <i> Center for Disease Control </i></p>
						</article>
					    </section>
					    </div>
					  </div>

					</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>
