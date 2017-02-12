<?php
/*Function to get users data*/
function get_user_data($con, $user_id){
$result = mysqli_query($con, "SELECT U.*, P.name FROM users U LEFT JOIN user_profile P ON U.user_ID=P.user_id WHERE U.user_id='$user_id' AND STATUS='1' LIMIT 1");
    if(mysqli_num_rows($result)==1){
        return mysqli_fetch_assoc($result);
    }else{
    	return FALSE;
    }
}

function safe_input($con, $data) {
  return htmlspecialchars(mysqli_real_escape_string($con, trim($data)));
}

/*Function to set JSON output*/
function output($Return=array()){
    /*Set response header*/
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    /*Final JSON response*/
    exit(json_encode($Return));
}

function conectar(){
global $HOSTNAME,$USERNAME,$PASSWORD,$DATABASE;
$idcnx = mysql_connect($HOSTNAME, $USERNAME, $PASSWORD) or DIE(mysql_error());
mysql_select_db($DATABASE, $idcnx);
return $idcnx;
}

?>
