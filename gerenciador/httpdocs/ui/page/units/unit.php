<!-- Container Begin -->
<div class="row">
    <div class="large-12 columns">
        <div class="box solaris-header">
            <div class="box-header bg-transparent">
                <h3 class="box-title">
                    <span><?php print(isset($data["idx"]) ? "Editar Unidade: " . $data["trade_name"] : "Cadastrar Unidade") ?></span>
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
                            <div class="header">Informações da Unidade</div>
                            <div class="large-4 columns">
                                <label>
                                    Razão Social:
                                    <input type="text" name="company_name" value="<?php print(isset($data["company_name"]) ? $data["company_name"] : "") ?>" required>
                                </label>
                            </div>

                            <div class="large-4 columns">
                                <label>
                                    Nome Fantasia:
                                    <input type="text" name="trade_name" value="<?php print(isset($data["trade_name"]) ? $data["trade_name"] : "") ?>" required>
                                </label>
                            </div>

                            <div class="large-4 columns">
                                <label>
                                    CNPJ:
                                    <input type="text" name="cnpj" value="<?php print(isset($data["cnpj"]) ? $data["cnpj"] : "") ?>" required>
                                </label>
                            </div>

                            <div class="large-4 columns">
                                <label>
                                    Telefone:
                                    <input type="text" name="phone" value="<?php print(isset($data["phone"]) ? $data["phone"] : "") ?>" required>
                                </label>
                            </div>

                            <div class="large-4 columns">
                                <label>
                                    Celular:
                                    <input type="text" name="celphone" value="<?php print(isset($data["celphone"]) ? $data["celphone"] : "") ?>" required>
                                </label>
                            </div>

                            <div class="large-4 columns">
                                <label>
                                    E-mail:
                                    <input type="text" name="mail" value="<?php print(isset($data["mail"]) ? $data["mail"] : "") ?>" required>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex;justify-content: space-evenly; padding-top:15px">
                        <div class="large-12 columns bxs_user">
                            <div class="header">Informações de Endereço</div>
                            <div class="large-4 columns">
                                <label>
                                    CEP:
                                    <input type="text" name="postalcode" value="<?php print(isset($data["postalcode"]) ? $data["postalcode"] : "") ?>" required>
                                </label>
                            </div>

                            <div class="large-4 columns">
                                <label>
                                    Endereço:
                                    <input type="text" name="address" value="<?php print(isset($data["address"]) ? $data["address"] : "") ?>" required>
                                </label>
                            </div>

                            <div class="large-4 columns">
                                <label>
                                    Numero:
                                    <input type="text" name="number" value="<?php print(isset($data["number"]) ? $data["number"] : "") ?>" required>
                                </label>
                            </div>

                            <div class="large-4 columns">
                                <label>
                                    Bairro:
                                    <input type="text" name="district" value="<?php print(isset($data["district"]) ? $data["district"] : "") ?>" required>
                                </label>
                            </div>

                            <div class="large-4 columns">
                                <label>
                                    Cidade:
                                    <input type="text" name="city" value="<?php print(isset($data["city"]) ? $data["city"] : "") ?>" required>
                                </label>
                            </div>

                            <div class="large-4 columns">
                                <label>
                                    UF
                                    <select name="uf" name="uf">
                                        <?php
                                        foreach ($GLOBALS["ufbr_lists"] as $k => $v) {
                                            printf('<option value="%s"%s>%s</option>' . "\n", $k, $data["uf"] == $k  ? ' selected="selected"' : '', $v);
                                        }
                                        ?>
                                    </select>
                                </label>
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