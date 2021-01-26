<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php if(isset($title)){ echo $this->escape($title) . ' - '; } ?>Mini Blog</title>
</head>
<body>
  <div id="header">
    <h1><a href="<?php echo $base_url; ?>/">Mini Blog</a></h1>
  </div>

  <div id="nav">
    <p>
      <?php if($session->isAuthenticated()) : ?>
        <a href="<?php echo $base_url; ?>">ホーム</a>
        <a href="<?php echo $base_url; ?>">アカウント</a>
      <?php else: ?>
        <a href="<?php echo $base_url; ?>/account/signin">ログイン</a>
        <a href="<?php echo $baase_url; ?>/account/signout">アカウント登録</a>
      <?php endif; ?>
    </p>
  </div>

  <div id="main">
    <?php echo $_content; ?>
  </div>
</body>
</html>