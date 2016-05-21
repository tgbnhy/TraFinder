<?php
include "db_connect.php";
function load_points($mysqli){

    $output = "[";
    $query = 'SELECT t.userid, v.venue, v.lat, v.lng, t.description from (select * from tb_venue limit 10) v left join tb_tips t on v.location = t.location where t.userid in (1416466, 3113383) order by t.userid asc';
    //$query = 'SELECT t.userid, v.venue, v.lat, v.lng from (select * from tb_venue limit 100) v join (select * from tb_tips where userid = 1416466 or userid = 3113383) t on v.location = t.location order by t.userid asc';
    if ($stmt = $mysqli->prepare($query)) {
      //$stmt->bind_param('', $id);
      $stmt->execute();   // Execute the prepared query.
      $stmt->store_result();
      $stmt->bind_result($id, $venue, $lat, $lng, $desc);
      
      while($stmt->fetch()){
        $output .= "[".$lat.",".$lng.",".$id.",\"".$venue."\",\"".$desc."\"],";
      }
      $output = rtrim($output, ",")."]";
    }    
    //return "[[-37.808587, 144.963871, \"Centre Point\"]]";
    return $output;
}

function load_first_photos($mysqli, $id){

    $output = "";
    $query = 'SELECT user_id, record_id, image from tb_photos where user_id = ? limit 1';
    if ($stmt = $mysqli->prepare($query)) {
      $stmt->bind_param('i', $id);
      $stmt->execute();   // Execute the prepared query.
      $stmt->store_result();
      $stmt->bind_result($id, $record, $image);
      
      while($stmt->fetch()){
        $output .= '<img user="'.$id.'" record="'.$record.'" src="images/trajectory/'.$record.'/'.$image.'" class="img-thumbnail" >';
      }
    }    
    //return "[[-37.808587, 144.963871, \"Centre Point\"]]";
    return $output;
}

function load_photos($mysqli, $user, $record){

    $output = "";
    $list = "";
    $query = 'SELECT location_id, image from tb_photos where user_id = ? and record_id = ?';
    if ($stmt = $mysqli->prepare($query)) {
      $stmt->bind_param('ii', $user, $record);
      $stmt->execute();   // Execute the prepared query.
      $stmt->store_result();
      $stmt->bind_result($location, $image);
      $output = '';
      $loc = 0;
      while($stmt->fetch()){
        $list .= '<li><img user="'.$user.'" record="'.$record.'" src="images/trajectory/'.$record.'/'.$image.'" class="thumbnail"></li>';
        if($loc != $location){
            $output .= '<li><img user="'.$user.'" record="'.$record.'" src="images/trajectory/'.$record.'/'.$image.'" class="thumbnail"></li>';
            $loc = $location;
        }
      }
    }    
    //return "[[-37.808587, 144.963871, \"Centre Point\"]]";
    return $list.'#'.$output;
}

function insert_tips($mysqli, $number, $user_id, $location_id, $tip)
{
        $query = 'INSERT INTO tb_tips (record, userid, location, description)
        VALUES (?, ?, ?, ?)';
        if ($stmt = $mysqli->prepare($query)){
            // Bind "$user_id" to parameter.
            $stmt->bind_param('isss', $number, $user_id, $location_id, $tip);
            $stmt->execute();   // Execute the prepared query.
        }
        else{
          return "<p class='bg-danger'>Алдаа</p>";
        }        
}
?>
