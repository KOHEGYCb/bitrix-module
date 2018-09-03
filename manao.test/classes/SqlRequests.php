<?php

Class SqlRequests{
	
	public static $GET_USER_GROUP_ID_BY_USER_LOGIN = "SELECT GROUP_ID FROM b_user_group WHERE USER_ID = (SELECT ID FROM b_user WHERE LOGIN = '".$userLogin."');"
	public static $SET_NEW_PASSWORD = "UPDATE b_user SET PASSWORD = '".$newPassword."' WHERE LOGIN = '".$login."';";
	public static $GET_EMAIL_BY_USER_LOGIN = "SELECT EMAIL FROM b_user WHERE LOGIN = '".$login."';";

}

?>