<?php
namespace Manao\Test;

class Main{

	public function manaoTest(){
		$connection = \Bitrix\Main\Application::getConnection();
		$sqlHelper = $connection->getSqlHelper();
        
        $userLogin = "user"; //считываем логин пользователя из формы
        
        // include_once './SqlRequests.php';
        
        // $sql = SqlRequests::GET_EMAIL_BY_USER_LOGIN;
        $sql = "SELECT EMAIL FROM b_user WHERE LOGIN = '".$userLogin."';";
		$recordset = $connection->query($sql);

        $userEmail = $recordset->fetch()[EMAIL];

        // $sql = SqlRequests::GET_USER_GROUP_ID_BY_USER_LOGIN;
        $sql = "SELECT GROUP_ID FROM b_user_group WHERE USER_ID = (SELECT ID FROM b_user WHERE LOGIN = '".$userLogin."');";
        $recordset = $connection->query($sql);

        while ($record = $recordset->fetch()) {
            $userGroupId[] = $record[GROUP_ID];
		}

        

        if (!is_array($gid)) {
            if ($gid > 0) {
                $gid = array($gid);
            } else {
                $gid = array();
            }
        }
        // $policy = Bitrix\Main\UserTable\ CUser::GetGroupPolicy($gid);
        $length = $policy['PASSWORD_LENGTH'];
        if ($length <= 0) {
            $length = 6;
        }
        $chars = array(
            'abcdefghijklnmopqrstuvwxyz',
            'ABCDEFGHIJKLNMOPQRSTUVWXYZ',
            '0123456789',
        );
        if ($policy['PASSWORD_PUNCTUATION'] == 'Y') {
            $chars[] = ",.<>/?;:'\"[]{}\|`~!@#\$%^&*()-_+=";
        }

        $newPassword = randString($length+2, $chars);;
        echo $newPassword;
        
        // $sql = SqlRequests::SET_NEW_PASSWORD
        // $sql = "UPDATE b_user SET PASSWORD = '".$newPassword."' WHERE LOGIN = '".$login."';";
        // $connection->queryExecute($sql);
		
        mail($userEmail, "NewPassword", "You have a new password: ".$newPassword);

        // echo (randomPassword(2));
	}

}

?>