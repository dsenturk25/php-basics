<?php

  include "../database.php";

  $input = file_get_contents("php://input");
  $data = json_decode($input, true);

  try {
    
    $id = $data["id"];

    $response_body = delete_post($id);
    echo json_encode($response_body);
  } catch (Error $error) {
    echo json_encode(["success" => false, "err" => "Unknown error."]);
  }
?>