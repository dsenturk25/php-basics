<?php 
  include "../database.php";

  $input = file_get_contents("php://input");
  $data = json_decode($input, true); 

  if ($data) {
    $title = $data["title"];
    $body = $data["body"];
    $author = $data["author"];

    // Call the createPost function
    $response_body = createPost($title, $body, $author);

    echo json_encode([
        "success" => $response_body["success"],
        "message" => $response_body["err"] ?: "Post created successfully!"
    ]);
  } else {
      echo json_encode([
          "success" => false,
          "message" => "Invalid input. No data provided."
      ]);
  }

?>