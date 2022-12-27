<!-- Container Begin -->
<div class="row">
    <div class="large-12 columns">
        <div class="box solaris-header">
            <div class="box-header bg-transparent">
                <h3 class="box-title">
                    <span><?php print(isset($data["name"]) ? "Editar Banner: " . $data["name"] : "Cadastrar Banner") ?></span>
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
                            <div class="header">Informações do Banner</div>
                            <div class="large-6 columns">
                                <label>
                                    Nome do Banner:
                                    <input type="text" name="name" value="<?php print(isset($data["name"]) ? $data["name"] : "") ?>" required>
                                </label>
                            </div>

                            <div class="large-12 columns padding-bottom-20">

                                <label>
                                    Imagem Banner
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

                            <div class="large-12 columns margin-top-20 margin-bottom-20">
                                <label>
                                    Selecione o Perfil:
                                </label>

                                <input type="hidden" id="profiles_id_1" name="profiles_id[]" value="1">
                                <input type="hidden" id="profiles_id_2" name="profiles_id[]" value="2">
                                <?php foreach ($profiles_lists as $k => $v) :
                                    $check = '';
                                    if (isset($data["profiles_attach"][0]) && in_array($k, array_column($data["profiles_attach"], "idx"))) {
                                        $check = 'checked="checked"';
                                    } ?>
                                    <label><input type="checkbox" id="<?php echo $k; ?>" name="profiles_id[]" value="<?php echo $k; ?>" <?php echo $check; ?> />
                                        <?php echo $v; ?></label>
                                <?php endforeach; ?>
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
        background-color: #f60;
        color: #FFFFFF;
        padding: 5px 5px;
        font-size: 1.52rem;
        text-align: center;
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