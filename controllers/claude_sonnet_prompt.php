
<?php

  include "../utils/claude_sonnet_request.php";

  $input = file_get_contents("php://input");
  $data = json_decode($input);

  try {
  
    $prompt = $data["promp"];
    $answer = sendAnthropicRequest($prompt);

    echo json_encode(["success" => false, "answer" => $answer]);
  } catch (Error $err) {
    echo json_encode(["success" => false, "err" => $err]);
  }
?>
