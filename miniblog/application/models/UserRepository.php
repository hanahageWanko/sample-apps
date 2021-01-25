<?php
  class UserRepository extends DbRepository
  {
      public function insert($user_name, $password)
      {
          $password = $this->hashPassword($password);
          $now = new DateTime();

          $sql = "insert into user(User_name, password, created_at) value(:user_name, :password, :created_at)";
          $stmt = $this->execute($sql, [
            ':user_name'  => $user_name,
            ':password'   => $password,
            ':created_at' => $now->format('Y-m-d H:i:s')
          ]);
      }

      public function hashPassword($password)
      {
          return password_hash($password, PASSWORD_DEFAULT);
      }

      public function fetchByUserName($user_name) {
        $sql = "select * from user where user_name = :user_name";

        return $this>fetch($sql, [':user_name' => $user_name]);
      }

      public function isUniqueUserName($user_name) {
        $sql = "select count(id) as count from user where user_name = :user_name";

        $row = $this->fetch($sql, [':user_name' => $user_name]);
        if($row['count'] === '0') {
          return true;
        }

        return false;
      }
  }
