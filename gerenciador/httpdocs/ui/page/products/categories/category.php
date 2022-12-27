<!-- Container Begin -->
<div class="row">
    <div class="large-12 columns">
        <div class="box solaris-header">
            <div class="box-header bg-transparent">
                <h3 class="box-title">
                    <span><?php print(isset($data["name"]) ? "Editar Produto: " . $data["name"] : "Cadastrar Produto") ?></span>
                </h3>
            </div>
        </div>
        <div class="box solaris-head">
            <div class="box-body">
                <form action="<?php print($form["url"]) ?>" method="post" enctype="multipart/form-data">
                    <?php
                    if (isset($info["get"]["done"]) && !empty($info["get"]["done"])) {
                    ?>
                        <input type="hidden" id="done" name="done" value="<?php print($info["get"]["done"]) ?>">
                    <?php
                    }
                    ?>
                    <div style="display: flex;justify-content: space-evenly; padding-top:15px">
                        <div class="large-12 columns bxs_user">
                            <div class="header">Informações:</div>

                            <div class="large-12 columns">
                                <label>
                                    Nome:
                                    <input type="text" name="name" value="<?php print(isset($data["name"]) ? $data["name"] : "") ?>">
                                </label>
                            </div>

                            <div class="large-12 columns textAreaNews">
                                <label>
                                    Texto
                                    <textarea rows="10" name="description" id="mytextarea"><?php print(isset($data["description"]) ? $data["description"] : "") ?></textarea>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex;justify-content: space-evenly; padding-top:15px">
                        <div class="large-12 columns bxs_user">
                            <div class="header">Fotos</div>

                            <div class="large-12 columns padding-bottom-20">

                                <label>
                                    Foto
                                </label>

                                <div class="uploader">
                                    <input type="file" id="file-upload" name="img" value="<?php print(isset($data["img"]) ? $data["img"] : "") ?>">

                                    <label for="file-upload" id="file-drag">
                                        <img id="file-image" src="<?php echo constant("cFrontend") . (isset($data["img"]) ? $data["img"] : ""); ?>" alt="Preview" class="<?php isset($data["img"]) ? "" : "hidden" ?>">
                                        <div id="start">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                            <div>Selecione o arquivo de Imagem ou Arraste uma imagem dentro da área</div>
                                            <div id="notimage" class="hidden">Selecione a imagem</div>
                                            <span id="file-upload-btn" class="btn btn-primary">Selecione a imagem</span>
                                        </div>
                                        <div id="response" class="hidden">
                                            <div id="messages"></div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div style="display: flex;justify-content: space-evenly; padding-top:15px">
                        <div class="large-4 columns">
                            <button type="button" class="round hollow button secondary" name="btn_back">Voltar</button>
                        </div>
                        <div class="large-7 columns">
                            <button type="submit" class="pull-right round hollow button secondary" name="btn_save">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .bxs_user {
        border: 1px solid #2c3089;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        padding: 0px;
    }

    .bxs_user .header {
        background-color: #2c3089;
        color: #FFFFFF;
        padding: 5px 5px;
        font-size: 1.52rem;
        /* text-align: center; */
        margin-bottom: 15px;
    }

    .textAreaNews {
        margin-bottom: 25px;
    }

    .jqte {
        border: none !important;
    }

    .jqte_editor,
    .jqte_source {
        resize: none !important;
    }

    #mytextarea {
        min-height: 200px;
    }
</style>