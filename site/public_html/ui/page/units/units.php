<section class="unidades">


    <section class="container-fluid galeria-home text-center">
        <h1 class="titulo-padrao-b">Conheça a DermoLaser</h1>

        <div class="quadro-banner-2">
            <div class="owl-carousel owl-theme row">
                <div class="item" style="background-image: url(https://dermolasergrupo.com.br/wp-content/uploads/2022/10/IMG_20220722_150023-1-scaled.jpg);"></div>
                <div class="item" style="background-image: url(https://dermolasergrupo.com.br/wp-content/uploads/2022/10/IMG_20220722_150503-1-scaled.jpg);"></div>
                <div class="item" style="background-image: url(https://dermolasergrupo.com.br/wp-content/uploads/2022/10/IMG_20220722_152731-1.jpg);"></div>
                <div class="item" style="background-image: url(https://dermolasergrupo.com.br/wp-content/uploads/2022/10/IMG_20220722_152818-scaled.jpg);"></div>
                <div class="item" style="background-image: url(https://dermolasergrupo.com.br/wp-content/uploads/2022/10/IMG_20220809_141202-scaled.jpg);"></div>
            </div>
        </div>
    </section>

    <section class="conteudo-interno" id="listagem_unidades">
        <div class="container text-center">
            <div class="row align-self-center listagem-unidades">
                <?php foreach ($units->data as $unidade) { ?>
                    <div class="col-md-4 loop-3 box-unidade">
                        <div class="card card-blog">
                            <div class="table">
                                <h4 class="t-degr-pink card-description nome padding-bottom-10">&nbsp;<?php print($unidade["trade_name"]) ?></h4>

                                <p class="card-description endereco padding-bottom-10">
                                    <i class="bi bi-geo-alt txt-pink"></i>&nbsp;<?php print($unidade["address"]) ?>
                                </p>

                                <p class="card-description telefone padding-bottom-10">
                                    <a href="tel:<?php print($unidade["phone"]) ?>">
                                        <i class="bi bi-telephone-outbound-fill"></i>
                                        &nbsp;<?php print($unidade["phone"]) ?> </a>
                                </p>
                                <p class="card-description celular padding-bottom-10">
                                    <a target="_blank" class="unidade-whatsapp" href="https://api.whatsapp.com/send?phone=55<?php print($unidade["celphone"]) ?>">
                                        <i class="bi bi-whatsapp"></i>&nbsp;
                                        <?php print($unidade["celphone"]) ?> </a>
                                </p>
                                <p class="card-description email padding-bottom-10">
                                    <a target="_blank" style="word-break: break-all;" href="mailto:<?php print($unidade["mail"]) ?>">
                                        <i class="bi bi-envelope"></i>&nbsp;
                                        <?php print($unidade["mail"]) ?></a>
                                </p>
                                <p class="card-description redes-sociais">
                                    <a class="facebook" target="_blank" href="https://www.facebook.com/dermolasereesteticaoficial/">
                                        <i class="bi bi-facebook"></i>
                                    </a>
                                    |
                                    <a class="instagram" target="_blank" href="https://www.instagram.com/dermolaseroficial/">
                                        <i class="bi bi-instagram"></i>
                                    </a>
                                    |
                                    <a class="celular" target="_blank" href="https://api.whatsapp.com/send?phone=55<?php print($unidade["celphone"]) ?>">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                </p>
                            </div>
                            <div class="card-footer text-center">
                                <a href="/unidade/<?php print($unidade["idx"]) ?>" class="btn btn-primary btn-pink visitar-site"><i class="bi bi-calendar-plus"></i> Visitar o site</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>