<?php

$page_name = "news";
$page_title = "Engineering Technology Innovation Center - University of Peradeniya";
$page_description = "";
require_once("header.php");
?>

<!-- Breadcrumb section -->
<div class="site-breadcrumb">
    <div class="container">
        <a href="#"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-right"></i>
        <span>News</span>
    </div>
</div>
<!-- Breadcrumb section end -->


<!-- Blog page section  -->
<section class="blog-page-section spad pt-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 post-list">

                <?php
                if (isset($_GET['page'])) {
                    $pageno = $_GET['page'];
                } else {
                    $pageno = 1;
                }
                $no_of_records_per_page = 4;
                $offset = ($pageno-1) * $no_of_records_per_page;

                $query=mysqli_query($con,"SELECT COUNT(*) FROM news where status='PUBLISHED' ");
                $total_rows = mysqli_fetch_row($query)[0];
                $total_pages = ceil($total_rows / $no_of_records_per_page);

                $result=mysqli_query($con,"select * from news where status='PUBLISHED' order by last_updated_time  DESC LIMIT $offset, $no_of_records_per_page");

                while($row=mysqli_fetch_array($result)){

                    ?>

                    <div class="post-item">
                        <div class="post-thumb set-bg" data-setbg="<?php echo $row['thumbnail']; ?>"></div>
                        <div class="post-content">
                            <h3><a href="single-news.php?id=<?php echo $row['id']; ?>"><?php echo $row['heading']; ?></a></h3>

                            <div class="post-meta">
                                <span><i class="fa fa-calendar-o"></i> <?php echo $row['created_date']; ?></span>
                            </div>
                            <p><?php echo get_excerpt($row['content'], 100); ?></p>
                        </div>
                    </div>
                <?php

                }

                ?>

                <div class="text-center">

                    <ul class="site-pageination">
                        <li><a href="?page=1" class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">First</a></li>

                        <?php
                        for ($counter=1; $counter<=$total_pages; $counter++) {
                            if ($counter == $pageno) {
                                echo "<li class='active'><a class='active'>$counter</a></li>";
                            } else {
                                echo "<li><a href='?page=".$counter."'>".$counter."</a></li>";
                            }
                        };
                        ?>

                        <li><a href="?page=<?php echo $total_pages; ?>" class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">Last</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- Blog page section end -->

<?php

function get_excerpt( $content, $length = 40, $more = '...' ) {
    $excerpt = strip_tags( trim( $content ) );
    $words = str_word_count( $excerpt, 2 );
    if ( count( $words ) > $length ) {
        $words = array_slice( $words, 0, $length, true );
        end( $words );
        $position = key( $words ) + strlen( current( $words ) );
        $excerpt = substr( $excerpt, 0, $position ) . $more;
    }
    return $excerpt;
}
require_once("footer.php");
?>