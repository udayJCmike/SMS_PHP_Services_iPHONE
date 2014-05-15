<?php
session_start();

require("../config.php");

$case = $_REQUEST['service'];

switch($case){

    case 'login':{

// print_r($_POST); exit;
        $username = $_POST['username'];
        $password = ($_POST['pswd']);
        $role=0;
// $username = mm001;
// $password = md5(001);

        $sql = "select * from login where username ='".$username."' AND password = '".$password."' AND role = '".$role."'";
        $query = mysql_query($sql);

        if(mysql_num_rows($query) > 0)
        {
            $row		= mysql_fetch_object($query);
            $sql1="select * from participants_table where participants_id= '".$row->login_id."'";
            $record=mysql_query($sql1);
            if(mysql_query($sql1))
            {
                $row1		= mysql_fetch_object($record);
            $json 		= '{ "serviceresponse" : { "servicename" : "Login Details", "success" : "Yes", "message" : "1", "messagestream" : "'.$row1->message.'", "userid" : "'.$row->login_id.'" } }';
            }
            else
            {
                $json		= '{ "serviceresponse" : { "servicename" : "Login Details", "success" : "No", "userid" : "NULL",  "message" : "'.$error.'" } }';
            }

        }
        else{
            $json		= '{ "serviceresponse" : { "servicename" : "Login Details", "success" : "No", "userid" : "NULL",  "message" : "'.$error.'" } }';
        }

        echo $json;
        break;
    }



}

exit;


?>
