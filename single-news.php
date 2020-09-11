<?php
$id = $_GET['id'];
$page_name = "blog";
$page_title = "Engineering Technology Innovation Center - University of Peradeniya";
$page_description = "";
require_once("header.php");
?>

<!-- Breadcrumb section -->
<div class="site-breadcrumb">
    <div class="container">

        <?php

        $query=mysqli_query($con,"select * from news where id='$id'");
        $nrow=mysqli_fetch_array($query);

        $heading = $nrow['heading'];
        $content = $nrow['content'];
        $status = $nrow['status'];

        $created_date = $nrow['created_date'];
        $last_updated_time = $nrow['last_updated_time'];
        $image = $nrow['thumbnail'];

        //$timemessage = timeAgo($date);

        ?>

        <a href="index.php"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-right"></i>
        <a href="news.php"><i class="fa fa-newspaper-o"></i> News</a> <i class="fa fa-angle-right"></i>

        <span><?php echo $heading; ?></span>
    </div>
</div>
<!-- Breadcrumb section end -->


<!-- Blog page section  -->
<section class="blog-page-section spad pt-0">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="post-item post-details">

                    <img src="<?php echo $image; ?>" class="post-thumb-full" alt="">
                    <div class="post-content">
                        <h3><?php echo $heading; ?></h3>
                        <div class="post-meta">
                            <span><i class="fa fa-calendar-o"></i> <?php echo $created_date; ?></span>
                        </div>
                        <p><?php echo $content; ?></p>
                        <!--<p> Fusce imperdiet, eros non fringilla auctor, dolor leo blandit magna, in pretium erat elit id neque. Nulla sagittis consequat arcu euscura dignissim. Donec ultricies id ante vel blandit. Integer sit amet erat tincidunt, dictum orci non, tincidunt nisi. Crasania nisl eu aliquet pharetra. Duis finibus pulvinar tellus, sed convallis lectus faucibus vitae. Fusce rhoncus placerat magna, nec fermentum ex tristique eu. Donec aliquet purus lectus, ut finibus augue porta ac. Nullam ultricies tempus libero.</p>
                        <blockquote>“There is no end to education. It is not that you read a book, pass an examination, and finish with education. The whole of life, from the moment you are born to the moment you die.”</blockquote>
                        <p>Proin ac neque quis ex malesuada feugiat sed at ligula. Donec efficitur nisl tortor, eget auctor ex lobortis id. Duis cursus turpis nec venenatis dapibus. Nunc eget rhoncus purus, a semper orci. Mauris blandit non arcu malesuada aliquam. Fusce iaculis augue ut neque sollicitudin, quis interdum enim consectetur. Nullam ut facilisis erat, eget viverra sem. Nulla lobortis tempor magna in maximus. Fusce nec ante et nunc elementum rutrum ut in odio. Quisque cursus sit amet massa in mollis suspendisse ut ipsum a orci scelerisque tincidunt. Curabitur pellentesque lobortis ligula, in scelerisque felis volutpat nec.</p>-->
<!--                        <p>Aenean et enim aliquet, rutrum ante auctor, euismod urna. Phasellus ac erat faucibus, laoreet massa id, sagittis orci. In placerat pharetra lectus vitae gravida. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vivamus massa massa, porttitor eget consectetur sed, vulputate ac velit. Integer ullamcorper ante ex. Quisque vitae eleifend elit. Vestibulum mi lectus, euismod in nunc, posuere eleifend sapien. In commodo euismod lectus quis porttitor.</p>-->
                        <div class="tag"><i class="fa fa-tag"></i> EDUCATION, MARKETING</div>
                    </div>

                </div>
            </div>
            <!-- sidebar -->
            <div class="col-sm-8 col-md-5 col-lg-4 col-xl-3 offset-xl-1 offset-0 pl-xl-0 sidebar">

                <!-- widget -->
                <div class="widget">
                    <h5 class="widget-title">Recent News</h5>
                    <div class="recent-post-widget">
                        <!-- recent post -->
                        <div class="rp-item">

                            <?php

                            $result=mysqli_query($con,"select * from news where status='PUBLISHED' order by created_date  DESC LIMIT 6");

                            while($row=mysqli_fetch_array($result)){

                                ?>

                            <div class="rp-thumb set-bg" data-setbg="<?php echo $row['thumbnail']; ?>"></div>
                            <div class="rp-content">
<!--                                <h6>--><?php //echo $row['heading']; ?><!--</h6>-->
                                <h6><a href="single-news.php?id=<?php echo $row['id']; ?>"><?php echo $row['heading']; ?></a></h6>

                                <p><i class="fa fa-clock-o"></i> <?php echo $row['created_date']; ?></p>
                            </div>
                            <div style="height: 25px"></div>

                            <?php

                            }

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require_once("footer.php");
?>