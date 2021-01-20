<?php
  $mysqli = new mysqli('127.0.0.1', 'root', '', 'perfect_php');
  if (!$mysqli) {
      die('データベースに接続できません：' . musqli_error());
  }

  function validateStr($str, $maxStrInt, $valueName) {
    if(!isset($str) || !strlen($str)) {
      return ['flag' => false, 'value' => "${valueName}を入力してください"];
    } else if (strlen($str) > $maxStrInt) {
      return ['flag' => false, 'value' => "${valueName}は${maxStrInt}文字以内で入力してください"];
    } else {
      return ['flag' => true, 'value' => $str];
    }
  }

  $errors = array();

  if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = validateStr($_POST['name'], 40, '名前');
    $name['flag'] ? $name = $name['value'] : $errors['name'] = $name['value'];
    $comment = validateStr($_POST['comment'], 40, 'ひとこと');
    $comment['flag']
      ? $comment = $comment['value']
      : $errors['commnet'] = $comment['value'];

    if(count($errors) === 0) {
      $insertSql = "insert into `oneline_bbs` (`name`, `comment`, `created_at`) values
            ('" . $mysqli->real_escape_string($name) . "','"
            . $mysqli->real_escape_string($comment) . "','"
            . date('Y-m-d H:i:s'). "')";
      $mysqli->query($insertSql);
      header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    }

}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ひとこと掲示板</title>
</head>
<body>
  <h1>ひとこと掲示板</h1>
  <form action="bbs.php" method="post">
  <?php if (count($errors)):?>
    <ul class="erroe_list">
      <?php foreach ($errors as $error):?>
        <li>
          <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
    名前：<input type="text" name="name"><br>
    ひとこと：<input type="text" name="comment" size="60"><br>
    <input type="submit" name="submit" value="送信">
  </form>
  <h3>リスト</h3>
  <?php
    $sql = "select * from `oneline_bbs` order by `created_at` DESC";
    $result = $mysqli->query($sql);
    if($result !== false && mysqli_num_rows($result)):
  ?>
  <ul>
      <?php while($post = mysqli_fetch_assoc($result)): ?>
        <li>
          <?php
            echo htmlspecialchars($post['name'], ENT_QUOTES, 'UTF-8');
            echo htmlspecialchars($post['comment'], ENT_QUOTES, 'UTF-8');
            echo htmlspecialchars($post['created_at'], ENT_QUOTES, 'UTF-8');
          ?>
        </li>
    <?php endwhile; ?>
  </ul>
    <?php endif; ?>
    <?php
      mysqli_free_result($result);
      mysqli_close($mysqli);
    ?>
</body>
</html>