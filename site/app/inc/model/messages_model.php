<?php
class messages_model extends DOLModel {
	protected $field = array(" idx " , " name " , " scheduled_at " , " sent_at " , " error_msg " , " mailboxes " , " htmlmsg " , " textmsg " , " attachs " , " type " ) ;
	protected $filter = array( " active = 'yes' " ) ;
	function __construct( $bd = false  ) {
		return parent::__construct( "messages" , $bd );
	}
}
?>