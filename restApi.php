<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
// header('Access-Control-Allow-Header: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$request = json_decode(file_get_contents("php://input"),true);

// print_r($data);

if(isset($request['action'])){

    $action = $request['action'];

    switch($action)
    {
        case "insertData":
            echo dataInsert($request['data']);
            break;

        case "dataUpdate":
            echo dataUpdate($request['data']);
            break;

        // case "dataDelete":
        //     echo delete($request['data']);
        //     break;
        
        case "fetchAllUserData":
            echo fetchAllData();
            break;
                
        default:
            echo "Access denied";
    }

}



function fetchAllData(){

    include("./config.php");

    $respo = array();
    $status = true;
    $msg = "";

    $checkData = mysqli_query($con,"select * from userinfo");

    if(mysqli_num_rows($checkData) < 0){

        $respo['status'] =  false;
        $respo['msg'] = "No data found";
   
        return json_encode($respo);

    }

    $data = array();
    while($run = mysqli_fetch_array($checkData)){

        $obj = new stdClass();
        $obj->id = $run['id'];
        $obj->name = $run['uname'];
        $obj->email = $run['email'];
      
        $data[]=$obj;

   

    }

    $respo['status'] =  true;
    $respo['msg'] = "Data found";
    $respo['data'] = $data;
   
    return json_encode($respo);
 

}



function dataInsert($req){

    include("./config.php");


    $email =  $req['email'];
    $name =  $req['name'];
    $respo = array();
    $status = true;
    $msg = "";

    if(empty($email) || empty($name)){


       $respo['status'] =  false;
       $respo['msg'] = "Either email or name is empty";

       return json_encode($respo);

    }

        
    $checkData = mysqli_query($con,"select * from userinfo where email = '".$email."'");

    if(mysqli_num_rows($checkData)>0){

        $respo['status'] =  false;
        $respo['msg'] = "this email id already inserted";
   
        return json_encode($respo);

    }

        $que = mysqli_query($con,"insert into userinfo (email,uname) values ('".$email."','".$name."')");

        if($que){

            $status = true;

            $msg = "Data inserted successfully";

        }else{
            $status = false;

            $msg = "Something went wrong with the server please try again";
        }

    

    $respo['status'] =  $status;
    $respo['msg'] = $msg;
   
    return json_encode($respo);


}


function dataUpdate($req){

    include("./config.php");


    $email =  $req['email'];
    $name =  $req['name'];
    $id =  $req['id'];

    $respo = array();
    $status = true;
    $msg = "";

    if(empty($email) || empty($name)){


        $respo['status'] =  false;
        $respo['msg'] = "Either email or name is empty";
 
        return json_encode($respo);
 
     }

     $checkData = mysqli_query($con,"select * from userinfo where id =$id");

    if(mysqli_num_rows($checkData) <= 0){

        $respo['status'] =  false;
        $respo['msg'] = "There are no data available for this id... ";
   
        return json_encode($respo);

    }

   

    $que = mysqli_query($con,"UPDATE userinfo SET uname='$name' WHERE email='$email'");

    
    if($que > 0){

        $status = true;

        $msg = "Data Updated successfully";

    }else{
        $status = false;

        $msg =  $que  ;// "Something went wrong with the server please try again";
    }



$respo['status'] =  $status;
$respo['msg'] = $msg;

return json_encode($respo);

}
?>