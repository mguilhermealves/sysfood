    <script src="<?php printf("%s%s", constant("cFurniture"), "js/pace/pace.js") ?>"></script>
    <link href="<?php printf("%s%s", constant("cFurniture"), "js/pace/themes/orange/pace-theme-flash.css") ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php printf("%s%s", constant("cFurniture"), "js/slicknav/slicknav.css") ?>" />
    <link rel="stylesheet" href="<?php printf("%s%s", constant("cFurniture"), "js/gallery/swipebox.css") ?>" />
    <link rel="stylesheet" href="<?php printf("%s%s", constant("cFurniture"), "js/text-editor/dist/ui/trumbowyg.css") ?>" />
    <script src="<?php printf("%s%s", constant("cFurniture"), "js/vendor/modernizr.js") ?>"></script>

    <script src="<?php printf("%s%s", constant("cFurniture"), "js/sweet-alert/sweetalert.min.js") ?>"></script>
    <link rel="stylesheet" href="<?php printf("%s%s", constant("cFurniture"), "js/sweet-alert/sweetalert.css") ?>" />
    </head>

    <body>
        <div id="preloader">
            <div id="status">&nbsp;</div>
        </div>
        <?php
        if (isset($_SESSION[constant("cAppKey")]["credential"])) {
        ?>
            <div class="off-canvas-wrap" data-offcanvas>
                <!-- right sidebar wrapper -->
                <div class="inner-wrap">
                    <!-- Right sidemenu -->
                    <div id="skin-select">
                        <!--      Toggle sidemenu icon button -->
                        <a id="toggle">
                            <span class="fa icon-menu"></span>
                        </a>
                        <!--      End of Toggle sidemenu icon button -->
                        <div class="skin-part">
                            <div id="tree-wrap">
                                <!-- Profile -->
                                <div class="profile" style="padding: 0px;margin: 0px;display: flex;justify-content: center;align-items: center;"><img src="/furniture/img/logo-dermolaser.png" style="width: 75%; padding: 0px; margin: auto; align-self: center;"></div>
                                <!-- End of Profile -->
                                <?php require constant("cRootServer") . "ui/common/sidebar.inc.php"; ?>
                            </div>
                        </div>
                    </div>
                    <!-- end of Rightsidemenu -->
                    <div class="wrap-fluid" id="paper-bg">
                        <!-- top nav -->
                        <div class="top-bar-nest">
                            <nav class="top-bar" data-topbar role="navigation" data-options="is_hover: false">
                                <ul class="title-area left">
                                    <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
                                    <li class="toggle-topbar menu-icon"><a href="#"><span></span></a>
                                    </li>
                                </ul>
                                <section class="top-bar-section ">
                                    <ul class="right">
                                        <li class=" has-dropdown bg-white">
                                            <a style="background-color:#58595B" href="#"><span class="admin-pic-text text-white"><?php print($_SESSION[constant("cAppKey")]["credential"]["first_name"]) ?> </span>
                                            </a>

                                            <ul class="dropdown dropdown-nest profile-dropdown">
                                                <li>
                                                    <i class="icon-upload"></i>
                                                    <a href="/sair">
                                                        <h4>Logout</h4>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </section>
                            </nav>
                        </div>
                        <!-- end of top nav -->
                    <?php
                }
                    ?>