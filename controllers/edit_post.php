
<?php 

  include "../database.php";

  $input = file_get_contents("php://input");
  $data = json_decode($input, true);

  try {

    $id = $data["id"];
    $newTitle = $data["title"];
    $newBody = $data["body"];
    $newAuthor = $data["author"];

    $response_body = edit_post($id, $newTitle, $newBody, $newAuthor);

    echo json_encode($response_body);
  } catch (Error $err) {
    echo json_encode(["success" => false, "err" => $err]);
  }

?>
