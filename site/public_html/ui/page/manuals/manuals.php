<section class="content-header">
    <h1>
        Dashboard
        <small>Painel de Controle</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Manuais</li>
    </ol>
</section>

<section class="content">
    <div class="row">

        <form class="col-lg-12 mb-4" id="frm_filter" method="GET" action="<?php print($form["pattern"]["search"]) ?>">
            <input type="hidden" name="paginate" id="paginate" value="<?php print($paginate) ?>">
            <input type="hidden" name="ordenation" id="ordenation" value="<?php print($ordenation) ?>">
            <input type="hidden" name="sr" id="sr" value="<?php print($info["sr"]) ?>">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="filter_name">Nome do Manual:</label>
                        <input type="text" id="filter_name" class="form-control" name="filter_name" value="<?php print(isset($info["get"]["filter_name"]) ? $info["get"]["filter_name"] : "") ?>" class="MuiInputBase-input form-control" placeholder="Digite o Nome">
                    </div>
                </div>

                <div class="col-sm-2">

                </div>

                <div class="col-sm-2">
                    <label for="btn_search">&nbsp;</label>
                    <button id="btn_search" type="submit" class="btn btn-primary btn-block btn-sm"><i class="bi bi-search"></i> Filtrar</button>
                </div>
                <div class="col-sm-2">
                    <label for="btn_add">&nbsp;</label>
                    <a id="btn_add" class="btn btn-primary btn-block btn-sm" title="Adicionar" href="<?php print($form["pattern"]["new"]) ?>"><i class="bi bi-plus-circle"></i> Novo Manual</a>
                </div>
            </div>
        </form>

        <div class="col-lg-12" style="overflow: auto;">
            <?php html_notification_print(); ?>

            <table class="table table-striped table-inverse table-hover">
                <thead class="thead-inverse">
                    <tr>
                        <th><a style="color:#707070; text-decoration:none" href="<?php print(set_url($form["pattern"]["search"], array("ordenation" => $ordenation_idx))) ?>">Código <i class="<?php print($ordenation_idx_ordenation) ?>"></i></a></th>
                        <th><a style="color:#707070; text-decoration:none" href="<?php print(set_url($form["pattern"]["search"], array("ordenation" => $ordenation_name))) ?>">Nome <i class="<?php print($ordenation_name_ordenation) ?>"></i></a></th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="3">
                            <div class="row col-lg-12">
                                <div class="col-lg-3 form-group">
                                    <select class="form-control" id="select_paginage" class="col-lg-3 ">
                                        <option <?php print($paginate == 20 ? 'selected="selected"' : '') ?> value="20">20</option>
                                        <option <?php print($paginate == 50 ? 'selected="selected"' : '') ?> value="50">50</option>
                                        <option <?php print($paginate == 100 ? 'selected="selected"' : '') ?> value="100">100</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 d-flex justify-content-center form-group text-center">
                                    <button type="button" id="btn_sr_first" class=" btn ">|<< /button>
                                            <button type="button" id="btn_sr_previus" class=" btn ">
                                                << /button>
                                                    <button type="button" id="btn_sr_next" class=" btn ">></button>
                                                    <button type="button" id="btn_sr_last" class=" btn ">>|</button>
                                </div>
                                <p class="col-lg-3 text-right"><?php print(($info["sr"] + 1) . " de " . $total) ?></p>
                            </div>
                        </th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    if ($total > 0) {
                        foreach ($data as $v) { ?>
                            <tr>
                                <td><?php print($v["idx"]); ?></td>
                                <td><?php print($v["name"]); ?></td>
                                <th>
                                    <a type="button" class="btn btn-primary btn-sm" href="<?php print(set_url(sprintf($form["pattern"]["action"], $v["idx"]), array("done" => urlencode($form["pattern"]["search"])))) ?>"><i class="bi bi-pencil-square"></i> Editar</a>
                                </th>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="3">
                                <p class="alert alert-warning text-center">Nenhum qrcode encontrado...</p>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<script>
    //export
    window.setTimeout(function() {
        jQuery("#btn_export").on("click", function() {
            jQuery("#frm_filter").prop({
                "action": "<?php print(set_url($GLOBALS["products_url"] . ".xls", $info["get"])) ?>"
            }).submit();
        })
    }, 1000);

    //filter
    window.setTimeout(function() {
        jQuery("#btn_search").on("click", function() {
            jQuery("#frm_filter").prop({
                "action": "<?php print(set_url($GLOBALS["products_url"])) ?>"
            }).submit();
        })
    }, 1000);
</script>

<style>
    .card-header {
        cursor: pointer;
    }

    .card-header .fa-chevron-up {
        display: none;
    }

    .card-header.collapsed .fa-chevron-up {
        display: inline-block;
    }

    .card-header.collapsed .fa-chevron-down {
        display: none;
    }

    .text-blue {
        color: blue !important;
    }
</style>