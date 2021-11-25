<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package citysquare
 */

get_header();
?>

	<div class="container ">
    <div class="lease_content_container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12 no_padding_left_768 no_padding_right_768">
                <div class="lease_content">
                    <h1 class="color_leasing">404 Page Not Found</h1>
                    <h4>Page will be redirected to  home page within <span id="remainTime">5</span> seconds</h4>
                    <br />
                    <div><p><span>The page you are looking for cannot be found. </span></p></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    var timeLeft = 5;
    var elem = document.getElementById('remainTime');

    var timerId = setInterval(countdown, 1000);

    function countdown() {
        if (timeLeft == 0) {
            clearTimeout(timerId);
             window.location.href = "/";
        } else {
            elem.innerHTML = timeLeft;
            timeLeft--;
        }
    }
</script>

<?php
get_footer();
