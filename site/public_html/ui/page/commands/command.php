<section class="content-header">
    <h1>
        <?php print(constant("cTitle")) ?>
        <small>Comanda da <?php print($data["name"]) ?></small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="<?php print($GLOBALS["manuals_url"]) ?>"><?php print($pages); ?> </a></li>
        <li class="active"><?php print($page); ?></li>
    </ol> -->
</section>

<section class="content">
    <div class="row">
        <div class="container-fluid">
            <div class="box-body">
                <form action="<?php print($form["url"]) ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Dados da mesa -->
                        <div class="col-lg-6">
                            <div class="modal-content">
                                <div class="modal-header label">
                                    <h5 class="modal-title text-black">Dados da Mesa</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="name">Nome do Cliente:</label>
                                                    <input id="name" type="text" class="form-control" name="name" value="<?php print(isset($data["commands_attach"][0]) ? $data["commands_attach"][0]["client_name"] : "") ?>">
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="qtd_chairs">Quantidade de Lugares:</label>
                                                    <input id="qtd_chairs" type="number" class="form-control" name="qtd_chairs" min="0" max="<?php print($data["qtd_chairs"]) ?>" value="<?php print(isset($data["commands_attach"][0]["qtd_chairs"]) ? $data["commands_attach"][0]["qtd_chairs"] : "") ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Endereço do Imovel -->
                        <div class="col-lg-6">
                            <div class="modal-content">
                                <div class="modal-header label">
                                    <h5 class="modal-title ">Endereço do Imovel</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <ul class="nav nav-tabs" role="tablist">
                                                    <?php foreach ($categories->data as $category) { ?>
                                                        <li role="presentation" class="<?php print($category["idx"] == 1 ? "active" : "") ?>"><a href="#<?php print($category["idx"]) ?>" aria-controls="<?php print($category["idx"]) ?>" role="tab" data-toggle="tab"><?php print($category["name"]) ?></a></li>
                                                    <?php } ?>
                                                </ul>

                                                <!-- Tab panes -->
                                                <div class="tab-content">
                                                    <?php foreach ($categories->data as $category) { ?>
                                                        <div role="tabpanel" class="tab-pane <?php print($category["idx"] == 1 ? "active" : "") ?>" id="<?php print($category["idx"]) ?>">
                                                            <div class="box box-primary">
                                                                <div class="box-body">
                                                                <?php print($category["name"]) ?>
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label for="name">Nome do Cliente:</label>
                                                                            <input id="name" type="text" class="form-control" name="name" value="<?php print(isset($data["commands_attach"][0]) ? $data["commands_attach"][0]["client_name"] : "") ?>">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label for="qtd_chairs">Quantidade de Lugares:</label>
                                                                            <input id="qtd_chairs" type="number" class="form-control" name="qtd_chairs" min="0" max="<?php print($data["qtd_chairs"]) ?>" value="<?php print(isset($data["commands_attach"][0]["qtd_chairs"]) ? $data["commands_attach"][0]["qtd_chairs"] : "") ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <button type="submit" name="btn_save" class="btn btn-primary btn-sm">Salvar Comanda</button>
                    </div>
                </form>
            </div>
        </div>
    </div>