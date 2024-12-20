
<?php

  function return_break () {
    return "<br/>--------------------------<br/>";
  }

  # object example
  $obj = (object) array(
    "title" => "Harry Potter",
    "author" => "J.K. Rowling",
    "page_number" => 123
  );

  echo $obj->page_number;

  echo return_break();


  function return_error_json ($success_status, $err, $message = "") {
    return "Success: ".$success_status."Error message: ".$err."." . (strlen($message) > 0 ? (" Message: " . $message) : "");
  }

  echo return_error_json(false, "Couldn't upload data. Please try again later.");

  echo return_break();
?>
