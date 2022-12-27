<!-- Container Begin -->
<div class="row">
    <div class="large-12 columns">
        <div class="box solaris-header">
            <div class="box-header bg-transparent">
                <h3 class="box-title">
                    <span><?php print(isset($data["image"]) ? "Editar Musica: " . $data["image"] : "Cadastrar Musica") ?></span>
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
                            <label>Imagem</label>                                    
                                <input class="" type="file" name="image">                     
                                <?php printf('<a href="/%s" target="_blank">[ ARQUIVO ]</a>' , $data["image"] );
                                 ?>
                            </div>
                            <div class="large-6 columns">
                            <label>Nome</label>                                    
                                <input type="text" name="nome" disabled value="<?php print(isset($data["nome"]) ? $data["nome"] : "") ?>">
                            </div>
                            <div class="large-6 columns">
                            <label>Raça</label>                                    
                                <input type="text" name="raca" disabled value="<?php print(isset($data["raca"]) ? $data["raca"] : "") ?>">
                            </div>
                            <div class="large-6 columns">
                            <label>Sexo</label>                                    
                                <input type="text" name="sexo" disabled value="<?php print(isset($data["sexo"]) ? $data["sexo"] : "") ?>">
                            </div>
                            <div class="large-6 columns">
                            <label>Idade</label>                                    
                                <input type="text" name="idade" disabled value="<?php print(isset($data["idade"]) ? $data["idade"] : "") ?>">
                            </div>
                            <div class="large-6 columns">
                            <label>Caracteristica</label>                                    
                                <input type="text" name="caracteristica" disabled value="<?php print(isset($data["caracteristica"]) ? $data["caracteristica"] : "") ?>">
                            </div>
                            
                            

                            <!-- <div class="large-12 columns">
                                <label>
                                    Selecione o Perfil:
                                    <br>
                                    <br>
                                    <?php

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
                                </label>
                            </div> -->
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