<!-- Container Begin -->
<div class="row">
    <div class="large-12 columns">
        <div class="box solaris-header">
            <div class="box-header bg-transparent">
                <h3 class="box-title">
                    <span><?php print(isset($data["name"]) ? "Editar Noticia: " . $data["name"] : "Cadastrar Noticia") ?></span>
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
                            <div class="header">Informações</div>
                            <div class="large-6 columns">
                                <label>
                                    Titulo
                                    <input type="text" name="name" value="<?php print(isset($data["name"]) ? $data["name"] : "") ?>">
                                </label>
                            </div>
                            <div class="large-6 columns">
                                <label>
                                    Categoria
                                    <input type="text" name="category" value="<?php print(isset($data["category"]) ? $data["category"] : "") ?>">
                                </label>
                            </div>
                            <div class="large-6 columns">
                                <label>
                                    Chamada
                                    <input type="text" name="headline" value="<?php print(isset($data["headline"]) ? $data["headline"] : "") ?>">
                                </label>
                            </div>
                            <div class="large-6 columns">
                                <label>
                                    image
                                    <input type="file" name="image_file">
                                </label>
                            </div>

                            <div class="large-12 columns textAreaNews">
                                <label>
                                    Texto
                                    <textarea rows="10" name="context" id="mytextarea"><?php print(isset($data["context"]) ? $data["context"] : "") ?></textarea>
                                </label>
                            </div>

                            <div class="large-12 columns">
                                <label>Selecione o Perfil:</label>                        
				
                                    <?php
		    foreach (profiles_controller::data4select("idx",array(" editabled = 'no' "), "name") as $k => $v){
                                    print( '<input type="hidden" name="profiles_id[]" value="' . $k  . '">');
		    }
                                    foreach ($profiles_lists as $k => $v) :
                                        $check = '';
                                        if (isset($data["profiles_attach"][0]) && in_array($k, array_column($data["profiles_attach"], "idx"))) {
                                            $check = 'checked="checked"';
                                        }
                                    ?>
                                        <input type="checkbox" id="<?php echo $k; ?>" name="profiles_id[]" value="<?php echo $k; ?>" <?php echo $check; ?> />
                                        <?php echo $v; ?>
                                    <?php
                                    endforeach;
                                    ?>                                
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

    .jqte_editor, .jqte_source {
        resize: none !important;
    }

    #mytextarea {
        min-height: 200px;
    }
</style>
