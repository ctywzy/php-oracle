<?php
	include_once("model/Model.php");

	class User extends Model{
		public function login_judge($uemail, $users_password){
		
			$sql = 'select * from users where uemail = ?';
			$statement = $this->pdo->prepare($sql);
			$statement->execute([$uemail]);
			$user = $statement->fetch();
			//echo "<pre>";

			//var_dump($user);
			//exit;

			if($user['UEMAIL']==$uemail && $user['USERS_PASSWORD']==$users_password)//解决了sql注入问题
				return $user;
			else 
				return false;
		}

		public function exist_judge($uemail){//判断是否已经注册
			$sql = "select * from users where uemail = ?";
			$statement = $this->pdo->prepare($sql);
			$statement->execute([$uemail]);
			$user = $statement->fetch();
			if($user){
				return false;
			}
			else {
				return true;
			}

		}



		public function insert_user($uemail, $uname, $password){//插入新用户
			$role = "Visitor";
			$sql = "insert into users(uname,users_password,uemail,users_role) values(?,?,?,?)";
			$statement = $this->pdo->prepare($sql);

			$statement->execute([$uname,$password,$uemail,$role]);
			

		}
		
		public function find_all(){
			$sql = "select * from users";
			$statement = $this->pdo->prepare($sql);
			$statement->execute();
			$users = $statement->fetchAll();
			return $users;
		}
		public function exist_judge2($token){//判断是否已经申请
			$sql = "select * from puser where token = ?";
			$statement = $this->pdo->prepare($sql);
			$statement->execute([$token]);
			$user = $statement->fetch();
			if($user){
				return false;
			}
			else {
				return true;
			}

		}

		public function update_status($token_get){
		    //echo $token_get;
			$sql = "select * from puser where token = ?";
			$statement = $this->pdo->prepare($sql);
			$statement->execute([$token_get]);
			$puser = $statement->fetch();
			//var_export($puser);
			$uemail = $puser['PEMAIL'];
			$password = $puser['PUSER_PASSWORD'];

			//echo $password." " .$uemail;
			$sql = "update users set users_password=? where uemail = ?";
			$statement = $this->pdo->prepare($sql);
			$statement->execute([$password,$uemail]);

			$sql = "delete from puser where token =?";
			$statement = $this->pdo->prepare($sql);
			$statement->execute([$token_get]);
		}

		public function insert_user2($uemail, $password, $token){//插入新用户
			$sql = "insert into puser(pemail,puser_password,token) values(?,?,?)";
			$statement = $this->pdo->prepare($sql);
			$statement->execute([$uemail,$password,$token]);

		}

        public function  find_keyuser($keyword){
		    $sql = "select * from users where uemail like ?";
		    $statement = $this->pdo->prepare($sql);
		    $keyword = "%".$keyword."%";
		    $statement->execute([$keyword]);
		    return $statement->fetchAll();
        }

		public function update_uname($uname, $uemail){
		    $sql = "update users set uname = ? where uemail = ?";
		    $statement = $this->pdo->prepare($sql);
		    $statement->execute([$uname,$uemail]);
        }

        public function up_level($uemail){
        	$sql = "update users set users_role = 'VIP' where uemail = ?";
        	$statement = $this->pdo->prepare($sql);
        	$statement->execute([$uemail]);
        }

        public function saveFile($userEmail, $filePath,$name){
        	$sql = "insert into files(user_eamil,file_path,file_name) values(? , ? , ?)";
        	$statement = $this->pdo->prepare($sql);
        	$res = $statement->execute([$userEmail, $filePath,$name]);
        	if(!$res){
        		return false;
        	}return true;
        }

        public function getAllfiles($uemail){
        	$sql = "select * from files where user_eamil = ?";
        	$statement = $this->pdo->prepare($sql);
        	$statement->execute([$uemail]);
        	return $statement->fetchAll();
        }

        public function filedelete($id){
        	$sql = "delete from files where file_id = ?";
            $statement = $this->pdo->prepare($sql);
            $statement->execute([$id]);
        }

        public function user_number($startRow,$endRow){
            $sql = "select *
					from
					(
					    select ROWNUM rn ,users.*
					    from (select * from users) users
					    where ROWNUM <= ?
					)
					where rn >= ?";
            $statement = $this->pdo->prepare($sql);
            $statement->execute([$endRow,$startRow]); 
            return $statement->fetchAll();
        }

        public function page_max(){
        	$sql = "select count(users_id) num from users";
        	$statement = $this->pdo->prepare($sql);
        	$statement->execute();
        	return $statement->fetch();
        }

	}
?>