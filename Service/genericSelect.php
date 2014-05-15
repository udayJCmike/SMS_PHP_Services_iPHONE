<?php
/**
 * Created by PhpStorm.
 * User: deemsysinc
 * Date: 11/20/13
 * Time: 10:24 AM
 */
session_start();

require("../config.php");



$case = $_REQUEST['service'];

switch($case)
{
case 'simpleselect':
{

    $sql11 = "SELECT * FROM admin_log_table WHERE status='1'";
   // $count = mysql_num_rows(mysql_query($sql));
   // $patient_id = $_POST['patid'];
    $flag=0;
   // $sql11 ="SELECT * FROM tbl_appointment_details WHERE app_appointment_date >= NOW() AND app_appointment_patientid = ".$patient_id;


    if($query11 = mysql_query($sql11))
    {
        $flag =1;

        if($flag == '1')
        {

            $json = '{ "serviceresponse" : { "servicename" : "Select Providers", "success" : "Yes", "Providers List" : [ ';
            for($i=0;$i<mysql_num_rows($query11);$i++)
            {
                $record11 =mysql_fetch_array($query11);
                $sql12 = "SELECT * FROM admin_log_table where admin_id= ".$record11['admin_id'];

                $query12 = mysql_query($sql12);
                $row		= mysql_fetch_object($query12);


                $json 		.= '{ "serviceresponse" : { "servicename" : "Select Providers", "success" : "Yes", "Provider username" : "'.$row->admin_username.'", "Provider id" : "'.$row->admin_id.'", "message" : "1" } }';

            }
            $json = rtrim($json,',');
            $json .= '], "message" : "1" } }';
        }
    }
    if($flag == '0')
    {
        $json 		= '{ "serviceresponse" : { "servicename" : "Select Providers", "success" : "No", "message" : "'.$error.'" } }';
    }

    echo $json;

break;
}
case 'groupSelect':
{


    $sql = "SELECT * FROM participant_group_table ";
    $count = mysql_num_rows(mysql_query($sql));
    // $patient_id = $_POST['patid'];
    $flag=0;
    // $sql11 ="SELECT * FROM tbl_appointment_details WHERE app_appointment_date >= NOW() AND app_appointment_patientid = ".$patient_id;


    if($query11 = mysql_query($sql))
    {
        $flag =1;

        if($flag == '1')
        {

            $json = '{ "serviceresponse" : { "servicename" : "Select Group", "success" : "Yes", "Group List" : [ ';
            for($i=0;$i<mysql_num_rows($query11);$i++)
            {
                $record11 =mysql_fetch_array($query11);
                $sql12 = "SELECT * FROM participant_group_table where group_id= ".$record11['group_id'];

                $query12 = mysql_query($sql12);
                $row		= mysql_fetch_object($query12);


                $json 		.= '{ "serviceresponse" : { "servicename" : "Select Group", "success" : "Yes", "Groupname" : "'.$row->group_name.'", "Groupid" : "'.$row->group_id.'", "Createdby" : "'.$row->created_by.'", "message" : "1" } }';

            }
            $json = rtrim($json,',');
            $json .= '], "message" : "1" } }';
        }
    }
    if($flag == '0')
    {
        $json 		= '{ "serviceresponse" : { "servicename" : "Select Group", "success" : "No", "message" : "'.$error.'" } }';
    }

    echo $json;
    break;
}
    case 'providerSelect':
    {
        $patient_id = $_POST['patid'];
        $sql11 ="select * from participants_table where participants_id ='".$patient_id."'";

         $flag=0;
        if($query11 = mysql_query($sql11))
        {
            $flag =1;

            if($flag == '1')
            {

                $json = '{ "serviceresponse" : { "servicename" : "Select Providerdetail", "success" : "Yes", "Provider Info" : [ ';
                for($i=0;$i<mysql_num_rows($query11);$i++)
                {
                    $record11 =mysql_fetch_array($query11);
                    $sql12 ="SELECT admin_username,admin_firstname,admin_mobile,admin_email FROM admin_log_table WHERE admin_username='".$record11['Provider_name']."'";

                    $query12 = mysql_query($sql12);
                    $row		= mysql_fetch_object($query12);

                    $json 		.= '{ "serviceresponse" : { "servicename" : "Select Providerdetail", "success" : "Yes", "adminusername" : "'.$row->admin_username.'", "adminfirstname" : "'.$row->admin_firstname.'", "adminmobile" : "'.$row->admin_mobile.'", "adminemail" : "'.$row->admin_email.'","message" : "1" } }';

                }
                $json = rtrim($json,',');
                $json .= '], "message" : "1" } }';
            }
        }
        if($flag == '0')
        {
            $json 		= '{ "serviceresponse" : { "servicename" : "Select Providerdetail", "success" : "No", "message" : "'.$error.'" } }';
        }

        echo $json;

        break;
    }
    case 'passwordSelect':
    {
        $usermail=$_POST['emailid'];
        $sql="select * from login where email_id='".$usermail."'";

        $flag=0;
        // $sql11 ="SELECT * FROM tbl_appointment_details WHERE app_appointment_date >= NOW() AND app_appointment_patientid = ".$patient_id;


        if($query11 = mysql_query($sql))
        {
            $flag =1;

            if($flag == '1')
            {

                $json = '{ "serviceresponse" : { "servicename" : "Select Password", "success" : "Yes", "Patient password" : [ ';
                for($i=0;$i<mysql_num_rows($query11);$i++)
                {
                    $record11 =mysql_fetch_array($query11);
                    $sql12 = "SELECT password  FROM login where email_id = '".$record11['email_id']."'";

                    $query12 = mysql_query($sql12);
                    $row		= mysql_fetch_object($query12);


                    $json 		.= '{ "serviceresponse" : { "servicename" : "Select Password", "success" : "Yes", "userpassword" : "'.$row->password.'" } }';

                }
                $json = rtrim($json,',');
                $json .= '], "message" : "1" } }';
            }
        }
        if($flag == '0')
        {
            $json 		= '{ "serviceresponse" : { "servicename" : "Select Password", "success" : "No", "message" : "'.$error.'" } }';
        }

        echo $json;
        break;
    }
    case 'participantSelect':
    {
        $userid=$_POST['loginid'];
        $sql="select * from participants_table where participants_id='".$userid."'";

        $flag=0;
        // $sql11 ="SELECT * FROM tbl_appointment_details WHERE app_appointment_date >= NOW() AND app_appointment_patientid = ".$patient_id;


        if($query11 = mysql_query($sql))
        {
            $flag =1;

            if($flag == '1')
            {

                $json = '{ "serviceresponse" : { "servicename" : "Select Participant", "success" : "Yes", "Patient info" : [ ';
                for($i=0;$i<mysql_num_rows($query11);$i++)
                {
                    $record11 =mysql_fetch_array($query11);
                    $sql12 = "SELECT *  FROM participants_table where participants_id = ".$userid."";

                    $query12 = mysql_query($sql12);
                    $row		= mysql_fetch_object($query12);


                    $json 		.= '{ "serviceresponse" : { "servicename" : "Select Participant", "success" : "Yes", "firstname" : "'.$row->fname.'" ,"username" : "'.$row->username.'" , "mobilenum" : "'.$row->mobile_num.'", "email" : "'.$row->email_id.'", "gender" : "'.$row->gender.'", "city" : "'.$row->city.'", "education" : "'.$row->education.'", "medical" : "'.$row->medical_details.'", "time1" : "'.$row->time1.'","time1format" : "'.$row->time1_am_pm.'","time2" : "'.$row->time2.'","time2format" : "'.$row->time2_am_pm.'", "time3" : "'.$row->time3.'","time3format" : "'.$row->time3_am_pm.'", "providername" : "'.$row->Provider_name.'", "group" : "'.$row->group_name.'", "age" : "'.$row->age.'","messagestream" : "'.$row->message.'"} }';

               }


                $json = rtrim($json,',');
                $json .= '], "message" : "1" } }';
            }
        }
        if($flag == '0')
        {
            $json 		= '{ "serviceresponse" : { "servicename" : "Select Participant", "success" : "No", "message" : "'.$error.'" } }';
        }

        echo $json;
        break;
    }
    case 'groupselectinEdit':
    {

        $Providername=$_POST['providername'];
        $sql = "SELECT * FROM participant_group_table where created_by='".$Providername."'";

       // $count = mysql_num_rows(mysql_query($sql));
        // $patient_id = $_POST['patid'];
        $flag=0;
        // $sql11 ="SELECT * FROM tbl_appointment_details WHERE app_appointment_date >= NOW() AND app_appointment_patientid = ".$patient_id;


        if($query11 = mysql_query($sql))
        {
            $flag =1;

            if($flag == '1')
            {

                $json = '{ "serviceresponse" : { "servicename" : "Select Group", "success" : "Yes", "Group List" : [ ';
                for($i=0;$i<mysql_num_rows($query11);$i++)
                {
                    $record11 =mysql_fetch_array($query11);

             $sql12 = "SELECT * FROM participant_group_table where created_by='".$Providername."'";
                    $query12 = mysql_query($sql12);
                    $row		= mysql_fetch_object($query12);


                    $json 		.= '{ "serviceresponse" : { "servicename" : "Select Group", "success" : "Yes", "Groupname" : "'.$row->group_name.'", "Createdby" : "'.$row->created_by.'", "message" : "1" } }';

                }
                $json = rtrim($json,',');
                $json .= '], "message" : "1" } }';
            }
        }
        if($flag == '0')
        {
            $json 		= '{ "serviceresponse" : { "servicename" : "Select Group", "success" : "No", "message" : "'.$error.'" } }';
        }

        echo $json;
        break;
    }
        case 'getGroups':
        {


            $providername=$_POST['providername'];
            $sql="select group_name,created_by,group_id,group_decs from participant_group_table WHERE created_by='".$providername."'";
            $flag=0;
            if($query11 = mysql_query($sql))
            {
                $flag =1;

                if($flag == '1')
                {

                    $json = '{ "serviceresponse" : { "servicename" : "Provider Group", "success" : "Yes", "Group List" : [ ';
                    for($i=0;$i<mysql_num_rows($query11);$i++)
                    {
                        //$record11 =mysql_fetch_array($query11);
                        //$sql12 = "select group_name,created_by from participant_group_table where created_by='suresh'";

//                        $query12 = mysql_query($sql12);
                        $row		= mysql_fetch_object($query11);

                        $json 		.= '{ "serviceresponse" : { "servicename" : "Provider Group", "success" : "Yes", "groupname" : "'.$row->group_name.'", "createdby" : "'.$row->created_by.'","groupid" : "'.$row->group_id.'","groupdecs" : "'.$row->group_decs.'", "message" : "1" } }';

                    }
                    $json = rtrim($json,',');
                    $json .= '], "message" : "1" } }';
                    //$json = rtrim($json,',');
                   // $json .= '], "message" : "1" } }';
                }
            }
            if($flag == '0')
            {
                $json 		= '{ "serviceresponse" : { "servicename" : "Provider Group", "success" : "No", "message" : "'.$error.'" } }';
            }

            echo $json;
            break;
        }
    case 'weeklyevaluationSelect':
    {
$id=$_POST['loginid'];

        $query1="select *from weekly_logs where participant_id='".$id."' and status='0'";
        if($query11 = mysql_query($query1))
        {
            $flag =1;

            if($flag == '1')
            {

                $json = '{ "serviceresponse" : { "servicename" : "Weekly_logs Select", "success" : "Yes", "Weekly_logs List" : [ ';
                for($i=0;$i<mysql_num_rows($query11);$i++)
                {

                    $row		= mysql_fetch_object($query11);

                    $json 		.= '{ "serviceresponse" : { "servicename" : "Weekly_logs Select", "success" : "Yes", "log_id" : "'.$row->log_id.'", "week" : "'.$row->week.'","date_time" : "'.$row->date_time.'","continuous" : "'.$row->continous.'","count" : "'.$row->count.'", "status" : "'.$row->status.'",  "message" : "1" } }';

                }
                $json = rtrim($json,',');
                $json .= '], "message" : "1" } }';
                //$json = rtrim($json,',');
                // $json .= '], "message" : "1" } }';
            }
        }
        if($flag == '0')
        {
            $json 		= '{ "serviceresponse" : { "servicename" : "Weekly_logs Select", "success" : "No", "message" : "'.$error.'" } }';
        }

        echo $json;
        break;

    }
    case 'sequenceSelect':
    {
        $id1=$_POST['loginid'];
        $query1="select *from weekly_logs where participant_id='".$id1."' and status='1'";
        if($query11 = mysql_query($query1))
        {
            $flag =1;

            if($flag == '1')
            {

                $json = '{ "serviceresponse" : { "servicename" : "Weekly_logs sequence Select", "success" : "Yes", "Weekly_logs sequence List" : [ ';
                for($i=0;$i<mysql_num_rows($query11);$i++)
                {

                    $row		= mysql_fetch_object($query11);

                    $json 		.= '{ "serviceresponse" : { "servicename" : "Weekly_logs sequence Select", "success" : "Yes", "log_id" : "'.$row->log_id.'", "week" : "'.$row->week.'","date_time" : "'.$row->date_time.'","continuous" : "'.$row->continous.'","count" : "'.$row->count.'", "status" : "'.$row->status.'",  "message" : "1" } }';

                }
                $json = rtrim($json,',');
                $json .= '], "message" : "1" } }';
                //$json = rtrim($json,',');
                // $json .= '], "message" : "1" } }';
            }
        }
        if($flag == '0')
        {
            $json 		= '{ "serviceresponse" : { "servicename" : "Weekly_logs sequence Select", "success" : "No", "message" : "'.$error.'" } }';
        }

        echo $json;
        break;
    }
case 'participantsgrouplist':
    {

       $patientid1=$_POST['loginid'];
      //  $patientid1='119';
        $sqlgroup="select * from participant_group where participant_id='".$patientid1."'";



        if($query11 = mysql_query($sqlgroup))
        {
            $flag =1;

            if($flag == '1')
            {

                $json = '{ "serviceresponse" : { "servicename" : "ParticipantgroupsSelect", "success" : "Yes", "Participants_groups List" : [ ';
                for($i=0;$i<mysql_num_rows($query11);$i++)
                {

                    $row    	= mysql_fetch_object($query11);

                    $json 		.= '{ "serviceresponse" : { "servicename" : "ParticipantgroupsSelect", "success" : "Yes", "group_id" : "'.$row->group_id.'", "group_name" : "'.$row->group_name.'","participant_id" : "'.$row->participant_id.'",  "message" : "1" } }';

                }
                $json = rtrim($json,',');
                $json .= '], "message" : "1" } }';
                //$json = rtrim($json,',');
                // $json .= '], "message" : "1" } }';
            }
        }
        if($flag == '0')
        {
            $json 		= '{ "serviceresponse" : { "servicename" : "ParticipantgroupsSelect", "success" : "No", "message" : "'.$error.'" } }';
        }
        echo $json;

        break;
    }
}