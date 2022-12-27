<?php
class ranking_controller{

    public static function position( $info ){
        $sql = "     SELECT  " ;
        $sql .= "         SUM(a.points) as  total " ;
        $sql .= "         , p.slug " ;
        $sql .= "         , u.* " ;
        $sql .= "     FROM " ;
        $sql .= "         ( " ;
        $sql .= "             ( " ;
        $sql .= "                 SELECT  " ;
        $sql .= "                     SUM(r.pontos) AS points, " ;
        $sql .= "                     r.created_by AS users_id, " ;
        $sql .= "                     DATE_FORMAT(r.created_at, '%Y%m') AS periodo " ;
        $sql .= "                 FROM " ;
        $sql .= "                     respostas r " ;
        $sql .= "                 where " ;
        $sql .= "                     r.active = 'yes' " ;
        if( isset( $info["period"] ) ){
            $sql .= "                   and DATE_FORMAT(r.created_at, '%Y%m') in (" . $info["period"] . ") " ;
        }
        $sql .= "                 GROUP BY r.created_by , DATE_FORMAT(r.created_at, '%Y%m') " ;
        $sql .= "             )  " ;
        $sql .= "             UNION ALL  " ;
        $sql .= "             ( " ;
        $sql .= "                 SELECT  " ;
        $sql .= "                     SUM(g.points) AS points, " ;
        $sql .= "                     gu.users_id, " ;
        $sql .= "                     DATE_FORMAT(g.created_at, '%Y%m') AS periodo " ;
        $sql .= "                 FROM " ;
        $sql .= "                     goals g, users_goals gu " ;
        $sql .= "                 WHERE " ;
        $sql .= "                     g.idx = gu.goals_id " ;
        $sql .= "                     and g.active = 'yes' " ;
        $sql .= "                     and gu.active = 'yes' " ;
        if( isset( $info["period"] ) ){
            $sql .= "                     and DATE_FORMAT(g.created_at, '%Y%m') in (" . $info["period"] . ") " ;
        }
        $sql .= "                 GROUP BY gu.users_id , DATE_FORMAT(g.created_at, '%Y%m') " ;
        $sql .= "             ) " ;
        $sql .= "         ) AS a " ;
        $sql .= "         inner join users u on (u.idx = a.users_id and u.position = '" . $info["position"] . "' ) " ;
        $sql .= "         inner join users_profiles up on ( up.users_id = u.idx and up.active = 'yes' ) " ;
        $sql .= "         inner join profiles p on ( up.profiles_id = p.idx and p.active = 'yes' and p.name = '" . $info["profile"] . "') " ;
        switch( $info["type"] ){
            case "tri":
                switch( $info["position"] ){
                    case 'Supervisor(a)':
                        $sql .= "         where u.regional = '" . $info["regional"] . "'" ;
                    break;
                    case 'Vendedor(a)':
                        $sql .= "         where u.distribuidora = '" . $info["distribuidora"] . "'" ;
                    break;
                    case 'Promotor(a)':
                        $sql .= "         where u.regional = '" . $info["regional"] . "'" ;
                    break;
                }
            break;
            default :
                switch( $info["position"] ){
                    case 'Vendedor(a)':
                        $sql .= "         where u.regional = '" . $info["regional"] . "'" ;
                    break;
                }
            break;
        }

        $sql .= "     GROUP BY a.users_id " ;
        $sql .= "     ORDER BY SUM(a.points) DESC , u.first_name asc " ;

        $users_model = new users_model();

        $pontos = $users_model->con->results( $users_model->con->my_query( $sql ) ) ;
        $resumo = array_flip( array_values( array_unique( array_column( $pontos , "total" ) ) ) );
        return  array( $resumo , $pontos , $sql );
    }


	public function tri( $info ){
        if( !site_controller::check_login() ){
            basic_redir( $GLOBALS["home_url"] );
            exit();
        }
        $rkn_1 = ranking_controller::position( array( "type" => "tri" , "period" => "'202104','202105','202106'" ) ) ;
        $rkn_2 = ranking_controller::position( array( "type" => "tri" , "period" => "'202107','202108','202109'" ) ) ;
        $rkn_3 = ranking_controller::position( array( "type" => "tri" , "period" => "'202110','202111','2021012'" ) ) ;
		include( constant("cRootServer") . "ui/common/header.php");
        include( constant("cRootServer") . "ui/common/head.php");
        include( constant("cRootServer") . "ui/includes/menuTopoOnline.php");
        include( constant("cRootServer") . "ui/page/ranking_tri.php");
        include( constant("cRootServer") . "ui/includes/footerOnline.php"); 
		include( constant("cRootServer") . "ui/common/foot.php");
		print('<script>'."\n");
		print('$("#period-input").bind("change", function(){'."\n");
		print('	$(".tbl1").hide();'."\n");
		print('	$(".tbl2").hide();'."\n");
		print('	$(".tbl3").hide();'."\n");
		print('	$(".tbl" + $("option:selected",this).val() ).show();'."\n");
		print('})'."\n");
		print('</script>'."\n");
		include( constant("cRootServer") . "ui/common/footer.php");
	}
	public function final( $info ){
        if( !site_controller::check_login() ){
            basic_redir( $GLOBALS["home_url"] );
            exit();
        }
        $rkn = ranking_controller::position( array( "type" => "anual" ) ) ;
		include( constant("cRootServer") . "ui/common/header.php");
        include( constant("cRootServer") . "ui/common/head.php");
        include( constant("cRootServer") . "ui/includes/menuTopoOnline.php");
        include( constant("cRootServer") . "ui/page/ranking_final.php");
        include( constant("cRootServer") . "ui/includes/footerOnline.php"); 
		include( constant("cRootServer") . "ui/common/foot.php");
		include( constant("cRootServer") . "ui/common/footer.php");
	}
}
?>