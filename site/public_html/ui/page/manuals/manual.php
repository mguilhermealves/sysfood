<main class="container-fluid">
    <section class="banners-products">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <img class="img-fluid" src="/furniture/images/products/banners.png">
                    <label id="texto-banners-products">
                        PRODUTO
                        <br>
                        <?php print($data['name']); ?>
                        <br>
                        Manual & Vídeo
                    </label>
                </div>
            </div>
        </div>
    </section>

    <section class="banners-products">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row margin-top-80 margin-bottom-80 padding-40 border-black">
                        <div class="col-12 col-sm-4 col-lg-4 col-xs-4 vertical-middle horizontal-center ">
                            <img class="img-fluid" src="/furniture/images/products/banners.png">
                        </div>

                        <div class="col-12 col-sm-4 col-lg-4 col-xs-4 vertical-middle horizontal-center">
                            <div class="row">
                                <div class="col-12 xs-margin-top-50">
                                    <h1 id="title-custom-products" class="xs-horizontal-center xs-margin-bottom-50"><?php print($data["name"]) ?></h1>
                                    <a name="" id="" class="btn btn-primary btn-custom-product" href="/<?php print(unserialize($data["manual_pdf"])) ?>" role="button" download> Download</a>
                                </div>
                                <div class="col-12 margin-top-40 xs-margin-top-50">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary btn-custom-product" data-toggle="modal" data-target="#videoManual_<?php print($data['idx']) ?>">Assistir o vídeo</button>

                                    <!-- Modal Video -->
                                    <div class="modal fade" id="videoManual_<?php print($data['idx']) ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-lg-12 text-center">
                                                                <iframe src="<?php print($data["video"]) ?>" width="640" height="360" frameborder="0" controls></iframe>
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

                        <div class="col-12 col-sm-4 col-lg-4 col-xs-4 vertical-middle horizontal-center xs-margin-top-50">
                            <p>
                                <?php print($data["description"]) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>