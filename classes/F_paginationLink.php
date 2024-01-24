<?php

function pagination_link(){

  $arr['next_page'] = "";
  $arr['prev_page'] = "";

  $page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $page_number = $page_number < 1 ? 1 : $page_number;

  //Get current url
  //url http , if? https
  $url = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];
  $url .= "?";
  $page_found = false;

  $next_page_link = $url;
  $prev_page_link = $url;
  $num = 0;

  foreach ( $_GET as $key => $value ){
    $num++;
    
    if($num == 1){
      if($key == "page"){
        $next_page_link .= $key . "=" . ($page_number + 1 );
        $prev_page_link .= $key . "=" . ($page_number - 1 );
        $page_found = true;
        
      }else{
        $next_page_link .= $key . "=" . $value ;
        $prev_page_link .= $key . "=" . $value ;
      }
    }else{
      if($key == "page"){
        $next_page_link  .= "&" . $key . "=" .($page_number + 1 );
        $prev_page_link  .= "&" . $key . "=" .($page_number - 1 );  
        $page_found = true;            
      }else{
        $next_page_link .= "&" . $key . "=" . $value ;
        $prev_page_link .= "&" . $key . "=" . $value ;
      }
    }
    
  }


  $arr['next_page'] = $next_page_link;
  $arr['prev_page'] = $prev_page_link;

  if(!$page_found){
    $arr['next_page'] = $next_page_link . "&page=2";
    $arr['prev_page'] = $prev_page_link . "&page=1";  
  }
  return $arr;
}


function add_notification($stud_ID, $activity, $row, $post_id)
{

  $row = (object)$row;
  $stud_ID = esc($stud_ID);
  $activity = esc($activity);
  $content_owner = $row->stud_ID;

  $post_id = esc($post_id);
  $content_id = 0;
  $content_type = "";

  if(isset($row->post_id)){
    $content_id = $row->post_id;
    $content_type = "post";

    if($row->parent > 0 ){
      $content_type = "comment";
    }
    
  }

  if(isset($row->gender)){
    $content_type = "profile";
    $content_id = $row->stud_ID;
  }

  $query = "INSERT INTO notifications (stud_ID,activity,post_id,content_owner,content_id, content_type) 
            VALUES ('$stud_ID','$activity','$post_id','$content_owner','$content_id', '$content_type') ";
  
  $DB = new CONNECTION_DB();
  $DB->save($query);

}

function content_i_follow($stud_ID, $row)
{

  $row = (object)$row;
  $stud_ID = esc($stud_ID); 
  $content_id = 0;
  $content_type = "";

  if(isset($row->post_id)){
    $content_id = $row->post_id;
    $content_type = "post";

    if($row->parent > 0 ){
      $content_type = "comment";
    }
    
  }
  $query = "INSERT INTO content_follow (stud_ID,content_id, content_type) 
            VALUES ('$stud_ID','$content_id', '$content_type') ";
  
  $DB = new CONNECTION_DB();
  $DB->save($query);
}



function esc($value)
{
  return addslashes($value);
}

function notification_seen($id)
{  

  $notification_id = addslashes($id);
  $stud_ID = $_SESSION['Bisuconnect_stud_ID'];
  $DB = new CONNECTION_DB();

  $query = "SELECT * FROM notification_seen WHERE stud_ID = '$stud_ID' &&  notification_id = '$notification_id' LIMIT 1";
  $check = $DB->read($query);

  if(!is_array($check)){

    $query = "INSERT INTO notification_seen (stud_ID,notification_id) 
    VALUES ('$stud_ID','$notification_id') ";

    $DB->save($query);
  }
}


function check_notifications()
{
  $number = 0;

  $stud_ID = esc($_SESSION['Bisuconnect_stud_ID']);
  $DB = new CONNECTION_DB();
  $follow = array();

  //check content I follow
  $sql = "SELECT * FROM content_follow WHERE (disabled = 0 AND stud_ID ='$stud_ID') LIMIT 99";
  $i_follow = $DB->read($sql);

  if(is_array($i_follow)){
      $follow = array_column($i_follow, "content_id");
  }
  if(count($follow)> 0){

      $str = "'" . implode("','", $follow) . "'";                 
      $query = "SELECT * FROM notifications WHERE (content_owner = '$stud_ID' AND stud_ID != '$stud_ID') OR (content_id in ($str)) ORDER BY id DESC LIMIT 30";
  }else{
      $query = "SELECT * FROM notifications WHERE content_owner = '$stud_ID' AND stud_ID != '$stud_ID' ORDER BY id DESC LIMIT 30";
  }
  
  $data = $DB->read($query);

  if(is_array($data)){

    foreach($data as $row){


    $query = "SELECT * FROM notification_seen WHERE stud_ID = '$stud_ID' &&  notification_id = '$row[id]' LIMIT 1";
    $check = $DB->read($query);

    if(!is_array($check)){

        $number ++;
      } 
    }   
  }



  return $number;
}

function check_tags($text)
{
    
}


function getOrgConfig($stud_ID, $orgName) {
  $DB = new CONNECTION_DB();
  $query = "SELECT show_logo, logo_path, logo_url FROM org_config WHERE stud_ID = '$stud_ID' AND org_name = '$orgName' LIMIT 1";
  $result = $DB->read($query);

  return is_array($result) ? $result[0] : null;
}