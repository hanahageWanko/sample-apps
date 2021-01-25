<?php
  class StatuRepository extends DbRepository {
    public function insert($user_id, $body) {
      $now = new DateTime();
      $sql = " insert into status(usre_id, body, created_at)
               value (:user_id, :body, :created_at) ";

      $stmt = $this->execute($sql, [
        ':usre_id'    => $user_id,
        ':body'       => $body,
        ':created_at' => $now->format('Y-m-d H:i:s')
      ]);
    }

    public function fetchAllPersonalArchivesByuserId($user_id) {
      $sql = "
              select a.*, u.user_name
              from status a
              left join user u
              ON a.user_id = u.id
              where u.id = :user_id
              order by a.created_at desc  
      ";

      return $this->fetchAll($sql, [':user_id' => $user_id]);
    }
  }