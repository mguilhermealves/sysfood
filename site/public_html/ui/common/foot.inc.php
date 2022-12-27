<script>
    <?php
    if (isset($_SESSION["action_js"])) {
        foreach ($_SESSION["action_js"] as $v) {
            print($v . "\n");
        }
        unset($_SESSION["action_js"]);
    }
    ?>
</script>

<!-- jQuery 3 -->
<script src="<?php printf("%s%s", constant("cFurniture"), "AdminLTE/bower_components/jquery/dist/jquery.min.js") ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php printf("%s%s", constant("cFurniture"), "AdminLTE/bower_components/jquery-ui/jquery-ui.min.js") ?>"></script>

</body>

</html>