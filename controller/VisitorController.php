<?php
	include("model/Logs.php");
	include('model/User.php');
	include('model/Smtp.php');
	header("Content-Type:text/html;charset=utf-8");
	date_default_timezone_set("PRC");
	class VisitorController{

		public function home_page(){
			$year=date("Y"); //当前的年
			$month=date("m"); //当前的月
			$week=date("w"); // 每个月的一号是星期几
			$days=date("t"); //每个月的总天数
			$day=date("d"); //获取今天是几号

			include('view/Visitor/Calendar_show.php');
		}

		
		

		
		public function to_write(){
			
			$getdate = $_POST['getdate'];
			if (!session_id()) session_start();
			$user = $_SESSION['user'];
			//var_dump($user);
			$LogsModel = new Logs();
			$logs = $LogsModel->find_exact($getdate,$user['UEMAIL']);
			//var_export($logs);
			include('view/Visitor/writelogs.php');
		}



		public function do_record(){
			$content = $_POST['content'];
			$getdate = $_POST['getdate'];
			if (!session_id()) session_start();
				$user = $_SESSION['user'];

			$LogsModel = new Logs();
			$LogsModel->add_log($getdate, $user['UEMAIL'], $content);
			
			$this->to_write();

		}

		public function do_delete(){
			$getdate = $_POST['getdate'];
			$id = $_POST['id'];
				$user = $_SESSION['user'];
			$LogsModel = new Logs();
			$LogsModel->delete_log($id);
			$this->to_write();
		}

		public function do_search(){
			$keyword = $_POST['keyword'];
			$getdate = $_POST['getdate'];
			if (!session_id()) session_start();
			$user = $_SESSION['user'];
			$LogsModel = new Logs();
			$logs = $LogsModel->search_logs($keyword,$user['UEMAIL'],$getdate);
			include('view/Visitor/writelogs.php');
		}
		public function  to_weather()
        {
            include('view/Visitor/Weekweather.php');
        }
        public function  change_uname()
        {
            $uname=$_POST['uname'];
            $password=$_POST['password'];
            if (!session_id()) session_start();
            $Ypassword=$_SESSION['user']['USERS_PASSWORD'];
            $UserModel= new User();
            if($password==$Ypassword)
            {
                $UserModel->update_uname($uname,$_SESSION['user']['UEMAIL']);
                $_SESSION['user']['UNAME'] = $uname;
                $this->home_page();
            }
            else
            {
                echo '<script>alert("密码错误请重新输入！");</script>';
            }
            
        }

        public function arouse(){
        	$actcode = $_POST['aaid'];
        	if("oraclestudy"==$actcode){
        		$UserModel = new User();
        		$UserModel->up_level($_SESSION['user']['UEMAIL']);
        		$_SESSION['user']['USERS_ROLE']="VIP";
        		$this->home_page();
        	}else{
        		echo '<script>alert("激活码无效");window.history.go(-1);</script>';
        	}
        }

        public function cloud_store(){
            $UserModel = new User;
            $files = $UserModel->getAllfiles($_SESSION['user']['UEMAIL']);
        	include('view/Visitor/Doc_upload.php');
        }

        public function do_download(){
            $filepath = $_POST['filePath'];
            header('content-disposition:attachment;filename='.pathinfo($filepath,PATHINFO_BASENAME));
            header('content-length:'.filesize( $filepath));      
            readfile( $filepath);
        }

        public function do_filedelete(){
            $id = $_POST['id'];
            $UserModel = new User;
            $files = $UserModel->filedelete($id);
            unlink($_POST['filePath']);
            header("Location: /index.php?r=Visitor/cloud_store");
        }
        public function getUploadFile()
        {
        	// echo '<pre>';
        	// var_dump($_FILES);
        	$myFile = $_FILES['file'];
        	$name = $myFile['name'];
        	$type = $myFile['type'];
        	$tmp_name = $myFile['tmp_name'];
        	$size = $myFile['size'];
        	$error = $myFile['error'];
        	if($error > 0){
        		exit('
        			<script>
        			alert("文件上传失败!");window.history.go(-1)
        			</script>
        			');
        	}
        	if($size > 100 * 1024 * 1024){
        		exit('
        			<script>
        			alert("文件过大!");window.history.go(-1)
        			</script>
        			');
        	}
        	$allowExt = ['jpg','jpeg','md','doc','docx','pptx','mp4','mp3','png'];

        	$ext = strtolower(pathinfo($name,PATHINFO_EXTENSION));
        	if(!in_array($ext, $allowExt)){
        		exit('
        			<script>
        			alert("不合法的文件类型!");window.history.go(-1)
        			</script>
        			');
        	}
        	$path = 'uploads';
        	if(!file_exists('uploads')){
        		mkdir('uploads',0777,true);
        		chmod('uploads', 0777);
        	}
        	if(!is_uploaded_file($tmp_name)){
        		exit('
        			<script>
        			alert("请通过HTTP上传!");window.history.go(-1)
        			</script>
        			');
        	}
        	$uniqueName = md5(uniqid(microtime(),true)) . "." . $ext;
        	$destination = 'uploads/' . $uniqueName;
        	if(!move_uploaded_file($tmp_name, $destination)){
        		exit('
        			<script>
        			alert("文件移动失败!");window.history.go(-1);
        			</script>
        			');
        	}
        	// echo '文件上传成功';
        	// echo '<pre>';
        	// var_dump($_SESSION);
        	// exit;
        	$user = new User;
        	if($user->saveFile($_SESSION['user']['UEMAIL'], $destination, $name)){
        		header("Location: /index.php?r=Visitor/cloud_store");
        	}else{
                echo "false";
            }
        }
	}
?>