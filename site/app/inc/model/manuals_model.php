<?php 
class manuals_model extends DOLModel{
	protected $field = array( " idx " , " created_at " , " created_by " , " modified_at " , "modified_by " , " name " , "manual_pdf", " description " , " description_ingles " , " video ", " active ", "video_file", "is_video", "manual_img" ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "manuals" , $bd );
	}
} 
?>