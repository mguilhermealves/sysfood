</head>

<body class="hold-transition skin-blue sidebar-mini">
    <?php if (site_controller::check_login()) { ?>
    <div class="wrapper">

        <?php require constant("cRootServer") . "ui/common/sidebar.php"; ?>

        <div class="content-wrapper">

            <?php } ?>