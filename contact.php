<?php

$page_name = "contact";
$page_title = "Engineering Technology Innovation Center - University of Peradeniya";
$page_description = "";
require_once("header.php");
?>

<!-- Breadcrumb section -->
<div class="site-breadcrumb">
    <div class="container">
        <a href="#"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-right"></i>
        <span>Contact</span>
    </div>
</div>
<!-- Breadcrumb section end -->


<!-- Courses section -->
<section class="contact-page spad pt-0">
    <div class="container">
        <div class="map-section">
            <div class="contact-info-warp">
                <div class="contact-info">
                    <h4>Address</h4>
                    <p>Director,<br/>
                        Engineering Technology Incubation Centre,<br/> Faculty of Engineering,<br/>
                        University of Peradeniya.</p>
                </div>
                <div class="contact-info">
                    <h4>Phone</h4>
                    <p>(+94) 71 684 83 19</p>
                </div>
                <div class="contact-info">
                    <h4>Email</h4>
                    <p>diretic@eng.pdn.ac.lk</p>
                </div>
            </div>
            <!-- Google map -->
            <div class="mapouter">
                <div class="gmap_canvas">
                    <iframe width="1240" height="500" id="gmap_canvas"
                            src="https://maps.google.com/maps?q=Faculty%20of%20Engineering%2C%3Cbr%2F%3E%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20University%20of%20Peradeniya.&t=&z=11&ie=UTF8&iwloc=&output=embed"
                            frameborder="0" scrolling="no" marginheight="0" marginwidth="0">

                    </iframe>
                </div>
                <style>
                    .mapouter {
                        position: relative;
                        text-align: right;
                        height: 500px;
                        width: 1240px;
                    }

                    .gmap_canvas {
                        overflow: hidden;
                        background: none !important;
                        height: 500px;
                        width: 1240px;
                    }
                </style>
            </div>
            <!--            <div class="map" id="map-canvas"></div>-->
        </div>
        <div class="contact-form spad pb-0">
            <div class="section-title text-center">
                <h3>GET IN TOUCH</h3>
                <p>Contact us for best deals and offer</p>
            </div>
            <form class="comment-form --contact">
                <div class="row">
                    <div class="col-lg-4">
                        <input type="text" placeholder="Your Name">
                    </div>
                    <div class="col-lg-4">
                        <input type="text" placeholder="Your Email">
                    </div>
                    <div class="col-lg-4">
                        <input type="text" placeholder="Subject">
                    </div>
                    <div class="col-lg-12">
                        <textarea placeholder="Message"></textarea>
                        <div class="text-center">
                            <button class="site-btn">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Courses section end-->

<?php
require_once("footer.php");
?>

<!-- load for map -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0YyDTa0qqOjIerob2VTIwo_XVMhrruxo"></script>
<script src="assets/js/map.js"></script>