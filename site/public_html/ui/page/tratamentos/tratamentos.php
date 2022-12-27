<section class="home">
    <div class="quadro-geral-giolaser quadro-interno">
        <section class="banner-interno padding-50" style="background-image: url(https://www.giolaser.com.br/wp-content/uploads/2021/02/bg-rosa.jpg);">
            <div class="container-fluid">
                <div class="row">
                    <div class="container">
                        <div class="row align-items-center mx-auto">
                            <div class="col-md-12 mx-auto text-center">
                                <h1>
                                    Descubra o tratamento ideal para você!
                                </h1>

                                <div class="info-post">
                                    <form method="get" action="<?php print($GLOBALS["pesquisaTratamentos_url"]) ?>" id="searchTratament" class="form-inline info-post-search">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="typestreatmentsName" id="typestreatmentsName" placeholder="Pesquisar por...">
                                        </div>

                                        <select name="typestreatmentsId" id="typestreatmentsId" class="form-control mx-auto">
                                            <option value="all">Todos os Procedimentos</option>
                                            <?php
                                            foreach (typestreatments_controller::data4select("slug", array(" active = 'yes' ")) as $k => $v) {
                                                printf('<option value="%s"%s>%s</option>' . "\n", $k, isset($data["units_attach"][0]["idx"]) && $data["units_attach"][0]["idx"] == $k ? ' selected="selected"' : '', $v);
                                            } ?>
                                        </select>

                                        <input type="submit" class="mx-auto btn btn-success" id="" value="Buscar">
                                    </form>
                                </div>

                                <div class="btn-banner-interno margin-top-50 margin-bottom-50">
                                    <a href="/" class="btn btn-success">
                                        <i class="bi bi-house-door-fill"></i>
                                        Voltar para home
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="conteudo-interno section-archive">
            <div class="container">
                <div class="row align-items-center">
                    <?php foreach ($treatments->data as $treatment) { ?>
                        <div class="loop-1 col-md-4">
                            <div class="loop-vermais text-center">
                                <a href="/tratamentos/peeling-quimico">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                            <article class="text-left">
                                <h2><?php print($treatment["name"]) ?></h2>
                            </article>
                            <span class="tipo-tratamento mx-auto"> <?php print($treatment["typestreatments_attach"][0]["name"]) ?> </span>
                            <div class="div-img" style="background-image: url(360);"></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    </div>


    <div class="nav-social">
        <a target="_blank" class="facebook" href="https://www.facebook.com/dermolasereesteticaoficial/"> <i class="bi bi-facebook"></i></a>
        <a target="_blank" class="instagram" href="https://www.instagram.com/dermolaseroficial/"> <i class="bi bi-instagram"></i></a>
    </div>
    <div class="whatsapp-icon" style="">
        <a href="https://api.whatsapp.com/send?phone=5515998341441" target="_blank">
            <img src="https://www.giolaser.com.br/wp-content/uploads/2022/05/whatsapp.png">
        </a>
    </div>
</section>