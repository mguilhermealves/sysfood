<!-- Container Begin -->
<div class="row">
    <div class="large-12 columns">
        <div class="box solaris-header">
            <div class="box-header bg-transparent">
                <h3 class="box-title">
                    <span><?php print(isset($data["first_name"]) ? "Editar Usuario: " . $data["first_name"] : "Cadastrar Usuario") ?></span>
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

                    <input type="hidden" id="users_profiles_id" value="<?php print($_SESSION[constant("cAppKey")]["credential"]["profiles_attach"][0]["idx"]) ?>">

                    <div style="display: flex;justify-content: space-evenly; padding-top:15px">
                        <div class="large-12 columns bxs_user">
                            <div class="header">Dados de Acesso</div>

                            <div class="large-12 columns">
                                <strong style="border-bottom: 1px solid #707070; margin-bottom: 15px; display: block;">Usuário</strong>
                            </div>

                            <div class="large-6 columns">
                                <label>
                                    Acesso Ativo
                                    <select idx="enabled" name="enabled">
                                        <option value="" <?php print($data["enabled"] == "" ? ' selected="selected"' : '') ?>></option>
                                        <?php
                                        foreach ($GLOBALS["yes_no_lists"] as $k => $v) {
                                            printf('<option value="%s"%s>%s</option>', $k, $data["enabled"] == $k  ? ' selected="selected"' : '', $v);
                                        }
                                        ?>
                                    </select>
                                </label>
                            </div>

                            <div class="large-6 columns">
                                <label>
                                    Perfil
                                    <select id="profiles_id" name="profiles_id" required="required">
                                        <option value="" <?php print(!isset($data["profiles_attach"][0]) ? ' selected' : '') ?>>-- Selecione --</option>
                                        <?php
                                        foreach ($profilesLists as $k => $v) {
                                            printf('<option value="%s"%s>%s</option>', $k, isset($data["profiles_attach"][0]) && $data["profiles_attach"][0]["idx"] == $k ? ' selected' : '', $v);
                                        }
                                        ?>
                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex;justify-content: space-evenly; padding-top:15px">
                        <div class="large-12 columns bxs_user">
                            <div class="header">Informações Pessoais</div>
                            <div class="large-3 columns">
                                <label>
                                    Nome
                                    <input type="text" name="first_name" value="<?php print(isset($data["first_name"]) ? $data["first_name"] : "") ?>">
                                </label>
                            </div>

                            <div class="large-3 columns">
                                <label>
                                    Sobrenome
                                    <input type="text" name="last_name" value="<?php print(isset($data["last_name"]) ? $data["last_name"] : "") ?>">
                                </label>
                            </div>

                            <div class="large-3 columns">
                                <label>
                                    CPF
                                    <input type="text" name="cpf" value="<?php print(isset($data["cpf"]) ? preg_replace("/(.+)(...)(...)(..)$/", "$1.$2.$3-$4", preg_replace("/\D+?/", "", $data["cpf"])) : "") ?>">
                                </label>
                            </div>

                            <div class="large-3 columns">
                                <label>
                                    E-mail
                                    <input type="text" name="mail" value="<?php print(isset($data["mail"]) ? $data["mail"] : "") ?>">
                                </label>
                            </div>

                            <div class="large-3 columns">
                                <label>
                                    Sexo
                                    <select name="genre" name="genre">
                                        <option value="" <?php print(!isset($data["genre"]) || $data["genre"] == "" ? ' selected="selected"' : '') ?>></option>
                                        <?php
                                        foreach ($GLOBALS["genre_lists"] as $k => $v) {
                                            printf('<option value="%s"%s>%s</option>' . "\n", $k, isset($data["genre"]) && $data["genre"] == $k  ? ' selected="selected"' : '', $v);
                                        }
                                        ?>
                                    </select>
                                </label>
                            </div>

                            <div class="large-3 columns">
                                <label>
                                    Telefone
                                    <input type="text" name="phone" value="<?php print(isset($data["phone"]) ? $data["phone"] : "") ?>">
                                </label>
                            </div>

                            <div class="large-3 columns">
                                <label>
                                    Celular
                                    <input type="text" name="celphone" value="<?php print(isset($data["celphone"]) ? $data["celphone"] : "") ?>">
                                </label>
                            </div>

                            <div class="large-3 columns">
                                <label>
                                    Unidades
                                    <select id="units_id" name="units_id">
                                        <option value="" <?php print(!isset($data["units_id"]) ? ' selected' : '') ?>>-- Selecione --</option>
                                        <?php
                                        foreach ($unitsList as $k => $v) {
                                            printf('<option value="%s"%s>%s</option>', $k, isset($data["units_id"]) && $data["units_id"] == $k ? ' selected' : '', $v);
                                        }
                                        ?>
                                    </select>
                                </label>
                            </div>

                            <div class="large-3 columns">
                                <label>
                                    Supervisor(a):
                                    <select id="parent" name="parent">
                                        <option value="" <?php print(!isset($data["parent"]) ? ' selected' : '') ?>>-- Selecione --</option>
                                        <?php
                                        foreach ($parentList as $k => $v) {
                                            printf('<option value="%s"%s>%s</option>', $v["idx"], isset($data["parent"]) && $data["parent"] == $v["idx"] ? ' selected' : '', $v["first_name"] . ' ' . $v["first_name"]);
                                        }
                                        ?>
                                    </select>
                                </label>
                            </div>

                            <div class="large-9 columns">

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
        border: 0 solid #2c3089;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        padding: 0px;
        border-radius: 9px;
    }

    .bxs_user .header {
        background-color: #f60;
        color: #FFFFFF;
        padding: 5px 5px;
        font-size: 1.52rem;
        border-radius: 5px;
        padding: 10px;
        text-align: center;
        margin-bottom: 10px;
    }
</style>