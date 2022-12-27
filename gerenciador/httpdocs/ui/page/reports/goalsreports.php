<!-- Container Begin -->
<div class="row">
    <div class="large-12 columns">
        <div class="box solaris-header">
            <div class="box-header bg-transparent">
                <h3 class="box-title">
                    <span>Relatórios de Metas</span>
                </h3>
            </div>
        </div>

        <div class="box solaris-head">
            <div class="box-body" style="padding-left:0px;padding-right:0px;">
                <?php include(constant("cRootServer") . "ui/common/resume.php"); ?>

                <form class="row_js" id="frm_filter" method="GET" action="<?php print($GLOBALS["goalsreports_url"]) ?>" style="display: flex;flex-direction: row;justify-content: space-around;align-items: flex-end;">
                    <div class="large-4 columns">
                        <label>
                            Cargos
                            <select name="filter_office" name="filter_office">
                                <option value="" <?php print(!isset($info["get"]["filter_office"]) || $info["get"]["filter_office"] == "" ? " selected" : "") ?>></option>
                                <?php
                                foreach (users_controller::data4select("position", array(" active = 'yes' ", " position is not null group by position "), "position") as $k => $v) {
                                    printf('<option value="%s"%s>%s</option>' . "\n", $k, isset($info["get"]["filter_office"]) && $info["get"]["filter_office"] == $k ? ' selected="selected"' : '', $v);
                                }
                                ?>
                            </select>
                        </label>
                    </div>

                    <div class="large-4 columns">
                        <label>
                            Distribuidores
                            <select name="filter_distributors" name="filter_distributors">
                                <option value="" <?php print(!isset($info["get"]["filter_distributors"]) || $info["get"]["filter_distributors"] == "" ? " selected" : "") ?>></option>
                                <?php
                                foreach (distributors_controller::data4select("name", array(" active = 'yes' ")) as $k => $v) {
                                    printf('<option value="%s"%s>%s</option>' . "\n", $k, isset($info["get"]["filter_distributors"]) && $info["get"]["filter_distributors"] == $k ? ' selected="selected"' : '', $v);
                                }
                                ?>
                            </select>
                        </label>
                    </div>

                    <div class="large-4 columns">
                        <label>
                            Mês de Referência
                            <select name="filter_month">
                                <option value="" <?php print(!isset($info["get"]["filter_month"]) || $info["get"]["filter_month"] == "" ? " selected" : "") ?>></option>
                                <?php
                                foreach ($GLOBALS["month_name"] as $k => $v) {
                                    printf('<option value="%s"%s>%s</option>' . "\n", $k, isset($info["get"]["filter_month"]) && $info["get"]["filter_month"] == $k ? ' selected="selected"' : '', $v);
                                }
                                ?>
                            </select>
                        </label>
                    </div>

                    <div style="position: relative; top: 20px; left: 20px;">
                        <button type="submit" class="btn button info round"><i class="fontello-search"></i> Filtrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .row_js {
        flex-wrap: wrap;
        justify-content: flex-start;
        flex-direction: row;
        display: flex;
        margin: 5px auto;
        width: 95%;
        border: 1px solid #707070;
        border-radius: 7px;
        padding: 10px;
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