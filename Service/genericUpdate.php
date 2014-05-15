<?php
/**
 * Created by PhpStorm.
 * User: deemsysinc
 * Date: 11/21/13
 * Time: 4:49 PM
 */
session_start();

require("../config.php");



$case = $_REQUEST['service'];
switch($case)
{
    case 'passwordUpdate':
    {
        $oldpass=$_POST['oldpassword'];
        $newpass=$_POST['newpassword'];
        $loginid=$_POST['loginid'];
        $sql="update login set password='".$newpass."'where login_id= '".$loginid."'";
        $flag=0;
        if($query11 = mysql_query($sql))
        {
            $flag =1;

            if($flag == '1')
            {

                $json = '{ "serviceresponse" : { "servicename" : "Update Password ", "success" : "Yes", "Update Info" : [ ';
                //$json = rtrim($json,',');
                $json .= '], "message" : "1" } }';
            }
        }
        if($flag == '0')
        {
            $json 		= '{ "serviceresponse" : { "servicename" : "Update Password", "success" : "No", "message" : "'.$error.'" } }';
        }

        echo $json;

        break;
    }
    case 'patientupdate':
    {

        $loginid1=$_POST['loginid'];
        $username = $_POST['username1'];
        $firstname = $_POST['fname'];
        $mobile = $_POST['mobile_num'];
        $oldmobilenum=$_POST['old_mobile_num'];
        $gender = $_POST['gender'];
        $city = $_POST['city'];
        $education = $_POST['education'];
        $medical = $_POST['medical_details'];
        $timeone = $_POST['time1'];
        $timetwo = $_POST['time2'];
        $timethree = $_POST['time3'];
        $provider = $_POST['Provider_name'];
        $group = $_POST['group_name'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        //$password= $_POST['pass'];
        $groupid1=$_POST['groupid'];
        $emailold=$_POST['oldemailid'];
        $timeformat1=$_POST['time1format'];
        $timeformat2=$_POST['time2format'];
        $timeformat3=$_POST['time3format'];
        $group1 = $_POST['groupname'];

        $sql = "SELECT * FROM login WHERE email_id ='".$email."'";

        $count = mysql_num_rows(mysql_query($sql));
        $sqlmobile="select *from participants_table where mobile_num='".$mobile."'";
        $count2 = mysql_num_rows(mysql_query($sqlmobile));

        if((($count > 0) && (strcmp($emailold,$email)!=0)) || (($count2 > 0) && (strcmp($mobile,$oldmobilenum)!=0)))
        {
            if(($count > 0) && (strcmp($emailold,$email)!=0))
            {
                $json	= '{ "serviceresponse" : { "servicename" : "Update MyPatient Details", "success" : "No", "emaill" : "emailexist",  "message" : "Already Exist" } }';

            }
            if (($count2 > 0) && (strcmp($mobile,$oldmobilenum)!=0))
            {
                $json	= '{ "serviceresponse" : { "servicename" : "Update MyPatient Details", "success" : "No", "emaill" : "mobilenumexist",  "message" : "Already Exist" } }';
            }
        }
        else
        {


            $sql = "SELECT * FROM participants_table WHERE participants_id = '".$loginid1."'";


            if($query11 = mysql_query($sql))
            {
                $userdetail ="update participants_table set fname='".$firstname."',mobile_num='".$mobile."',gender='".$gender."',city='".$city."',education='".$education."',medical_details='".$medical."',time1='".$timeone."',time1_am_pm='".$timeformat1."',time2='".$timetwo."',time2_am_pm='".$timeformat2."',time3='".$timethree."',time3_am_pm='".$timeformat3."',group_name='".$group1."',age='".$age."',email_id='".$email."' WHERE participants_id=".$loginid1;
                // mysql_query($userdetail);
                mysql_query($userdetail);
                $sql3="update login set email_id='".$email."' where login_id='".$loginid1."'";
                // mysql_query($sql3);

                // $sql2="delete * from participant_group WHERE participant_id='".$loginid1."'";
                $update ="DELETE FROM participant_group WHERE participant_id='".$loginid1."'";
                mysql_query($update);
                $grouparray=explode("-",$group);

                $groupidarray=explode("-",$groupid1);

                for($i=0;$i<count($grouparray);$i++)
                {


                    $groupinsert="INSERT INTO participant_group (id, group_id, group_name, participant_id) VALUES ('','".$groupidarray[$i]."','".$grouparray[$i]."','".$loginid1."') ";
//			$assignassessment ="INSERT INTO tbl_patientassessment_details (pa_patientassessment_patname, pa_patientassessment_patid, pa_patientassessment_providerid, pa_patientassessment_assid, pa_patientassessment_status) VALUES ('".$username."', '".$indipat_id."', '0', '1', '1'),('".$username."', '".$indipat_id."', '0', '3', '1');";
                    mysql_query($groupinsert);

                }

                //insert loop



                $selectfrombroadcast="select t1.*,t2.* from broad_cast_table as t1 join participant_group as t2 on t1.group_id=t2.group_id where t2.participant_id='".$loginid1."'";
                $result=mysql_query($selectfrombroadcast);
                $broadcastcount = mysql_num_rows(mysql_query($selectfrombroadcast));
                if($broadcastcount>0)
                {
                    for($i=0;$i<mysql_num_rows($result);$i++)
                    {
                        $record11 =mysql_fetch_array($result);
                        $sql12 = "SELECT * FROM participant_message_log where Participant_id= '".$record11['participant_id']."' AND broad_id='".$record11['broad_id']."'";
                        $broadvalue=$record11['broad_id'];


                        $query12 = mysql_query($sql12);
                        if(mysql_num_rows($query12)>0)
                        {

                           //echo 'exists';
                        }
                        else
                        {
                            //echo 'insertion';
                            //echo $broadvalue;
                            //echo $loginid1;
                            $messagelog="INSERT into participant_message_log(log_id,Participant_id,broad_id,no_of_message_send,no_of_days,flag_status,dateofsend)values('','".$loginid1."','".$broadvalue."','0','0','0',NOW())";
                            if(mysql_query($messagelog))
                            {
                               //echo 'success';
                            }
                            else
                            {
                             //echo 'failure';
                            }
                        }
                    }
                }
                else
                {

                }

                $success=mysql_query($sql3);

                //update loop



               $selectonlybroadcast="select t1.*,t2.* from broad_cast_table as t1 join participant_group as t2 on t1.group_id=t2.group_id where t2.participant_id='".$loginid1."'";
                $result1=mysql_query($selectonlybroadcast);
  $sql12 = "SELECT broad_id FROM participant_message_log where Participant_id='".$loginid1."'";
                $query121 = mysql_query($sql12);


                $flag=0;
                for($i=0;$i<mysql_num_rows($query121);$i++)
                {
//echo $i;
                    $message_log_array=mysql_fetch_array($query121);
                    //echo "\n participant msg table broadid  ";
                   //echo $message_log_array['broad_id'];
                    $result1=mysql_query($selectonlybroadcast);
                    for($j=0;$j<mysql_num_rows($result1);$j++)
                    {
                        $broad_array=mysql_fetch_array($result1);
//echo "\n join table broad id " ;
                        //echo $broad_array['broad_id'];
                        if($broad_array['broad_id']==$message_log_array['broad_id'])
                        {

                            $flag=1;
                            
                        }
                    }
                    if($flag==1)
                    {
                        $flag=0;

                    }
                    else
                    {
                        //echo 'delete';
                       //echo $message_log_array['broad_id'];

                       $delete_log="delete from participant_message_log where broad_id='".$message_log_array['broad_id']."' and Participant_id='".$loginid1."'";
                        mysql_query($delete_log);
                    }
                }

                if($success)
                {
                    $json 		= '{ "serviceresponse" : { "servicename" : "Update MyPatient Details", "success" : "Yes","message" : "Yes" } }';

                }
                else
                {
                    $json 		=  '{ "serviceresponse" : { "servicename" : "Update MyPatient Details", "success" : "No", "username" : "NULL",  "message" : "'.$error.'" } }';
                }
            }

        }

        echo $json;

        break;
    }
    case 'messageStreamUpdate':
    {
        $userid=$_POST['patientid'];
        $mess=$_POST['messagestream'];
        $mesupdate="update participants_table set message='".$mess."' where participants_id='".$userid."'";
        if( mysql_query($mesupdate))
        {
            $json 		= '{ "serviceresponse" : { "servicename" : "Update Messagestream Details", "success" : "Yes","message" : "Yes" } }';

        }
        else
        {
            $json 		=  '{ "serviceresponse" : { "servicename" : "Update Messagestream Details", "success" : "No","username" : "NULL",   "message" : "'.$error.'" } }';
        }
        echo $json;
        break;
    }
    case 'receivemessage':
    {
        echo 'sil';

        $sid = "AC786e7d442679f6354ffad69c823e8293";
        $token = "1fa46f72637ea7c1f51b758c486f9e66";

        $i=0;
        $client = new Services_Twilio($sid, $token);
        $mobilenum = "6137547143";
        try{
            //$items = array();
            $filter =array();
            // $count = 0;
            foreach ($client->account->sms_messages as $sms)
            {
                echo '$sms';
                // $itemsArray[$sms] = array($sms);
                // $items[$count++] = $sms;
                /*  if($sms->to == $mobilenum )
                  {
                      print 'selected messages';
                      $filter[$i]=$sms;
                      $i++;
                  }
                */


//                print_r($filter);
                /*    echo $sms->from;
                    print"<br>";
                    echo $sms->to;
                    print"<br>";
                    echo $sms->body;
                    print"<br>";
                    echo $sms->date_sent;
                    print"<br>";
                    echo $sms->status;
                    print"<br>";*/
            }
            print 'selected messages';
            print $filter;
            print "<br>";
        }

        catch (Services_Twilio_RestException $e)
        {
            echo $e;
        }

        break;
    }
    case 'sequenceUpdate':
    {
        $flag=0;
        $id1=$_POST['loginid'];
        $query1="update  weekly_logs set continous='0',count='0' where participant_id='".$id1."'";
        if($query11 = mysql_query($query1))
        {
            $flag =1;

            if($flag == '1')
            {
                $json 		= '{ "serviceresponse" : { "servicename" : "Weekly_logs sequence Update", "success" : "Yes", "message" : "'.$error.'" } }';
            }
        }
        if($flag == '0')
        {
            $json 		= '{ "serviceresponse" : { "servicename" : "Weekly_logs sequence Update", "success" : "No", "message" : "'.$error.'" } }';
        }

        echo $json;
        break;
    }

}
