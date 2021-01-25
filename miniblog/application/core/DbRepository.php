<?php
  abstract class DbRepository {
    protected $con;

    public function __construct($con) {
        $this->setConnection($con);
    }

    public function setConnection($con) {
        $this->con = $con;
    }

    public function execute($sql, $params = []) {
        $stmt = $this->con->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    public function fetch($sql, $params = []) {
      // FETCH_ASSOC定数を指定し、結果を連想配列で受け取る
      return $this->execute($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll($sql, $params = []) {
      // FETCH_ASSOC定数を指定し、結果を連想配列で受け取る
      return $this->execute($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }
}