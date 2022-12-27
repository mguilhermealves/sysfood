<!-- Container Begin -->
<div class="row">
    <div class="large-12 columns">

        <div class="box solaris-header">
            <div class="box-header bg-transparent">
                <h3 class="box-title">
                    <span><?php print(isset($data["name"]) ? "Visualizar Importação de Meta: " . $data["name"] : "Cadastrar Importação de Meta") ?></span>
                </h3>
            </div>
        </div>

        <?php html_notification_print(); ?>

        <div class="box solaris-head">
            <div class="box-body">

                <?php if (isset($info["get"]["done"]) && !empty($info["get"]["done"])) { ?>
                    <input type="hidden" id="done" name="done" value="<?php print($info["get"]["done"]) ?>">
                <?php } ?>

                <?php if (empty($data)) { ?>
                    <div style="display: flex;justify-content: space-evenly; padding-top:15px">
                        <div class="large-12 columns bxs_user">
                            <div class="header">Importação</div>

                            <form action="<?php print($form["url"]) ?>" method="post" enctype="multipart/form-data">

                                <div class="large-6 columns">
                                    <label>
                                        <input type="file" name="plan" id="">
                                    </label>
                                </div>

                                <div class="large-6 columns">
                                    <label>
                                        <a href="<?php printf($GLOBALS["goals_imports_url"] . ".xls") ?>">Importar Modelo</a>
                                    </label>
                                </div>

                                <div class="large-12 columns" style="text-align: right;">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn button bg-gray round" id="enviarPlanilha" title="Nova Importação de Meta"><i class="icon-download"></i> Enviar Planilha</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } ?>

                <?php
                if (isset($listUsers) && count($listUsers) > 0) {

                    $listusersend = serialize($listUsers);
                ?>
                    <div style="display: flex;justify-content: space-evenly; padding-top:15px">
                        <div class="large-12 columns bxs_user">
                            <div class="header">Lista Importada de Metas</div>

                            <div class="large-12 columns textAreaNews">
                                <table class="table large-12 columns">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>CPF / CNPJ</th>
                                            <th>Tipo</th>
                                            <th>Pontuação</th>
                                            <th>Observações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($listUsers) && count($listUsers) > 0) {
                                            $listusersend = serialize($listUsers);

                                            $valor_total = 0;

                                            foreach ($listUsers as $v) {

                                                $valor_total += (float)$v['pontuacao'];

                                        ?>
                                                <tr>
                                                    <td><?php print($v["nome"]) ?></td>
                                                    <td><?php print($v["cpf"]) ?></td>
                                                    <td><?php print($v["tipo"]) ?></td>
                                                    <td><?php print($v["pontuacao"]) ?></td>
                                                    <td><?php print($v["obs"]) ?></td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3">Valor Total</td>
                                            <td><?php print($valor_total . " Pontos") ?></td>
                                            <td colspan="1"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                <?php } ?>

                <?php if (!empty($data["idx"])) { ?>
                    <div style="display: flex;justify-content: space-evenly; padding-top:15px">
                        <div class="large-12 columns bxs_user">
                            <div class="header">Lista Importada de Metas</div>

                            <div class="large-12 columns textAreaNews">
                                <table class="table large-12 columns">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>CPF / CNPJ</th>
                                            <th>Tipo</th>
                                            <th>Pontuação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $valor_total = 0;

                                        foreach ($data["goals_attach"] as $v) {
                                            $valor_total += (float)$v['points']; ?>
                                            <tr>
                                                <td><?php print($v["users_attach"][0]["first_name"]) ?></td>
                                                <td><?php print($v["users_attach"][0]["cpf"]) ?></td>
                                                <td><?php print($v["tipo"]) ?></td>
                                                <td><?php print($v["points"]) ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3">Valor Total</td>
                                            <td><?php print($valor_total . " Pontos") ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex;justify-content: space-evenly; padding-top:15px">
                        <div class="large-12 columns bxs_user">
                            <div class="header">Informações Adicionais</div>
                            <div class="large-6 columns">
                                <label>
                                    Titulo
                                    <input type="text" name="name" value="<?php print(isset($data["name"]) ? $data["name"] : "") ?>" disabled>
                                </label>
                            </div>

                            <div class="large-6 columns">
                                <label>
                                    Mês de Referência
                                    <select name="month" name="month" disabled>
                                        <option value="" <?php print(!isset($info["get"]["month"]) || $info["get"]["month"] == "" ? " selected" : "") ?>></option>
                                        <?php
                                        foreach ($GLOBALS["month_name"] as $k => $v) {
                                            printf('<option %s value="%s">%s</option>', isset($data["idx"]) && $k == $data["month"] ? ' selected' : '', $k, $v);
                                        }
                                        ?>
                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($listUsers) && count($listUsers) > 0) { ?>

                    <div style="display: flex;justify-content: space-evenly; padding-top:15px">
                        <div class="large-12 columns bxs_user">
                            <div class="header">Informações Adicionais</div>
                            <form action="<?php print($form["new"]) ?>" method="post" enctype="multipart/form-data">

                                <input type="hidden" name="listuser" value="<?php print(base64_encode($listusersend)); ?>" />
                                <input type="hidden" name="total" value="<?php print($valor_total); ?>" />

                                <div class="large-6 columns">
                                    <label>
                                        Titulo
                                        <input type="text" name="name" value="<?php print(isset($data["name"]) ? $data["name"] : "") ?>" required>
                                    </label>
                                </div>

                                <div class="large-6 columns">
                                    <label>
                                        Mês de Referência
                                        <select name="month" name="month" required>
                                            <option value="" <?php print(!isset($info["get"]["month"]) || $info["get"]["month"] == "" ? " selected" : "") ?>></option>
                                            <?php
                                            foreach ($GLOBALS["month_name"] as $k => $v) {
                                                printf('<option %s value="%s">%s</option>', isset($data["idx"]) && $k == $data["month"] ? ' selected' : '', $k, $v);
                                            }
                                            ?>
                                        </select>
                                    </label>
                                </div>

                                <div class="large-12 columns">
                                    <div style="display: flex;justify-content: space-evenly; padding-top:15px">
                                        <div class="large-6 columns">
                                            <button type="button" class="round hollow button secondary" name="btn_back">Voltar</button>
                                        </div>

                                        <?php if ($aprovado == true) { ?>
                                            <div class="large-6 columns">
                                                <button type="submit" class="pull-right round hollow button secondary" name="btn_save">Salvar</button>
                                            </div>
                                        <?php } else { ?>
                                            <div class="large-6 columns">

                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                <?php } ?>
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