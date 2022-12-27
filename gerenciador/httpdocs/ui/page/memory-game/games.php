<!-- Container Begin -->
<div class="row">
    <div class="large-12 columns">
        <div class="box solaris-header">
            <div class="box-header bg-transparent">
                <h3 class="box-title">
                    <span>Relatório - Jogo da Memória</span>
                </h3>
            </div>
        </div>
        <div class="box solaris-head">
            <div class="box-body" style="padding-left:0px;padding-right:0px;">
                <?php
                include(constant("cRootServer") . "ui/common/resume.php");
                ?>
                <form class="row_js" style="flex-wrap: wrap; justify-content: flex-start; padding-top: 2rem;" id="frm_filter" method="GET" action="<?php print($GLOBALS["games_url"]) ?>" style="display: flex;flex-direction: row;justify-content: space-around;align-items: flex-end;">

                    <div class="large-2 columns">
                        <label>
                            Data Inicial:
                            <input type="date" name="filter_start_date" value="<?php print(isset($info["get"]["filter_start_date"]) ? $info["get"]["filter_start_date"] : "") ?>">
                        </label>
                    </div>

                    <div class="large-2 columns">
                        <label>
                            Data Final:
                            <input type="date" name="filter_end_date" value="<?php print(isset($info["get"]["filter_end_date"]) ? $info["get"]["filter_end_date"] : "") ?>">
                        </label>
                    </div>

                    <div class="large-2 columns">
                        <label>
                            CPF
                            <input type="text" name="filter_cpf" value="<?php print(isset($info["get"]["filter_cpf"]) ? $info["get"]["filter_cpf"] : "") ?>">
                        </label>
                    </div>

                    <div class="large-2 columns">
                        <label>
                            Mês de Referência
                            <select name="filter_month_ref" name="filter_month_ref">
                                <option value="" <?php print(!isset($info["get"]["filter_month_ref"]) || $info["get"]["filter_month_ref"] == "" ? " selected" : "") ?>></option>
                                <?php
                                foreach (array_filter(games_controller::data4select("DATE_FORMAT( end_at , '%Y%m' ) as q", array("active = 'yes' ", " finished = 'yes' ", "TIMEDIFF( modified_at , created_at) != '00:00:00' "), "DATE_FORMAT( end_at , '%Y%m' ) as q")) as $k => $v) {
                                    printf('<option %s value="%s">%s</option>', isset($info["get"]["filter_month_ref"]) && $k == $info["get"]["filter_month_ref"] ? ' selected' : '', $k, $v);
                                }
                                ?>
                            </select>
                        </label>
                    </div>

                    <div style="position: relative; top: 20px; left: 20px;">
                        <button type="submit" class="btn button info round"><i class="fontello-search"></i> Filtrar</button>
                        <a class="btn button bg-gray round" title="Incluir" href="<?php print($form["pattern"]["export"]) ?>"><i class="fontello-print"></i> Exportar Relatório</a>
                    </div>
                </form>
                <div id="solaris-head-data"></div>
            </div>
        </div>
    </div>
</div>
<style>
    .row_js {
        justify-content: space-around;
        flex-direction: row;
        display: flex;
        margin: 5px auto;
        width: 95%;
        border: 1px solid #707070;
        border-radius: 7px;
        padding: 0px 5px
    }

    .row_js .cell {
        text-align: left;
        padding: 5px;
        border-right: 1px solid #c0c0c0;
        width: 100%
    }

    .row_js .cell_last {
        border-right: none;
    }

    .row_js_header {
        padding: 10px 5px;
        font-weight: bold
    }

    .row_js .table_data_footer {
        display: flex;
        flex-direction: row;
        align-items: baseline;
    }

    #per_page {
        max-width: 100px;
        align-items: baseline;
    }

    #paginate_control {
        justify-content: space-around;
        font-size: 2rem;
    }

    #paginate_display {
        justify-content: flex-end;
    }

    .row_js_header button i {
        float: right;
        font-weight: bold
    }

    #paginate_control button {
        width: 100%;
        background-color: #ffffff;
        color: #707070;
        text-align: center;
        font-weight: bold;
    }

    #paginate_control button:disabled {
        background-color: #f0f0f0;
        color: #ffffff;
        border: none;
        opacity: 0.5;
    }
</style>