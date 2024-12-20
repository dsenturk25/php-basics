
<?php

  include "../utils/claude_sonnet_request.php";

  $input = file_get_contents("php://input");
  $data = json_decode($input);

  try {
  
    $prompt = $data["prompt"];
    $answer = send_antrophic_request($prompt);

    echo json_encode(["success" => false, "answer" => $answer]);
  } catch (Error $err) {
    echo json_encode(["success" => false, "err" => $err]);
  }
?>
