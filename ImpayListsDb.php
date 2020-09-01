<?php


  /*
   * тразакции
      $dbh->beginTransaction();
         $dbh->exec("insert into staff (id, first, last) values (23, 'Joe', 'Bloggs')");
         $dbh->exec("insert into salarychange (id, amount, changedate)  values (23, 50000, NOW())");
      $dbh->commit();
   * константы получения данных
   * \PDO::FETCH_NUM  - возращает пронумерованный массив
   * \PDO::FETCH_ASSOC - возращает ассоцоативный массив
   * \PDO::FETCH_BOTH - возращает ассоциативный и нумерованный массив одновременно
   * \PDO::FETCH_OBJ - возвращает обьект
   *
   *
   */




    class ImpayListsDb
    {
        private static $db = null;
        private $pdo;
        private $config;


        public function __construct(){

            $this->config = require_once __DIR__.'/configs/db.conf.php';
            $this->pdo = new \PDO(
        "mysql:host={$this->config['host']};
            dbname={$this->config['db_name']};
            charset={$this->config['charset']}",
                    $this->config['user'],
                    $this->config['password'],
                    array(
                        // создание постоянного соединения
//                \PDO::ATTR_PERSISTENT => true,
                        // ошибки вызывают исключения
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                    ));
        }

        public static function getDB() {
            if (is_null(self::$db)) self::$db = new ImpayListsDb();
            return self::$db;
        }

        public function queryOne($sql, $param = []){
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($param);
            $arr = $stmt->fetch(\PDO::FETCH_ASSOC);
            if (!is_null($stmt->errorInfo()[2]))
            	throw new \PDOException($stmt->errorInfo()[0].','.$stmt->errorInfo()[1].','.$stmt->errorInfo()[2]);
            if(is_array($arr)) return $arr;
        }

        public function queryAll($sql, $param  = []){
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($param);
            $arr = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            if (!is_null($stmt->errorInfo()[2]))
            	throw new \PDOException($stmt->errorInfo()[0].','.$stmt->errorInfo()[1].','.$stmt->errorInfo()[2]);
            if(is_array($arr)) return $arr;
        }

        public function getAllStdClass($sql, array $param  = []){
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($param);
            $arr = $stmt->fetchAll(\PDO::FETCH_OBJ);
            if (!is_null($stmt->errorInfo()[2]))
            	throw new \PDOException($stmt->errorInfo()[0].','.$stmt->errorInfo()[1].','.$stmt->errorInfo()[2]);
            if(is_array($arr)) return $arr;
        }

        public function queryFetchColumn($sql, $param  = []){
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($param);
            $str = $stmt->fetchColumn();
            if (!is_null($stmt->errorInfo()[2]))
            	throw new \PDOException($stmt->errorInfo()[0].','.$stmt->errorInfo()[1].','.$stmt->errorInfo()[2]);
            if(!is_null($str)) return $str;
        }

        public function queryBool($sql, $param  = []){
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($param);
            if (!is_null($stmt->errorInfo()[2]))
            	throw new \PDOException($stmt->errorInfo()[0].','.$stmt->errorInfo()[1].','.$stmt->errorInfo()[2]);
            return $stmt;
        }

        public function insert($table, array $data = []){
            $data = array_filter($data);
            $table = filter_var(trim($table),FILTER_SANITIZE_STRING);
            foreach ($data as $key => $datum) {
                 $column[] = $key;
                 $value[] = ":".$key;
                 $dataNew[':'.$key] = $datum;
            }
            $sql = "INSERT INTO `$table` (".implode(',', $column).") VALUES (".implode(',', $value).")";

            $stmt = $this->pdo->prepare($sql);
            $res = $stmt->execute($dataNew);
            if (!is_null($stmt->errorInfo()[2]))
            	throw new \PDOException($stmt->errorInfo()[0].','.$stmt->errorInfo()[1].','.$stmt->errorInfo()[2]);
            return $res;
        }

        public function update($table, $where, array $data = []){
            $data = array_filter($data);
            $table = filter_var(trim($table),FILTER_SANITIZE_STRING);
            foreach ($data as $key => $datum) {
                $dataUp[] = "$key = :$key";
                $dataNew[':'.$key] = $datum;
            }
            $sql = "UPDATE `$table` SET ".implode(',', $dataUp)." WHERE $where";
            $stmt = $this->pdo->prepare($sql);
            $res = $stmt->execute($dataNew);
            if (!is_null($stmt->errorInfo()[2])) throw new \PDOException($stmt->errorInfo()[0].','.$stmt->errorInfo()[1].','.$stmt->errorInfo()[2]);
            return $res;
        }

        public function lastInsertId(){
            return $this->pdo->lastInsertId();
        }


        private function select_while($sql, $param  = [], $function){
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($param);
            while ($arr = $stmt->fetсh(\PDO::FETCH_ASSOC)){
              $array[] =  $function($arr);
            }
            return $array;
        }


    }