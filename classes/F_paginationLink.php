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


function add_notification($stud_ID, $activity, $row)
{

  $row = (object)$row;
  $stud_ID = esc($stud_ID);
  $activity = esc($activity);
  $content_owner = $row->stud_ID;
  $date = date("Y-m-d H:i:s");

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
  }

  $query = "INSERT INTO notifications (stud_ID,activity,content_owner,date,content_id, content_type) 
            VALUES ('$stud_ID','$activity','$content_owner','$date','$content_id', '$content_type') ";
  
  $DB = new CONNECTION_DB();
  $DB->save($query);

}

function content_i_follow($stud_ID, $row)
{

  $stud_ID = esc($stud_ID); 
  $content_owner = $row->stud_ID;
  $date = date("Y-m-D H:i:s");
  $content_id = 0;
  $content_type = "";

  if(isset($row->post_id)){
    $content_id = $row->post_id;
    $content_type = "post";

    if($row->parent > 0 ){
      $content_type = "comment";
    }
    
  }
  $query = "INSERT INTO content_follow (stud_ID,date,content_id, content_type) 
            VALUES ('$stud_ID','$date','$content_id', '$content_type') ";
  
  $DB = new CONNECTION_DB();
  $DB->save($query);
}



function esc($value)
{
  return addslashes($value);
}
