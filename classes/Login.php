<?php
require_once '../config.php';
class Login extends DBConnection
{
	private $settings;
	public function __construct()
	{
		global $_settings;
		$this->settings = $_settings;

		parent::__construct();
		ini_set('display_error', 1);
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function index()
	{
		echo "<h1>Access Denied</h1> <a href='" . base_url . "'>Go Back.</a>";
	}

	public function login_admin()
	{
		extract($_POST);

		$stmt = $this->conn->prepare("SELECT * from users where username = ? and password = ? ");
		$password = md5($password);
		$stmt->bind_param('ss', $username, $password);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			foreach ($result->fetch_array() as $k => $v) {
				if (!is_numeric($k) && $k != 'password') {
					$this->settings->set_userdata($k, $v);
				}
			}
			$this->settings->set_userdata('login_type', 2);
			return json_encode(array('status' => 'success'));
		} else {
			return json_encode(array('status' => 'incorrect', 'last_qry' => "SELECT * from users where username = '$username' and password = md5('$password') "));
		}
	}
	public function login_farmer()
	{
		extract($_POST);

		$stmt = $this->conn->prepare("SELECT * from users where username = ? and password = ? ");
		$password = md5($password);
		$stmt->bind_param('ss', $username, $password);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			foreach ($result->fetch_array() as $k => $v) {
				if (!is_numeric($k) && $k != 'password') {
					$this->settings->set_userdata($k, $v);
				}
			}
			$this->settings->set_userdata('login_type', 1);
			return json_encode(array('status' => 'success'));
		} else {
			return json_encode(array('status' => 'incorrect', 'last_qry' => "SELECT * from users where username = '$username' and password = md5('$password') "));
		}
	}

	public function logout_farmer()
	{
		if ($this->settings->sess_des()) {
			redirect('farmer/login.php');
		}
	}
	public function logout_admin()
	{
		if ($this->settings->sess_des()) {
			redirect('admin/login.php');
		}
	}
	function login_user()
	{
		extract($_POST);
		$stmt = $this->conn->prepare("SELECT * from clients where email = ? and `password` = ? and delete_flag = 0 ");
		$password = md5($password);
		$stmt->bind_param('ss', $email, $password);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			$res = $result->fetch_array();
			if ($res['status'] == 1) {
				foreach ($res as $k => $v) {
					$this->settings->set_userdata($k, $v);
				}
				$this->settings->set_userdata('login_type', 2);
				$resp['status'] = 'success';
			} else {
				$resp['status'] = 'failed';
				$resp['msg'] = 'Your Account has been blocked.';
			}
		} else {
			$resp['status'] = 'failed';
			$resp['msg'] = 'Incorrect Email or Password';
		}
		if ($this->conn->error) {
			$resp['status'] = 'failed';
			$resp['_error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
}
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();
switch ($action) {
	case 'login_admin':
		echo $auth->login_admin();
		break;
	case 'login_farmer':
		echo $auth->login_farmer();
		break;
	case 'login_user':
		echo $auth->login_user();
		break;
	case 'logout_farmer':
		echo $auth->logout_farmer();
		break;
	case 'logout_admin':
		echo $auth->logout_admin();
		break;
	default:
		echo $auth->index();
		break;
}
