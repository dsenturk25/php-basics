<?php


  $host = "localhost";
  $user = "root";
  $password = "";
  $dbname = "pdodatabase";

  try {
      $dsn = "mysql:host=$host;dbname=$dbname";
      $pdo = new PDO($dsn, $user, $password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
      die(json_encode(["success" => false, "message" => "Database connection failed: " . $e->getMessage()]));
  }

  // Set default fetch type
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, 
  PDO::FETCH_OBJ);

  // Override fetch mode
  // while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  //   echo $row["title"] . "<br/>";
  // }

  function get_response_body ($success_status, $response_data, $error_code = 3) {

    if ($error_code < 0 || $error_code > 3 || gettype($error_code) != "integer") $error_code = 3;

    $error_messages = array(
      0 => false,
      1 => "Upload failure",
      2 => "Not found",
      3 => "Other error"
    );

    return (object) array(
      "success" => $success_status, 
      "response_data" => $response_data,
      "err" => $error_messages[$error_code]
    );
  }

  function get_all_posts () {
    $stmt = $GLOBALS["pdo"]->query("SELECT * from posts");
    $posts = $stmt->fetchAll();
    return $posts;
  }  

  function create_post ($title, $body, $author) {
    
    global $pdo;

    $insert_sql = "
        INSERT INTO posts (title, body, author, is_published)
        VALUES (?,?,?,0)
      ";
    
    try {
    
      $insert_stmt = $pdo->prepare($insert_sql);
      $insert_stmt->execute([$title, $body, $author]);

      return array("success" => true, "err" => false);

    } catch (PDOException $err) {
      return array("success" => false, "err" => $err->getMessage());
    }
  }


  function delete_post ($id) {
    global $pdo;

    $find_sql = "SELECT title FROM posts WHERE id = ?";
    $delete_sql = "DELETE FROM posts WHERE id = ?";

    $find_stmt = $pdo->prepare($find_sql);
    $find_stmt->execute([$id]);
    $result = $find_stmt->fetch();

    if ($result) {
      $delete_stmt = $pdo->prepare($delete_sql);
      $delete_stmt->execute([$id]);
      return array("success" => true, "err" => false);
    } else {
      return array("success" => false, "err" => "Couldn't delete the post. Please try again.");
    }
  }

  function edit_post ($id, $newTitle, $newBody, $newAuthor) {

    global $pdo;

    $update_sql = "UPDATE posts
      SET title = ?,
      body = ?,
      author = ?
      WHERE id = ?
    ";

    try {
      $update_stmt = $pdo->prepare($update_sql);
      $update_stmt->execute([$newTitle, $newBody, $newAuthor, $id]);  

      return ["success" => true, "err" => false];
    } catch (PDOException $err) {
      return ["success" => false, "err" => $err];
    }
  }

  function filter_sort_posts ($sort_attribute, $sort_order, $search_attribute, $search_query) {

    global $pdo;

    $filter_query = "SELECT * FROM posts
      WHERE ? LIKE '%?%'
      ORDER BY ? ?
    ";

    try {

      $filter_stmt = $pdo->prepare($filter_query);
      $filter_stmt->execute([$search_attribute, $search_query, $sort_attribute, $sort_order]);
      $res_array = $filter_stmt->fetchAll();

      return get_response_body(true, $res_array, 0);

    } catch (Error $err) { 
      return get_response_body(false, 3);
    }
  }

?>