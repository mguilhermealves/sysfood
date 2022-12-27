<main class="container-fluid">
    <section class="home">
        <section class="quadro-banner">
            <div class="owl-carousel owl-theme banner-home owl-loaded owl-drag">
                <div class="owl-stage-outer">
                    <div class="owl-stage" style="transform: translate3d(-7610px, 0px, 0px); transition: all 5s ease 5s; width: 20933px;">
                        <?php foreach ($banners->data as $banner) { ?>
                            <div class="owl-item cloned" style="width: 1903px;">
                                <div class="item" style="height: 100%;">
                                    <img class="img-fluid" src="<?php print($banner['img']) ?>" alt="Banner">
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="owl-nav disabled"><button type="button" role="presentation" class="owl-prev"><i class="bi bi-arrow-left-circle"></i></button><button type="button" role="presentation" class="owl-next"><i class="bi bi-arrow-right-circle"></i></button></div>
                <div class="owl-dots disabled"></div>
            </div>
        </section>

        <section class="sobre padding-top-50 padding-bottom-50">
            <div class="container-fluid ml-lp-15">
                <div class="container with-large-gutters">
                    <div class="row justify-content-center">
                        <div class="col col-sm-12">
                            <div class="">
                                <div class="">
                                    <div class="row large-gutters align-items-center">
                                        <div class="col-12 col-md-7 order-md-last order-first image-block-15 mb-4 mb-md-0">
                                            <div>
                                                <div class="image-block-16 text-center w-100">
                                                    <img src="/furniture/images/home/img_sobre.webp" border="0" alt="" class="img-fluid d-inline" width="1500" style="display:block">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <div class="row">
                                                <div class="col" aria-label="content" role="contentinfo">
                                                    <h1>
                                                        <strong>
                                                            <span style="color:#db3592">
                                                                Sobre a<br>
                                                                Dermolaser </span>
                                                        </strong>
                                                    </h1>
                                                    <div class="margin-top-15 p-sobre">
                                                        <div class="margin-top-15 p-sobre">
                                                            <p>Empresa Multinacional com mais de 15 anos no mercado, unidades no Brasil, Espanha e Portugal.</p>
                                                            <p>O Grupo Dermolaser é uma das mais conceituadas marcas no segmento de Depilação a Laser e Estética.</p>
                                                            <p>Conta com a melhor tecnologia do mercado em depilação a laser Diodo e o melhor sistema de refrigeração, proporcionando mais conforto e segurança.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="container tratamentos-home padding-bottom-20">
            <div class="titulo-padrao">
                <h1 class="t-degr-pink">Tipos de Tratamentos</h1>
            </div>

            <div class="row">
                <div class="card-deck">
                    <?php foreach ($typestreatments->data as $typetreatment) { ?>
                        <div class="card">
                            <img class="card-img-top" src="<?php print($typetreatment['image_banner']) ?>" alt="<?php print($typetreatment['name']); ?>">
                            <div class="card-body text-center">
                                <h5 class="card-title margin-top-5 margin-bottom-5">
                                    <?php print($typetreatment['name']); ?>
                                </h5>
                                <p class="card-text">
                                    <?php print($typetreatment['description']) ?>
                                </p>
                            </div>

                            <div class="d-flex justify-content-center">
                                <a href="/tratamentos/<?php print($typetreatment["slug"]) ?>">Conheça</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="d-flex justify-content-center botao-cta margin-50">
                <a href="tratamentos/" class="btn btn-success" role="button">
                    <i class="bi bi-columns-gap"></i>
                    Conheça Todos os Tratamentos
                </a>
            </div>
        </section>

        <section class="pilares">
            <div class="container-fluid padding-left-20 padding-right-20">
                <div class="titulo-padrao margin-bottom-60 xs-margin-bottom-60">
                    <h1 class="titulo-padrao-b">4 Pilares da DermoLaser</h1>
                </div>

                <div class="card-deck row">
                    <div class="card col-md-3">
                        <img class="card-img-top" src="/furniture/images/home/1-4pilares-acesso.png" alt="ACESSO">
                        <div class="card-body text-center">
                            <h5 class="card-title">Acesso</h5>
                            <p class="card-text">Aqui você pode cuidar da sua saúde, beleza e do seu bem-estar! </p>
                        </div>
                    </div>

                    <div class="card col-md-3">
                        <img class="card-img-top" src="/furniture/images/home/2-4pilares-conforto.png" alt="CONFORTO">
                        <div class="card-body text-center">
                            <h5 class="card-title">Conforto</h5>
                            <p class="card-text">As melhores instalações e a melhor tecnologia a favor do seu bem-estar.</p>
                        </div>
                    </div>

                    <div class="card col-md-3">
                        <img class="card-img-top" src="/furniture/images/home/3-4pilares-conveniencia.png" alt="conveniência">
                        <div class="card-body text-center">
                            <h5 class="card-title">Conveniência</h5>
                            <p class="card-text">Depilação a laser, tratamentos faciais e tratamentos corporais, tudo em um só lugar!</p>
                        </div>
                    </div>

                    <div class="card col-md-3">
                        <img class="card-img-top" src="/furniture/images/home/4-4pilares-qualidade.png" alt="QUALIDADE">
                        <div class="card-body text-center">
                            <h5 class="card-title">Qualidade</h5>
                            <p class="card-text">Equipe treinada e profissionais qualificados para realizar os procedimentos e melhor atender você!</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="container depoimentos-home">
            <div id="depoimentosHome" class="carousel carousel-fade slide" data-ride="carousel">
                <?php foreach ($testimonials->data as $k => $testimonial) { ?>
                    <ol class="carousel-indicators">
                        <li data-target="#depoimentosHome" data-slide-to="<?php print($k) ?>" class="active"></li>
                    </ol>
                <?php } ?>

                <div class="carousel-inner">
                    <?php foreach ($testimonials->data as $k => $testimonial) {
                        if ($k == 0) {
                    ?>
                            <div class="carousel-item active">
                                <div class="texto-depoimento text-center">
                                    <h3 class="titulo-padrao-b">Vejam o que falam da DermoLaser</h3>
                                    <hr>
                                    <p class="m-auto">
                                        <?php print($testimonial["description"]) ?>
                                    </p>
                                </div>
                                <div class="carousel-caption text-muted">
                                    <div class="user-depoimento">
                                        <img src="<?php print($testimonial["client_image"]) ?>" alt="Img Usuário" class="img-thumbnail rounded-circle"> <!-- Melhoria -->
                                        <h5><?php print($testimonial["client_name"]) ?></h5>
                                        <p><?php print("Unidade - " . $testimonial["units_attach"][0]["trade_name"]) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="carousel-item">
                                <div class="texto-depoimento text-center">
                                    <h3 class="titulo-padrao-b">Vejam o que falam da DermoLaser</h3>
                                    <hr>
                                    <p class="m-auto">
                                        <?php print($testimonial["description"]) ?>
                                    </p>
                                </div>
                                <div class="carousel-caption text-muted">
                                    <div class="user-depoimento">
                                        <img src="<?php print($testimonial["client_image"]) ?>" alt="Img Usuário" class="img-thumbnail rounded-circle"> <!-- Melhoria -->
                                        <h5><?php print($testimonial["client_name"]) ?></h5>
                                        <p><?php print("Unidade - " . $testimonial["units_attach"][0]["trade_name"]) ?></p>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
                <a class="carousel-control-prev" href="#depoimentosHome" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#depoimentosHome" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </section>

        <section class="container-fluid galeria-home text-center">
            <h1 class="titulo-padrao-b">Conheça a DermoLaser</h1>

            <div class="row align-items-center">
                <div class="col-md-12 mx-auto">

                    <div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>

                    <div class="mx-auto">


                        <div class="item">
                            <div class="wp-video">
                                <!--[if lt IE 9]><script>document.createElement('video');</script><![endif]-->
                                <video class="wp-video-shortcode" id="video-246-1" width="400" height="360" preload="metadata" controls="controls">
                                    <source type="video/mp4" src="/wp-content/uploads/2022/10/Video-do-WhatsApp-de-2022-10-23-as-12.25.21.mp4" />
                                </video>
                            </div>
                        </div>


                    </div>

                    <div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>

                </div>
            </div>

            <div class="quadro-banner-2">
                <div class="owl-carousel owl-theme row">

                    <div class="item" style="background-image: url(<?php echo $foto['foto_unidade'] ?>);"></div>


                </div>
            </div>
        </section>
    </section>
</main>