<?php
	include_once("model/Model.php");
	class Logs extends Model{
		public function find_exact($time, $uemail){//根据事件查找
			$sql="alter session set nls_date_language=american";
			$statement = $this->pdo->prepare($sql);
			$statement->execute();
			$sql = "select * from logs where logs_date = ? and user_email = ?";
			$statement = $this->pdo->prepare($sql);
			$statement->execute([$time, $uemail]);
			$logs = $statement->fetchAll();
			return $logs;
		}

		public function add_judge($date, $uemail, $content){
			$sql="alter session set nls_date_language=american";
			$statement = $this->pdo->prepare($sql);
			$statement->execute();
			$sql = "select * from logs where logs_date=? and user_email= ? and logs_content = ?";
			$statement = $this->pdo->prepare($sql);
			$statement->execute([$date,$uemail,$content]);
			$user = $statement->fetch();
			if($user)	
				return false;
			else return true;
		}


		public function add_log($date, $uemail, $content){
			$sql="alter session set nls_date_language=american";
			$statement = $this->pdo->prepare($sql);
			$statement->execute();
			$bool = $this->add_judge($date, $uemail, $content);
			if($bool==true){
				$sql = "insert into logs(logs_date,user_email, logs_content) values(?,?,?)";
				$statement = $this->pdo->prepare($sql);
				$statement->execute([$date,$uemail,$content]);
			}
			
			//echo $date;
		}

		public function delete_log($id){
			$sql = "delete from logs where logs_id = ?";
			$statement = $this->pdo->prepare($sql);
			$statement->execute([$id]);

		}

		public function search_logs($keyword,$uemail,$getdate){
			$sql="alter session set nls_date_language=american";
			$statement = $this->pdo->prepare($sql);
			$statement->execute();
			$keyword = '%'.$keyword.'%';

			$sql = "select * from logs where user_email = ? and logs_date = ? and logs_content like ?  ";
			//echo $sql;
			$statement = $this->pdo->prepare($sql);
			$statement->execute([$uemail,$getdate,$keyword]);
			//var_export($statement);
			$logs = $statement->fetchAll();
			return $logs;
		}

        public function get_tnlogs($date){
        	$sql="alter session set nls_date_language=american";
			$statement = $this->pdo->prepare($sql);
			$statement->execute();
            $sql = "select user_email, count(logs_content) num from logs where logs_date = ? group by user_email";
            $statement = $this->pdo->prepare($sql);
            $statement->execute([$date]);
            return $statement->fetchAll();
        }


		public function find_by_date($date){
			$sql="alter session set nls_date_language=american";
			$statement = $this->pdo->prepare($sql);
			$statement->execute();
		    $sql = "select * from logs where logs_date = ?";
		    $statement = $this->pdo->prepare($sql);
		    $statement->execute([$date]);
		    return $statement->fetchAll();
        }

        public function get_log_dateuser($date,$email){
        	$sql="alter session set nls_date_language=american";
			$statement = $this->pdo->prepare($sql);
			$statement->execute();
		    $sql = "select * from logs where logs_date = ? and user_email = ?";
		    $statement = $this->pdo->prepare($sql);
		    $statement->execute([$date,$email]);
		    return $statement->fetchAll();
        }

	}
?>