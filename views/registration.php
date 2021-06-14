<?php
/** This view contains the layout of the order form. It depends on other views.
 * @var bool $SUCCESS
 * @var string $meghivo
 */
?>
<!-- Page Content -->
<div class="container" style="margin-bottom:150px">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-primary">Regisztráció</h1>
            <?php
            if (!isset($SUCCESS)) {
                include('../views/registration_form.php');
            } else {
                echo "<h2 class=\"text-primary\">Siker!</h2>";
                echo $meghivo;
            }

            ?>
        </div>
        <!-- /.col-lg-9 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->
</div >