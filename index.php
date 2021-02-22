<?php

$amount = $coin = $usd = $ngn = '';
if (isset($_GET['amount']) && isset($_GET['coin'])) {
    // if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    $coin = $_POST['coin'];
    if ($coin == 'bitcoin') {
        $usd = 57380.840 * $amount;
        $ngn =     25821378 * $amount;
    }
    if ($coin == 'ethereum') {
        $usd = 1962.880 * $amount;
        $ngn = 883296 * $amount;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Stock Broker - provide the easy responsive free website templates. You can easily customize and make your own website for your startup business.">
    <meta name="keywords" content="bootstrap template, Responsive Template, Website Template, free website templates, free website template download ">
    <title>PerryPay</title>
    <!-- Bootstrap -->
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- animsition css -->
    <link rel="stylesheet" type="text/css" href="css/animsition.min.css">
    <!-- Font Awesome CSS -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <!-- font css -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <!-- owl Carousel Css -->
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.theme.css" rel="stylesheet">
    <!-- Theme Css -->
    <link rel="stylesheet" href="css/theme.css">
</head>

<body class="animsition">
    <div class="intro-section">
        <!-- intro section -->
        <div class="top-header">
            <!-- top heder -->
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-5  hidden-xs">
                        <p>Welcome to our broker agency website.</p>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-7 hidden-xs">
                        <div class="pull-right">
                            <span class="top-link"><i class="fa fa-phone"></i> +234 1112223344</span>
                            <span class="top-link"><i class="fa fa-envelope"></i> info@perrypay.com</span>
                            <span class="navigation-search top-link">
                                <a href="#"><i class="fa fa-search"></i></a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.top header -->
        <!-- navigation-transparent -->
        <div class="header">
            <!-- navigation -->
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <a class="logo" href="index.html">PerryPay</a>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <div id="navigation" class="navigation">
                            <ul class="pull-right">
                                <li class="active"><a href="index.php" title="Home">Home</a></li>
                                <li><a href="#about" title="About">About</a></li>
                                <li><a href="#test" title="Testimonials">Testimonials</a></li>
                                <li><a href="#contact" title="Contact">Contact</a></li>
                                <li><a href="login.php" class="btn btn-default">Login</a></li>
                                <li><a href="sign-up.php" title="Create Account">Create Account</a></li>

                                <!-- <li><a href="blog.html" title="Blog" class="animsition-link">Blog</a>
                                        <ul>
                                            <li><a href="blog.html" title="Blog" class="animsition-link">Blog</a></li>
                                            <li><a href="blog-single.html" title="Blog Single" class="animsition-link">Blog Single</a></li>
                                        </ul>
                                    </li> -->
                                <!-- <li><a href="#" class="btn btn-white">SignUp</a></li> -->

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.navigation -->
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 hidden-xs">
                    <div class="intro-caption">
                        <!-- intro caption -->
                        <h1 class="intro-title">Cryptocurrency Sells <br> Never been easier.</h1>
                        <p class="mb40">Sell your Bitcoins with velocity!<br>
                            From your home, with the security and speed.</p>
                        <a href="#" class="btn btn-default">Get Started</a>
                        <a href="#" class="btn btn-white">Login</a>
                    </div>
                    <!-- /.intro caption -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.intro section -->
    <div class="container mb-5 mt-5">
        <div class="row">
            <div class="col-md-6">
                <h1>Exchange rates</h1>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <p>N450</p>
                        <p>Naira Buy Rate</p>
                    </div>
                    <div class="col-md-6">
                        <p>$1</p>
                        <p>USD</p>
                    </div>
                </div>
                <table class="table table-striped table-dark">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Coin</th>
                            <th scope="col">USD</th>
                            <th scope="col">NGN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>BTC</td>
                            <td>$48,823.960</td>
                            <td>₦21,970,782</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>ETH</td>
                            <td>$1,805.230</td>
                            <td>₦812,353.500</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6 pl-5">
                <h1>Exchange rates calculator</h1>
                <hr>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
                    <div class="row">
                        <div class="col-md-6">
                            <p>Coin</p>
                            <select name="coin" id="coin" class="mb-2">
                                <option value="">--Select Currency--</option>
                                <option value="bitcoin">Bitcoin</option>
                                <option value="ethereum">Ethereum</option>
                            </select>
                            <br>
                            <br>
                            <p>USD</p>
                            <input type="number" name="" id="" value="<?php echo $usd ?? '' ?>" placeholder="0" disabled>
                        </div>
                        <div class="col-md-6 ">
                            <p>Amount</p>
                            <input type="number" name="amount" id="amount" placeholder="Coin amount">
                            <!-- The above has to be generated dynamically from the BE -->
                            <br>
                            <br>
                            <p>NGN</p>
                            <input type="number" name="" id="" value="<?php echo $ngn ?? '' ?>" placeholder="0" disabled>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Another Section -->
    <br>
    <br>
    <br>
    <div class="container" id="about">
        <div class="row">
            <div class="col-lg-6">
                <img src="images/Online payment_Flatline.png" width="500" height="500" alt="">
            </div>
            <div class="col-lg-6">
                <h1>Crafted For Secured, and <br> Reliable Transactions.</h1>
                <p>Perry Pays provides a Bitcoin marketplace where people sell Bitcoin <br> easily and safely with notable simple UI, friendly online customer <br> support 24/7 and lowest fee compared with major players on the <br> market.</p>
                <p> Our team is comprised mostly by banking professionals with extensive experience in financial products, E-currencies, Payment System and <br> Agile Software Development, and others.</p>
                <button type="submit" class="btn btn-success">Create Account</button>
            </div>
        </div>
    </div>
    <br><br><br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="text-center">
                    <br><br>
                    <h1><i class="fa fa-laptop" aria-hidden="true"></i></h1>
                    <h3>Secured</h3>
                    <p>All your transactions are 100% secure. <br> Encrypted connections and easy <br> payment methods.</p>
                    <br><br><br>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="text-center">
                    <br><br>
                    <h1><i class="fa fa-clock-o" aria-hidden="true"></i></h1>
                    <h3>Fast</h3>
                    <p>Completely fluid experience. The <br> operation will be performed instantly.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="text-center">
                    <br><br>
                    <h1><i class="fa fa-columns" aria-hidden="true"></i></h1>
                    <h3>Simplicity</h3>
                    <p>In just three steps you will be able to <br> sell bitcoin 24/7 using our simple <br> interface.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Cards could be used for the above section -->
    <div class="cta">
        <div class="container py-1 pb-5">
            <br><br><br>
            <h1 class="text-center">100% secure transactions</h1>
            <p class="text-center cta-text">We buy Bitcoins at the very best market prices because we wanna make you(our customer) rich. <br>
                We got Velocity in our DNA. You will testify on 1st trial or walk away! <br>
                More than 10k+ Transactions</p>
            <div class="row px-5">
                <div class="col-lg-4 text-center">
                    <h2 class="section-title">158</h2>
                    <p class="cta-text">Clients</p>
                </div>
                <div class="col-lg-4 text-center">
                    <h2 class="section-title">2.6K+</h2>
                    <p class="cta-text">Digital currency exchanged</p>
                </div>
                <div class="col-lg-4 text-center">
                    <h2 class="section-title">44.2K+</h2>
                    <p class="cta-text">Transactions</p>
                </div>
            </div>
        </div>
    </div>

    <div class="section-space80 bg-light">
        <!-- section-space80 -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center mb60">
                    <h1>Who We Are?</h1>
                    <p>Perry Pays provides a Bitcoin marketplace where people sell Bitcoin easily and safely with notable simple UI, friendly online customer support 24/7 and lowest fee compared with major players on the market.

                        Our team is comprised mostly by banking professionals with extensive experience in financial products, E-currencies, Payment System and Agile Software Development, and others.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center mb40">
                    <h2>Take on the market with our powerful platforms</h2>
                </div>
                <div class="col-md-4">
                    <div class="mb30 py-4 mx-4 who">
                        <h3>Multiple Brokage Options</h3>
                        <p>By having multiple brokerage accounts, you can take advantage of the strengths of each broker, mixing and matching the qualities that you find valuable. And that should save you money and offer a better overall product and experience.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb30 py-4 mx-4 who">
                        <h3>Convenience</h3>
                        <p>Trade from the comfort of your home. Have the feel of comfortability and flexibility.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb30 py-4 mx-4 who">
                        <h3>Expert Research Recommendations</h3>
                        <p>Leading experts in crypto currencies such as Elon Musk recommends Perry Pays.</p>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center mt40">
                    <a href="#" class="btn btn-outline">About us</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /.section-space80 -->
    <div class="section-space60" id="test">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="section-title">
                        <h1>Customer Reviews</h1>
                        <p>We welcome feedback from our members as it helps us optimize the site to better service their needs. </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="outline testimonial-block pinside30 mb30">
                        <div class="testimonial-header">
                            <div class="testimonial-icon">
                                <!-- testimonial icon -->
                                <i class="fa fa-quote-left"></i>
                            </div>
                            <!-- /.testimonial icon -->
                            <span class="testimonial-title">Good Service</span>
                        </div>
                        <div class="testimonial-content">
                            <p>“I have only been with the stock pick system and short time and so for have had very good results. 34 trades with only one loss and that amount was only 1.35%”</p>
                        </div>
                        <div class="customer-box">
                            <!-- customer-box -->
                            <div class="testimonial-img">
                                <img src="images/face (1).jpg" alt=" " class="img-c">
                            </div>
                            <div class="testimonial-info">
                                <h3 class="customer-name">Jose Chronister</h3>
                                <h4 class="testimonial-meta">customer</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="outline testimonial-block pinside30 mb30">
                        <div class="testimonial-header">
                            <div class="testimonial-icon">
                                <!-- testimonial icon -->
                                <i class="fa fa-quote-left"></i>
                            </div>
                            <!-- /.testimonial icon -->
                            <span class="testimonial-title">Great Discovery</span>
                        </div>
                        <div class="testimonial-content">
                            <p>“What a great discovery. This is what I have been looking for. I don’t want to Daytrade. On the other hand, I do not want to sit on it for a long time before I sell”</p>
                        </div>
                        <div class="customer-box">
                            <!-- customer-box -->
                            <div class="testimonial-img">
                                <img src="images/face (2).jpg" alt=" " class="img-c">
                            </div>
                            <div class="testimonial-info">
                                <h3 class="customer-name">Lisa Greene</h3>
                                <h4 class="testimonial-meta">customer</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="outline testimonial-block pinside30 mb30">
                        <div class="testimonial-header">
                            <div class="testimonial-icon">
                                <!-- testimonial icon -->
                                <i class="fa fa-quote-left"></i>
                            </div>
                            <!-- /.testimonial icon -->
                            <span class="testimonial-title">Easy to Follow</span>
                        </div>
                        <div class="testimonial-content">
                            <p>“After searching for a site with recommendations that make sense and easy to follow I finally found one. Took about profit first and I’m just getting into the system”</p>
                        </div>
                        <div class="customer-box">
                            <!-- customer-box -->
                            <div class="testimonial-img">
                                <img src="images/face (3).jpg" alt=" " class="img-c">
                            </div>
                            <div class="testimonial-info">
                                <h3 class="customer-name">Katheryn Brown</h3>
                                <h4 class="testimonial-meta">customer</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.section-space80 -->
    <div class="cta">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
                    <h1 class="cta-title">Get in touch <br>
                        Call, email 24/7 or visit a branch</h1>
                    <p class="cta-text">We are always there to help you all the way.</p>
                    <a href="#" class="btn btn-white mb30">Get Started Now</a>
                </div>
                <div class="col-lg-offset-1 col-lg-4 col-md-offset-1 col-md-4 col-sm-6 col-xs-12">
                    <div class="bg-white pinside30 cta-info">
                        <div class="cta-call">
                            <i class="fa fa-phone"></i>
                            <span>+234 11223344</span>
                        </div>
                        <div class="cta-mail">
                            <i class="fa fa-envelope"></i>
                            <span>Info@payperry.com</span>
                        </div>
                        <div class="cta-address">
                            <i class="fa fa-map-marker"></i>
                            <span class="address">
                                Nigeria
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-space80" id="contact">
        <!-- section space -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="section-title">
                        <h1>Contact Us</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Email</label>
                                <input type="email" class="form-control" id="inputEmail4">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Name</label>
                                <input type="text" class="form-control" id="inputPassword4">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Address</label>
                            <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                        </div>
                        <div class="form-group">
                            <label for="inputAddress2">Message</label>
                            <textarea name="message" id="" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Contact Us</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="footer section-space60">
        <!-- footer -->
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="footer-widget mb20">
                        <!-- footer-widget -->
                        <h3 class="footer-title">Contact Info</h3>
                        <div class="ft-contact-info">
                            <!-- ft contact info -->
                            <div class="ft-icon">
                                <!-- ft icon -->
                                <i class="fa fa-phone"></i>
                            </div>
                            <!-- /.ft icon -->
                            <div class="ft-content">
                                <!-- ft content -->
                                +234 11223344
                            </div>
                            <!-- /.ft content -->
                        </div>
                        <!-- /.ft contact info -->
                        <div class="ft-contact-info">
                            <!-- ft contact info -->
                            <div class="ft-icon">
                                <!-- ft icon -->
                                <i class="fa fa-envelope"></i>
                            </div>
                            <!-- /.ft icon -->
                            <div class="ft-content">
                                <!-- ft content -->
                                info@perrypay.com
                            </div>
                            <!-- /.ft content -->
                        </div>
                        <!-- /.ft contact info -->
                        <div class="ft-contact-info">
                            <!-- ft contact info -->
                            <div class="ft-icon">
                                <!-- ft icon -->
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <!-- /.ft icon -->
                            <div class="ft-content">
                                <!-- ft content -->
                                Nigeria
                            </div>
                            <!-- /.ft content -->
                        </div>
                        <!-- /.ft contact info -->
                    </div>
                    <!-- /.footer-widget -->
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
                    <div class="footer-widget mb20">
                        <!-- footer-widget -->
                        <h3 class="footer-title">Quick Links</h3>
                        <ul class="bullet listnone no-padding mb0">
                            <li><i class="fa fa-angle-right"></i> <a href="index.html" class="Home">Home</a></li>
                            <li><i class="fa fa-angle-right"></i> <a href="service-list.html" title="Services">Services</a></li>
                            <!-- <li><i class="fa fa-angle-right"></i> <a href="blog.html" title="Blog">Blog</a></li> -->
                            <li><i class="fa fa-angle-right"></i> <a href="contact-us.html" title="Contact us">Contact us</a></li>
                        </ul>
                        <!-- /.footer-widget -->
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="footer-widget mb20">
                        <!-- footer-widget -->
                        <h3 class="footer-title">Follow Us On</h3>
                        <ul class="listnone no-padding mb0">
                            <li class="footer-link"><a href="#"><i class="fa fa-facebook-square "></i> facebook</a></li>
                            <li class="footer-link"><a href="#"><i class="fa fa-twitter-square "></i> twitter</a></li>
                            <li class="footer-link"><a href="#"><i class="fa fa-google-plus-square "></i> google-plus</a></li>
                        </ul>
                    </div>
                    <!-- /.footer-widget -->
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="footer-widget">
                        <!-- footer-widget -->
                        <h3 class="footer-title">Newsletter</h3>
                        <p>Subscribe our email newsletter today to receive updates.</p>
                        <form>
                            <div class="form-group">
                                <label for="inputEmail3" class="sr-only control-label">Email</label>
                                <input type="email" class="form-control" id="inputEmail3" placeholder="Enter Email Address">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-outline">Subscribe</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.footer-widget -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.footer -->
    <div class="tiny-footer">
        <!-- tiny-footer -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <p>Copyrights © 2021. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- /.tiny-footer -->
    <!-- back to top icon -->
    <a href=" #0 " class="cd-top" title="Go to top">Top</a>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-body">
                    <iframe width="100%" height="600" src="https://www.youtube.com/embed/CoirzH4fByQ" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/menumaker.js"></script>
    <script type="text/javascript">
        $("#navigation").menumaker({
            title: "Menu",
            format: "multitoggle"
        });
    </script>
    <!-- animsition -->
    <script type="text/javascript" src="js/animsition.js"></script>
    <script type="text/javascript" src="js/animsition-script.js"></script>
    <!-- sticky header -->
    <script type="text/javascript" src="js/jquery.sticky.js"></script>
    <script type="text/javascript" src="js/sticky-header.js"></script>
    <!-- owl carsoul -->
    <script type="text/javascript" src="js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="js/testimonial.js"></script>
    <!-- Back to top script -->
    <script src="js/back-to-top.js" type="text/javascript"></script>
</body>

</html>