<?php

session_start();

require("../config.php");

//require('/webroot/www/bcreasearch/twilio-php-master/Services/Twilio.php');

$case = $_REQUEST['service'];

switch($case){

    case 'partinsert':
    {

//		$refuserid = $_POST['userid'];
        $username = $_POST['username1'];
        $firstname = $_POST['fname'];
        $mobile = $_POST['mobile_num'];
        $gender = $_POST['gender'];
        $city = $_POST['city'];
        $education = $_POST['education'];
        $medical = $_POST['medical_details'];
        $timeone = $_POST['time1'];


      $timeformat1=$_POST['time1format'];
        $timetwo = $_POST['time2'];
        $timeformat2=$_POST['time2format'];
        $timethree = $_POST['time3'];
        $timeformat3=$_POST['time3format'];
        $provider = $_POST['Provider_name'];
        $group = $_POST['group_name'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $password= $_POST['pass'];
        $groupid1=$_POST['groupid'];
        $groupname1=$_POST['groupname'];

        //$zipcode = $_POST['zipcode'];

     $sql = "SELECT * FROM login WHERE email_id ='".$email."'";
        $count1 = mysql_num_rows(mysql_query($sql));
        $sqlusername="SELECT * FROM login WHERE username='".$username."'";

        $count2 = mysql_num_rows(mysql_query($sqlusername));

 $sqlmobile="select *from participants_table where mobile_num='".$mobile."'";
        $count3 = mysql_num_rows(mysql_query($sqlmobile));

if(($count1>0) || ($count2>0) || ($count3>0))
{
        if($count1 > 0)
        {
            $json	= '{ "serviceresponse" : { "servicename" : "Signup", "success" : "No", "emaill" : "emailexist",  "message" : "Already Exist" } }';

        }
    if($count2 > 0)
    {
        $json	= '{ "serviceresponse" : { "servicename" : "Signup", "success" : "No", "emaill" : "usernameexist",  "message" : "Already Exist" } }';

    }
    if($count3 > 0)
    {
        $json	= '{ "serviceresponse" : { "servicename" : "Signup", "success" : "No", "emaill" : "mobilenumexist",  "message" : "Already Exist" } }';

    }
}
            else
        {
            $userdetail ="INSERT INTO participants_table (participants_id, fname, username, mobile_num, gender, city, education, medical_details, time1, time1_am_pm, time2, time2_am_pm, time3, time3_am_pm, Provider_name, group_name, age, date_of_join, email_id, created_by, message) VALUES ('', '".$firstname."', '".$username."', '".$mobile."', '".$gender."', '".$city."', '".$education."', '".$medical."', '".$timeone."', '".$timeformat1."', '".$timetwo."', '".$timeformat2."', '".$timethree."', '".$timeformat3."', '".$provider."', '".$groupname1."', '".$age."', NOW(),'".$email."', 'Participant', '1');";

            mysql_query($userdetail);

            $indipat_id = mysql_insert_id();

            $patmed = "INSERT INTO login (login_id, username, password, email_id, role, status) VALUES ('".$indipat_id."', '".$username."', '".$password."', '".$email."', '0', '1')";
 			mysql_query($patmed);

            $grouparray=explode("-",$group);

            $groupidarray=explode("-",$groupid1);

            for($i=0;$i<count($grouparray);$i++)
            {
               // echo($grouparray[$i]);
               // echo "<br>";
               // echo($groupidarray[$i]);
               // echo "<br>";

           $groupinsert="INSERT INTO participant_group (id, group_id, group_name, participant_id) VALUES ('','".$groupidarray[$i]."','".$grouparray[$i]."','".$indipat_id."') ";
//			$assignassessment ="INSERT INTO tbl_patientassessment_details (pa_patientassessment_patname, pa_patientassessment_patid, pa_patientassessment_providerid, pa_patientassessment_assid, pa_patientassessment_status) VALUES ('".$username."', '".$indipat_id."', '0', '1', '1'),('".$username."', '".$indipat_id."', '0', '3', '1');";
                mysql_query($groupinsert);

            }
            $day=7;
for($i=1;$i<=12;$i++)
{
    $sql1="insert into weekly_logs(log_id,participant_id,week,date_time,continous,count,status)values('','".$indipat_id."','".$i."',NOW()+INTERVAL '".$day."' DAY,'0','0','0')";
    mysql_query($sql1);
    $day+=7;
}



            $selectfrombroadcast="select t1.*,t2.* from broad_cast_table as t1 join participant_group as t2 on t1.group_id=t2.group_id where t2.participant_id='".$indipat_id."'";
            $result=mysql_query($selectfrombroadcast);
            $broadcastcount = mysql_num_rows(mysql_query($selectfrombroadcast));
            if($broadcastcount>0)
            {
                for($i=0;$i<mysql_num_rows($result);$i++)
                {
                    $record11 =mysql_fetch_array($result);
                    $sql12 = "SELECT * FROM participant_message_log where Participant_id= '".$record11['participant_id']."' AND broad_id='".$record11['broad_id']."'";

                    $query12 = mysql_query($sql12);
                    if(mysql_num_rows($query12)>0)
                    {
                   // $row		= mysql_fetch_object($query12);
                       echo 'exists';
                    }
                    else
                    {
                        $messagelog="insert into participant_message_log(log_id,Participant_id,broad_id,no_of_message_send,no_of_days,flag_status,dateofsend)values('','".$record11['participant_id']."','".$record11['broad_id']."','0','0','0',NOW())";
                        if(mysql_query($messagelog))
                        {
                          //  echo 'success';
                        }
                        else
                        {
                          // echo 'failure';
                        }
                    }



                }
            }
            else
            {

            }
              $userlogs="insert into user_roles (USER_ROLE_ID,USER_ID,AUTHORITY) values ('','".$indipat_id."','ROLE_USER')";
            if(mysql_query($userlogs))
            {

                $json	= '{ "serviceresponse" : { "servicename" : "Signup", "success" : "Yes", "message" : "1" } }';



                    //$json	= '{ "serviceresponse" : { "servicename" : "Signup", "success" : "No", "emaill" : "NULL",  "message" : "'.$error.'" } }';


            }
            else
            {
                $json	= '{ "serviceresponse" : { "servicename" : "Signup", "success" : "No", "emaill" : "NULL",  "message" : "'.$error.'" } }';
            }

        }
        echo $json;

        break;

    }


  /* case 'testing':
    {

  
        $sid = "AC786e7d442679f6354ffad69c823e8293";
        $token = "1fa46f72637ea7c1f51b758c486f9e66";


       // $sid = getenv("$sid"); // Your Account SID from www.twilio.com/user/account
       // $token = getenv("@token"); // Your Auth Token from www.twilio.com/user/account

        $client = new Services_Twilio($sid, $token);
        try{
        
            foreach ($client->account->sms_messages as $sms) {
                echo $sms->from;
                print"<br>";
                echo $sms->to;
                print"<br>";
                echo $sms->body;
                print"<br>";
                echo $sms->date_sent;
                print"<br>";
                echo $sms->status;
                print"<br>";
            }
        }
        catch (Services_Twilio_RestException $e) {
            echo $e;
        }
        break;
    }
*/
    case 'weeklyevaluation':
    {
        $logid1=$_POST['loginid'];
        $ans1=$_POST['answer1'];
        $ans2=$_POST['answer2'];
        $ans3=$_POST['answer3'];
        $ques1='1001';
        $ques2='1002';
        $ques3='1003';
        $weeknumber1=$_POST['weeknum'];
        $weekdate1=$_POST['weekdate'];
        $weeklogid1=$_POST['weeklogid'];
        $countcol1=$_POST['countcol'];




                    $insertquery="insert into weekly_answers(id,log_id,question1,answer1,question2,answer2,question3,answer3,attend_date,status)values('','".$weeklogid1."','".$ques1."','".$ans1."','".$ques2."','".$ans2."','".$ques3."','".$ans3."',NOW(),'1')";
                    $updateweek="update weekly_logs set continous='".$countcol1."',count='".$countcol1."',status='1' where week='".$weeknumber1."' and participant_id='".$logid1."' and log_id='".$weeklogid1."' and date_time='".$weekdate1."'";
                    if(mysql_query($insertquery))
                    {

                        if(mysql_query($updateweek))
                        {
                            $json 		= '{ "serviceresponse" : { "servicename" : "Weekly Evaluation", "success" : "Yes","message" : "1" } }';
                        }
                        else
                        {
                            $json 		= '{ "serviceresponse" : { "servicename" : "Weekly Evaluation", "success" : "No",  "message" : "'.$error.'" } }';
                        }

                    }
                    else
                    {
                        $json 		= '{ "serviceresponse" : { "servicename" : "Weekly Evaluation", "success" : "No",  "message" : "'.$error.'" } }';
                    }






echo $json;
        break;
    }
    case 'test':
    {
        $date1 = date("Y-m-d H:i:s");
        $date2 = date('Y-m-d H:i:s', strtotime($date1,'+0 days'));
        print $date1;
        print "<br>";
        print $date2;
        print "<br>";
        $date3 = date('Y-m-d h:i:s', strtotime('+7 days'));
        print $date3;
        print "<br>";
        break;
    }
case 'audioinsert':
    {
        $flag = 0;
        $date = date('Y-m-d H:i:s');

        $file = print_r($_FILES);

       $patient_id = $_POST['patientid'];
       $weeklog_id = $_POST['weeklogid'];


        if ($_FILES['patientaudio']['size'] >= 0)
        {
            $rand=rand(0,100000);
            $headerimage ='../uploadaudio/'.$rand. $_FILES['patientaudio']['name'];
            move_uploaded_file($_FILES['patientaudio']['tmp_name'],$headerimage);
        }

        $audio_url = $headerimage;

     $pataudio = "INSERT INTO weekly_audio (id,log_id, participant_id,audio) VALUES ('','".$weeklog_id."','".$patient_id."', '".$audio_url."')";

               if(mysql_query($pataudio))
                {
                $json     	= '{ "serviceresponse" : { "servicename" : "Weekly audio Evaluation", "success" : "Yes","message" : "1" } }';
                }
                else
                {
                    $json 		= '{ "serviceresponse" : { "servicename" : "Weekly audio Evaluation", "success" : "No",  "message" : "'.$error.'" } }';
                }

        echo $json;
        break;

    }

}


exit;


?>
