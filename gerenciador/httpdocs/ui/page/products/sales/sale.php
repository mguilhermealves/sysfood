<!-- Container Begin -->
<div class="row">
    <div class="large-12 columns">
        <div class="box solaris-header">
            <div class="box-header bg-transparent">
                <h3 class="box-title">
                    <span><?php print(isset($data["name"]) ? "Editar Venda Cruzada (Combo): " . $data["name"] : "Cadastrar Venda Cruzada (Combo)") ?></span>
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

                            <div class="large-6 columns">
                                <label>
                                    Nome:
                                    <input type="text" name="name" value="<?php print(isset($data["name"]) ? $data["name"] : "") ?>">
                                </label>
                            </div>

                            <div class="large-6 columns">
                                <label>
                                    Mês Referência:
                                    <select name="month" name="month">
                                        <option value="" <?php print(!isset($data["month"]) || $data["month"] == "" ? " selected" : "") ?>></option>
                                        <?php
                                        foreach ($GLOBALS['month_name'] as $k => $v) {
                                            printf('<option value="%s"%s>%s</option>' . "\n", $k, isset($data["month"]) && $data["month"] == $k ? ' selected="selected"' : '', $v);
                                        }
                                        ?>
                                    </select>
                                </label>
                            </div>

                            <div class="large-12 columns">
                                <table id="tbl_kpi_salecruzade" class="table">
                                    <thead>
                                        <tr>
                                            <th>Nome da Meta</th>
                                            <th>Ponto</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <td>
                                                <label>
                                                    <select id="name_goaltype" name="name_goaltype">
                                                        <option>Selecione</option>
                                                        <?php
                                                        foreach (goalstypes_controller::data4select("idx", array(" dic_type_front = 'goals' "), "name") as $k => $v) {
                                                            printf('<option value="%s">%s</option>' . "\n", $k, $v);
                                                        }
                                                        ?>
                                                    </select>
                                                </label>
                                            </td>
                                            <td><input type="number" id="point"></td>
                                            <td><button id="btn_add_goaltype" type="button" class="btn button success round"><i class="fontello-plus"></i> Adicionar</button></td>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    </tbody>
                                </table>
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