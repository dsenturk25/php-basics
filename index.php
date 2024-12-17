
<?php
  include "database.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles/index.css">
  <script src="./scripts/index.js"></script>
  <title>Hello</title>
</head>
<body>

  <div class="posts-main-wrapper"> 
    <?php $posts = getAllPosts() ?>
    <?php if (!empty($posts)): ?>
      <?php count($posts) ?>
      <?php foreach($posts as $post): ?>
        <div class="each-post-content-wrapper">
        <div class="each-post-content-header">
          <div><?php echo $post->title ?></div>
          <div><?php echo $post->created_at ?></div>
        </div>
        <div><?php echo $post->author ?></div>
        <div class="each-post-content-body">
          <?php echo $post->body ?>
        </div>
        <div class="each-post-actions-wrapper">
          <div class="each-post-edit-post-button">
            <img class="each-post-edit-post-button-img" src="./public/edit.png" alt="Delete post">
            <div style="display:none"><?php echo $post->id ?></div>
          </div>
          <div class="each-post-delete-post-button">
            <img class="each-post-delete-post-button-img" src="./public/trashcan.png" alt="Delete post">
            <div style="display:none"><?php echo $post->id ?></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <div class="main-form">
    <label for="title">Title</label>
    <input type="text" name="title" id="title">
    <label for="author">Author</label>
    <input type="text" name="author" id="author">
    <label for="body">Body</label>
    <textarea type="text" name="body" id="body"></textarea>
    <div id="submit-button" class="submit-button">Add to database</div>
  </form>
</body>
</html>