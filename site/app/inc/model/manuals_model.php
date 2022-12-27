<?php 
class manuals_model extends DOLModel{
	protected $field = array( " idx " , " created_at " , " created_by " , " modified_at " , "modified_by " , " name " , " description ", " description_ingles " , " video ", " manual_pdf ", " active ", "is_video", "video_file", "manual_img" ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "manuals" , $bd );
	}
} 
?>