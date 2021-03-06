<?php
  $mysqli = new mysqli('127.0.0.1', 'root', '', 'perfect_php');
  if (!$mysqli) {
      die('データベースに接続できません：' . musqli_error());
  }

  $sql = "select * from `oneline_bbs` order by `created_at` DESC";
  $result = $mysqli->query($sql);
  $posts = [];
  if ($result !== false && mysqli_num_rows($result)) {
      while ($post = mysqli_fetch_assoc($result)) {
          $posts[] = $post;
      }
  }

  function validateStr($str, $maxStrInt, $valueName)
  {
      if (!isset($str) || !strlen($str)) {
          return ['flag' => false, 'value' => "${valueName}を入力してください"];
      } elseif (strlen($str) > $maxStrInt) {
          return ['flag' => false, 'value' => "${valueName}は${maxStrInt}文字以内で入力してください"];
      } else {
          return ['flag' => true, 'value' => $str];
      }
  }

  $errors = array();
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $name = validateStr($_POST['name'], 40, '名前');
      $name['flag'] ? $name = $name['value'] : $errors['name'] = $name['value'];
      $comment = validateStr($_POST['comment'], 40, 'ひとこと');
      $comment['flag']
      ? $comment = $comment['value']
      : $errors['commnet'] = $comment['value'];

      if (count($errors) === 0) {
          $insertSql = "insert into `oneline_bbs` (`name`, `comment`, `created_at`) values
            ('" . $mysqli->real_escape_string($name) . "','"
            . $mysqli->real_escape_string($comment) . "','"
            . date('Y-m-d H:i:s'). "')";
          $mysqli->query($insertSql);
          header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
      }
      mysqli_free_result($result);
      mysqli_close($mysqli);
  }
  include 'views/bbs_view.php';
?>