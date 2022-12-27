<!-- Container Begin -->
<div class="row">
    <div class="large-12 columns" >
        <div class="box solaris-header">
            <div class="box-header bg-transparent">
                <h3 class="box-title">
                    <span><?php print( $form["title"] ) ?></span>
                </h3>
            </div>
        </div>
        <div class="box solaris-head">
            <div class="box-body">
                <form action="<?php print( $form["url"] ) ?>" method="post" enctype="multipart/form-data" >
                    <?php
                    if( isset( $info["get"]["done"] ) && !empty( $info["get"]["done"] ) ){
                    ?>
                    <input type="hidden" id="done" name="done" value="<?php print( $info["get"]["done"] ) ?>">
                    <?php
                    }
                    ?>
                    <div style="display: flex;justify-content: space-evenly; padding-top:15px">
                        <div class="large-12 columns bxs_user">
                            <div class="header">Dados</div>
                            <div class="large-3 columns padding-top-20">
                                <label>
                                    Nome
                                    <input type="text"  name="name" value="<?php print( isset( $data["name"] ) ? $data["name"] : "" ) ?>">
                                </label>
                            </div>

                            <div class="large-3 columns padding-top-20">
                                <label>
                                    Menu Pai
                                    <select name="parent">
                                        <option value="-1" <?php print( !isset( $data["parent"] ) || (int)$data["parent"] == -1 ? ' selected="selected"' : '' ) ?>>--- RAIZ ---</option>
                                        <?php foreach( menus_controller::data4select( "idx" , array( " parent = -1 " ) , "name" ) as $k => $v ){ ?>
                                        <option value="<?php print( $k ) ?>" <?php print( isset( $data["parent"] ) && (int)$data["parent"] == $k ? ' selected="selected"' : '' ) ?>><?php print( $v ) ?></option>
                                        <?php } ?>
                                    </select>
                                </label>
                            </div>

                            <div class="large-3 columns padding-top-20">
                                <label>
                                    Url
                                    <select name="urls_id">
                                        <option value="-1" <?php print( !isset( $data["urls_attach"] ) || ( isset( $data["urls_attach"][0] ) && (int)$data["urls_attach"][0]["idx"] == -1 ) ? ' selected="selected"' : '' ) ?>>Nenhuma</option>
                                        <?php foreach( urls_controller::data4select( "idx" , array( " idx > 0 " ) , "name" ) as $k => $v ){ ?>
                                        <option value="<?php print( $k ) ?>" <?php print( isset( $data["urls_attach"][0] ) && (int)$data["urls_attach"][0]["idx"] == $k ? ' selected="selected"' : '' ) ?>><?php print( $v ) ?></option>
                                        <?php } ?>
                                    </select>
                                </label>
                            </div>

                            <div class="large-3 columns padding-top-20">
                                <label>
                                    Icone
                                    <input type="text"  name="image" value="<?php print( isset( $data["image"] ) ? $data["image"] : "" ) ?>">
                                </label>
                            </div>
                            <div class="large-12 columns padding-top-20">
                                <label>
                                    Perfil Disponivel
                                </label>
                                <input type="hidden" name="profiles_id[1]" id="profiles_id[1]" value="1">
                                <?php foreach( profiles_controller::data4select("idx",array( " idx > 1 and adm = 'yes' order by hierarchy" ) ) as $k => $v ){ ?>
                                <label>
                                    <input name="profiles_id[<?php print( $k ) ?>]" id="profiles_id[<?php print( $k ) ?>]" type="checkbox" value="<?php print( $k ) ?>" <?php print( isset( $data["profiles_attach"][0] ) && in_array( $k , array_column( $data["profiles_attach"] , "idx" ) ) ? "checked" : "" ) ?>>
                                    <?php print( $v ) ?>
                                </label>
                                <?php } ?>
                            </div>             
                        </div>
                    </div>
                    <div style="display: flex;justify-content: space-evenly; padding-top:15px">
                        <div class="large-4 columns">
                            <a href="<?php print( $info["get"]["done"] ) ?>" class="round hollow button secondary" >Voltar</a>
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
    .bxs_user{
        border:1px solid #0A4C80; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;padding:0px
    }
    .bxs_user .header{ background-color:#0A4C80;color:#FFFFFF;padding: 5px 5px;font-size: 1.52rem; }
</style>