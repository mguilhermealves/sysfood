    <?php
    if (isset($_SESSION[constant("cAppKey")]["credential"])) {
    ?>
        <footer>
            <div id="footer">Copyright <?php echo date('Y') ?> <a href="https://www.mgsystemsolutions.com.br/" target="_blank">MG System Solutions</a> </div>
        </footer>
        </div>
        </div>
        <!-- end paper bg -->
        </div>
        <!-- end of off-canvas-wrap -->
    <?php
    }
    ?>

    <!-- end of inner-wrap -->
    <!-- main javascript library -->
    <script type='text/javascript' src="<?php printf("%s%s", constant("cFurniture"), "js/jquery.js") ?>"></script>
    <script type="text/javascript" src="<?php printf("%s%s", constant("cFurniture"), "js/waypoints.min.js") ?>"></script>
    <script type='text/javascript' src='<?php printf("%s%s", constant("cFurniture"), "js/preloader-script.js") ?>'></script>
    <!-- foundation javascript -->
    <script type='text/javascript' src="<?php printf("%s%s", constant("cFurniture"), "js/foundation.min.js") ?>"></script>
    <script type='text/javascript' src="<?php printf("%s%s", constant("cFurniture"), "js/foundation/foundation.dropdown.js") ?>"></script>
    <!-- main edumix javascript -->
    <script type='text/javascript' src='<?php printf("%s%s", constant("cFurniture"), "js/slimscroll/jquery.slimscroll.js") ?>'></script>
    <script type='text/javascript' src='<?php printf("%s%s", constant("cFurniture"), "js/slicknav/jquery.slicknav.js") ?>'></script>
    <script type='text/javascript' src='<?php printf("%s%s", constant("cFurniture"), "js/sliding-menu.js") ?>'></script>
    <script type='text/javascript' src='<?php printf("%s%s", constant("cFurniture"), "js/scriptbreaker-multiple-accordion-1.js") ?>'></script>
    <script type="text/javascript" src="<?php printf("%s%s", constant("cFurniture"), "js/number/jquery.counterup.min.js") ?>"></script>
    <script type="text/javascript" src="<?php printf("%s%s", constant("cFurniture"), "js/circle-progress/jquery.circliful.js") ?>"></script>
    <script type='text/javascript' src='<?php printf("%s%s", constant("cFurniture"), "js/app.js") ?>'></script>

    <script type='text/javascript' src='<?php printf("%s%s", constant("cFurniture"), "js/jQuery-TE_v.1.4.0/jquery-te-1.4.0.min.js") ?>'></script>
    <link rel="stylesheet" href='<?php printf("%s%s", constant("cFurniture"), "js/jQuery-TE_v.1.4.0/jquery-te-1.4.0.css") ?>' />

    <script type='text/javascript' src='<?php printf("%s%s", constant("cFurniture"), "js/uploadfile.js") ?>'></script>
    <?php
    /*
	    <script src="<?php printf("%s%s", constant("cFurniture"), "js/text-editor/dist/trumbowyg.js") ?>"></script>
     */
    ?>
    <script>
        /** Default editor configuration **/
        //$('#wiwiq-editor').trumbowyg();
        //$(document).foundation();
        // Get the modal
        // var modal = document.getElementById("myModal");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        // var modalImg = $("#img01");
        // var captionText = $("#caption");
        // Get the <span> element that closes the modal
        // var span = document.getElementsByClassName("close")[0];
    </script>
    <script type='text/javascript' src='<?php printf("%s%s", constant("cFurniture"), "js/jquery-ui.js") ?>'></script>
    <script type='text/javascript' src='<?php printf("%s%s", constant("cFurniture"), "js/jquery.inputmask.bundle.js") ?>'></script>

    <script type="text/javascript">
        $('#mytextarea').jqte();
    </script>