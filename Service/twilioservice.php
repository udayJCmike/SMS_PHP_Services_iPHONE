<?php

/**
 * Created by PhpStorm.
 * User: deemsysinc
 * Date: 11/28/13
 * Time: 1:41 PM
 */
session_start();

require("../config.php");

require('../twilio-php-master/Services/Twilio.php');

$case = $_REQUEST['service'];

switch($case)
{

    case 'sendmessage':

    {
        $tonumber=$_POST['to'];
        $body=$_POST['msgbody'];
       // $sid='ACc3b8379c7d3c8670b70941adeba1a531';

        //$token='094ba16d028e446f5e20cc41890b3a86';

        $sql1="SELECT * FROM text_msg_api";
        $query11 =mysql_query($sql1);
        $record11 =mysql_fetch_array($query11);
    $sid=$record11['account_sid'];
      $token=$record11['auth_token'];
        $from=$record11['mob_num'];
       // print $sid;
       // print "<br>";
       // print $token;  print "<br>";
       // print $from;



          $client = new Services_Twilio($sid, $token);
        try{
            //  $sms = $client->account->sms_messages-> get("SMf89d6914568946268e5b16fd6171fb8e");

            $message = $client->account->messages->sendMessage( "$from", "$tonumber", "$body");
            // print $sms->body;
            // print"<br>";
            // print $sms->to;
          /*  foreach ($client->account->sms_messages as $sms) {
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
            }*/
            //print $message->sid;


          $json 		= '{ "serviceresponse" : { "servicename" : "Msg send", "success" : "Yes","message" : "Yes" } }';



        }
        catch (Services_Twilio_RestException $e)

        {
            $json 		= '{ "serviceresponse" : { "servicename" : "Msg send", "success" : "No","message" : NULL } }';
            echo $e;
        }
echo $json;

        break;

    }

    case 'receivemessage':
    {
        $sid = "AC786e7d442679f6354ffad69c823e8293";
        $token = "1fa46f72637ea7c1f51b758c486f9e66";
$messages=array();
        $i=0;

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
            $message[$i]=$sms->body;
            $i++;
        }
            print "My car is a $messages[0]";
        }
        catch (Services_Twilio_RestException $e) {
            echo $e;
        }

        break;
    }
    case 'readmessage':
    {
        $usernum=$_POST['usernumber'];
        $sql1="SELECT * FROM text_msg_api";
        $query11 =mysql_query($sql1);
        $record11 =mysql_fetch_array($query11);
        $sid=$record11['account_sid'];
        $token=$record11['auth_token'];
        $from=$record11['mob_num'];
        $client = new Services_Twilio($sid, $token);
        $completearray=array();


        try{
            $json ='{ "serviceresponse" : { "servicename" : "Select Participant", "success" : "Yes", "Patient info" : [ ';
            foreach ($client->account->sms_messages as  $sms)
            {
                //var_dump($k);
                //var_dump($sms);

                $items = array();




                if("$usernum" == $sms->to)
                {
                    $items[]=$sms->from;
                    $items[]=$sms->to;
                    $items[]=$sms->body;
                    $items[]=$sms->date_sent;
                    $items[]=$sms->status;

 $json 		.= '{ "serviceresponse" : { "servicename" : "Select Participant", "success" : "Yes", "From_num" : "'.$sms->from.'", "To_num" : "'.$sms->to.'", "contenttext" : "'.$sms->body.'","date_time" : "'.$sms->date_sent.'","status" : "'.$sms->status.'", "message" : "1" } }';


                }


            }
            $json = rtrim($json,',');
            $json .= '], "message" : "1" } }';


           // print_r($completearray);
           // print_r($json);



        }
            /*  {
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
            }*/



        catch (Services_Twilio_RestException $e)
        {
            echo $e;
        }
        echo $json;
        break;
    }




}