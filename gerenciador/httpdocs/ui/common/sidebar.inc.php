<!-- Menu sidebar begin-->
<div class="side-bar">
    <ul id="menu-showhide" class="topnav slicknav">
        <li>
            <a <?php print( ! isset( $page ) || in_array( $page , array("dashboard") , true ) ? 'id="menu-select" class="tooltip-tip active"' : ' class="tooltip-tip"' ) ?> href="<?php print( $GLOBALS["home_url"] ) ?>" title="Dashboard">
                <i class="icon-monitor"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <?php
        $b = new menus_model();
        $b->set_filter( array( " parent = -1 " , " idx in ( select menus_profiles.menus_id from menus_profiles where menus_profiles.active = 'yes' and menus_profiles.profiles_id in ('" . implode("','", isset( $_SESSION[ constant("cAppKey") ]["credential"]["profiles_attach"][0] ) ? array_column( $_SESSION[ constant("cAppKey") ]["credential"]["profiles_attach"] , "idx" ) : array(0) )  . "') ) " ) ) ;
        $b->load_data();
        $b->attach( array( "urls" ) );
        $b->join("menus" , "menus" , array( "parent" => "idx" ) , " and idx in ( select menus_profiles.menus_id from menus_profiles where menus_profiles.active = 'yes' and menus_profiles.profiles_id in ('" . implode("','", isset( $_SESSION[ constant("cAppKey") ]["credential"]["profiles_attach"][0] ) ? array_column( $_SESSION[ constant("cAppKey") ]["credential"]["profiles_attach"] , "idx" ) : array(0) )  . "') ) " );
        $b->attach_son("menus", array("urls") );

        foreach( $b->data as $v ){
            print("<li>");
            if( isset( $v["menus_attach"][0] ) ){
        ?>
            <a <?php print( isset( $page ) && in_array( $page , array_column( $v["menus_attach"] , "name" ) , true ) ? 'id="menu-select" class="tooltip-tip active"' : ' class="tooltip-tip"' ) ?> href="#">
                <i class="<?php print( $v["image"] ) ?>"></i>
                <span><?php print( $v["name"] ) ?></span>
            </a>
            <ul style="border-radius: 0px; padding: 15px 15px; <?php print( isset( $page ) && in_array( $page , array_column( $v["menus_attach"] , "name" ) , true ) ? ' display: block;' : ' display: none;' ) ?> ">
                <?php foreach( $v["menus_attach"] as $r ){ ?>
                <li>
                    <a <?php print( isset( $page ) && in_array( $page , array( $r["name"] ) , true ) ? 'id="menu-select" class="tooltip-tip active"' : ' class="tooltip-tip"' ) ?>  class="tooltip-tip" href="<?php print( $GLOBALS[ $r["urls_attach"][0]["slug"] . "_url"] ) ?>" title="<?php print( $r["name"] ) ?>">
                        <i class="<?php print( $r["image"] ) ?>"></i>
                        <span><?php print( $r["name"] ) ?></span>
                    </a>
                </li>
                <?php
                    }
                ?>
            </ul>
        <?php
            }
            else{
        ?>
            <a <?php print( isset( $page ) && in_array( $page , array( $v["name"] ) , true ) ? 'id="menu-select" class="tooltip-tip active"' : ' class="tooltip-tip"' ) ?>  class="tooltip-tip" href="<?php print( $GLOBALS[ $v["urls_attach"][0]["slug"] . "_url"] ) ?>" title="<?php print( $v["name"] ) ?>">
                <i class="<?php print( $v["image"] ) ?>"></i>
                <span><?php print( $v["name"] ) ?></span>
            </a>
        <?php
            }
            print('</li>');
        }
        ?>    
    </ul>
</div>
<!-- end of Menu sidebar  -->