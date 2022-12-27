<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title><?php isset($page) ? print($page . " | " . constant("cTitle")) : print(constant("cTitle")) ?></title>

  <link rel="icon" type="image/png" sizes="32x32" href="/furniture/images/ico.webp">

  <link rel="icon" href="<?php printf("%s%s", constant("cFrontend"), "favicon.jpg") ?>" />
  <link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" href="<?php printf("%s%s", constant("cFrontend"), "favicon.jpg") ?>">
  <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2)" href="<?php printf("%s%s", constant("cFrontend"), "favicon.jpg") ?>">
  <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 2)" href="<?php printf("%s%s", constant("cFrontend"), "favicon.jpg") ?>">
  <link rel="preconnect" href="https://fonts.gstatic.com">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

  <link rel="stylesheet" href="<?php printf("%s%s", constant("cFurniture"), "css/commom.css?5") ?>">
  <link rel="stylesheet" href="<?php printf("%s%s", constant("cFurniture"), "css/responsive.css?5") ?>">
  <link rel="stylesheet" href="<?php printf("%s%s", constant("cFurniture"), "css/common.css?5") ?>">
  <link rel="stylesheet" href="<?php printf("%s%s", constant("cFurniture"), "css/main.css?5") ?>">

  <link rel="stylesheet" href="<?php printf("%s%s", constant("cFurniture"), "slick-1.8.1/slick/slick.css") ?>">
  <link rel="stylesheet" href="<?php printf("%s%s", constant("cFurniture"), "slick-1.8.1/slick/slick-theme.css") ?>">

  <link rel="stylesheet" href="<?php printf("%s%s", constant("cFurniture"), "js/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css") ?>">

</head>
<body>