<!-- Container Begin -->
<div class="row">
    <div class="large-12 columns" >
        <div class="box solaris-header">
            <div class="box-header bg-transparent">
                <h3 class="box-title">
                    <span>Usuários</span>
                </h3>
            </div>
        </div>
        <div class="box solaris-head">
            <div class="box-body" style="padding-left:0px;padding-right:0px;">
                <form class="row_js" style="flex-wrap: wrap; justify-content: flex-start; padding-top: 2rem;" id="frm_filter" method="GET" action="<?php print( $GLOBALS["users_url"] ) ?>">
                    <div class="large-3 columns">
                        <label>
                            Nome
                            <input type="text"  name="filter_first_name" value="<?php print( isset( $info["get"]["filter_first_name"] ) ? $info["get"]["filter_first_name"] : "" ) ?>">
                        </label>
                    </div>
                    <div class="large-3 columns">
                        <label>
                            Sobrenome
                            <input type="text"  name="filter_last_name" value="<?php print( isset( $info["get"]["filter_last_name"] ) ? $info["get"]["filter_last_name"] : "" ) ?>">
                        </label>
                    </div>
                    <div class="large-3 columns">
                        <label>
                            CPF
                            <input type="text" name="filter_cpf" value="<?php print( isset( $info["get"]["filter_last_name"] ) ? preg_replace("/(.+)(...)(...)(..)$/","$1.$2.$3-$4", preg_replace("/\D+?/","",$info["get"]["filter_cpf"] ) ) : "" ) ?>">
                        </label>
                    </div>
                    <div class="large-3 columns">
                        <label>
                            E-mail
                            <input type="text"  name="filter_mail" value="<?php print( isset( $info["get"]["filter_mail"] ) ? $info["get"]["filter_mail"] : "" ) ?>">
                        </label>
                    </div>

                    <div class="large-3 columns">
                        <label>
                            Cód. MTRIX
                            <input type="text"  name="filter_mtrix" value="<?php print( isset( $info["get"]["filter_mtrix"] ) ? $info["get"]["filter_mtrix"] : "" ) ?>">
                        </label>
                    </div>

                    <div class="large-3 columns">
                        <label>
                            Perfil
                            <select name="filter_profile">
                                <option value="" <?php print( !isset( $info["get"]["filter_profile"] ) || $info["get"]["filter_profile"] == "" ? " selected" : "" ) ?>></option>
                                <?php 
                                foreach( $profilesLists as $k => $v ){
                                    printf('<option value="%s"%s>%s</option>'."\n" , $k , isset( $info["get"]["filter_profile"] ) && $info["get"]["filter_profile"] == $k ? ' selected="selected"' : '' , $v);
                                }
                                ?>
                            </select>
                        </label>
                    </div>

                    <div class="large-3 columns">
                        <label>
                            Unidades
                            <select name="filter_rules" name="filter_rules">
                                <option value="" <?php print(!isset($info["get"]["filter_rules"]) || $info["get"]["filter_rules"] == "" ? " selected" : "") ?>></option>
                                <?php
                                foreach ($unitsList as $k => $v) {
                                    printf('<option value="%s"%s>%s</option>' . "\n", $k, isset($info["get"]["filter_rules"]) && $info["get"]["filter_rules"] == $k ? ' selected="selected"' : '', $v);
                                }
                                ?>
                            </select>
                        </label>
                    </div>

                    <div class="large-7 columns" style=" display: flex; justify-content: space-around; align-items: center;">
                        <button type="submit" class="btn button info round" style="white-space:nowrap"><i class="fontello-search"></i> Filtrar</button>
                        <a class="btn button bg-gray round" title="Incluir" href="<?php print( $form["pattern"]["new"] ) ?>" style="white-space:nowrap"><i class="fontello-plus"></i> Novo Usuário</a>
                        <button id="export_xls" type="button" class="btn button success round" style="white-space:nowrap"><i class="fontello-print"></i> Exportar XLS</button>
                    </div>
                </form>
                <div id="solaris-head-data"></div>
            </div>
        </div>
    </div>
</div>
<style>
    .row_js{ justify-content: space-around;flex-direction: row; display: flex; margin: 5px auto;width:95%; border:1px solid #707070; border-radius:7px; padding:0px 5px }
    .row_js .cell{ text-align:left; padding:5px; border-right: 1px solid #c0c0c0; width:100% }
    .row_js .cell_last{ border-right: none; }
    .row_js_header{ padding:10px 5px; font-weight: bold }

    .row_js .table_data_footer{ display: flex; flex-direction: row; align-items: baseline; }
    #per_page{ max-width: 100px; align-items: baseline; }
    #paginate_control{ justify-content: space-around; font-size: 2rem; }
    #paginate_display{ justify-content: flex-end; }
    .row_js_header button i{ float: right; font-weight: bold }
    #paginate_control button{ width: 100%; background-color: #ffffff; color: #707070; text-align: center; font-weight: bold; }
    #paginate_control button:disabled{ background-color: #f0f0f0; color: #ffffff; border:none ; opacity: 0.5; }
</style>