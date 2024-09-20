<?php
require_once('../config.php');
class Master extends DBConnection
{
	private $settings;
	public function __construct()
	{
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	function capture_err()
	{
		if (!$this->conn->error)
			return false;
		else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_brand()
	{
		// Check if user is logged in
		if (!isset($_SESSION['userdata']['id'])) {
			$resp['status'] = 'failed';
			$resp['msg'] = "User not logged in.";
			return json_encode($resp);
			exit;
		}

		// Get the logged-in user ID
		$user_id = $_SESSION['userdata']['id'];

		extract($_POST);
		$data = "";

		// Add brand fields to query
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!empty($data)) $data .= ",";
				$v = addslashes(trim($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}

		// Check if brand name already exists
		$check = $this->conn->query("SELECT * FROM `brands` WHERE `name` = '{$name}' " . (!empty($id) ? " AND id != {$id}" : ""))->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Brand Name already exists.";
			return json_encode($resp);
		}

		// Include user_id_brand if inserting a new brand
		if (empty($id)) {
			$data .= ", `user_id_brand` = '{$user_id}'";
			$sql = "INSERT INTO `brands` SET {$data}";
		} else {
			// Update query
			$sql = "UPDATE `brands` SET {$data} WHERE id = '{$id}' AND user_id_brand = '{$user_id}'";
		}

		// Execute SQL query
		$save = $this->conn->query($sql);
		if (!$save) {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
			return json_encode($resp);
		}

		$bid = !empty($id) ? $id : $this->conn->insert_id;
		$resp['status'] = 'success';
		if (empty($id))
			$resp['msg'] = "New Brand successfully saved.";
		else
			$resp['msg'] = "Brand successfully updated.";

		// Handle image upload
		if (!empty($_FILES['img']['tmp_name'])) {
			$upload_path = base_app . "uploads/brands";
			if (!is_dir($upload_path)) {
				mkdir($upload_path, 0777, true);
			}

			$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
			$fname = "{$upload_path}/{$bid}.{$ext}";

			// Move uploaded file to destination
			if (move_uploaded_file($_FILES['img']['tmp_name'], $fname)) {
				$timestamp = time();
				$image_path = "uploads/brands/{$bid}.{$ext}?v={$timestamp}";
				$qry = $this->conn->query("UPDATE brands SET `image_path` = '{$image_path}' WHERE id = '{$bid}'");
			} else {
				$resp['status'] = 'failed';
				$resp['msg'] = 'Failed to move uploaded file.';
				return json_encode($resp);
			}
		}

		if ($resp['status'] == 'success') {
			$this->settings->set_flashdata('success', $resp['msg']);
		}

		return json_encode($resp);
	}



	function delete_brand()
	{
		extract($_POST);
		$del = $this->conn->query("UPDATE `brands` set `delete_flag` = 1 where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', " Brand successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_category()
	{
		// Check if user is logged in
		if (!isset($_SESSION['userdata']['id'])) {
			$resp['status'] = 'failed';
			$resp['msg'] = "User not logged in.";
			return json_encode($resp);
			exit;
		}

		// Get the logged-in user ID
		$user_id = $_SESSION['userdata']['id'];

		extract($_POST);
		$data = "";

		// Add category fields to the query
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'description'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}

		// Handle description field separately
		if (isset($_POST['description'])) {
			if (!empty($data)) $data .= ",";
			$data .= " `description`='" . addslashes(htmlentities($description)) . "' ";
		}

		// Check if category already exists
		$check = $this->conn->query("SELECT * FROM `categories` WHERE `category` = '{$category}' " . (!empty($id) ? " AND id != {$id}" : ""))->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Category already exists.";
			return json_encode($resp);
			exit;
		}

		// If inserting a new category, include user_id
		if (empty($id)) {
			$data .= ", `user_id_categories` = '{$user_id}'";  // Include user_id in the insert
			$sql = "INSERT INTO `categories` SET {$data}";
		} else {
			// Update category
			$sql = "UPDATE `categories` SET {$data} WHERE id = '{$id}' AND user_id_categories = '{$user_id}'"; // Ensure the category belongs to the user
		}

		// Execute SQL query
		$save = $this->conn->query($sql);
		if ($save) {
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "New Category successfully saved.");
			else
				$this->settings->set_flashdata('success', "Category successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}

		return json_encode($resp);
	}

	function delete_category()
	{
		extract($_POST);
		$del = $this->conn->query("UPDATE `categories` set delete_flag = 1 where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', " Category successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_product()
	{
		// Check if user is logged in
		if (!isset($_SESSION['userdata']['id'])) {
			$resp['status'] = 'failed';
			$resp['msg'] = "User not logged in.";
			return json_encode($resp);
			exit;
		}

		// Get the logged-in user ID
		$user_id = $_SESSION['userdata']['id'];

		// Sanitize input
		$_POST['specs'] = htmlentities($_POST['specs']);
		foreach ($_POST as $k => $v) {
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);
		$data = "";

		// Add product fields to query
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'user_id'))) {
				if (!empty($data)) $data .= ",";
				$v = addslashes($v);
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}

		// Check if product already exists
		$check = $this->conn->query("SELECT * FROM `products` WHERE `name` = '{$name}' " . (!empty($id) ? " AND id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err()) return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Product already exists.";
			return json_encode($resp);
			exit;
		}

		// If adding a new product, include user_id
		if (empty($id)) {
			$data .= ", `user_id` = '{$user_id}'"; // Add user_id to the insert data
			$sql = "INSERT INTO `products` SET {$data}";
		} else {
			// Update query - ensure user_id is not tampered with
			$sql = "UPDATE `products` SET {$data} WHERE id = '{$id}' AND user_id = '{$user_id}'";
		}

		// Execute the query
		$save = $this->conn->query($sql);
		if ($save) {
			$pid = empty($id) ? $this->conn->insert_id : $id;
			$upload_path = "uploads/product_" . $pid;
			if (!is_dir(base_app . $upload_path)) {
				mkdir(base_app . $upload_path);
			}

			// Handle file uploads
			if (isset($_FILES['img']) && count($_FILES['img']['tmp_name']) > 0) {
				$err = "";
				foreach ($_FILES['img']['tmp_name'] as $k => $v) {
					if (!empty($_FILES['img']['tmp_name'][$k])) {
						$accept = array('image/jpeg', 'image/png', 'image/jfif');
						if (!in_array($_FILES['img']['type'][$k], $accept)) {
							$err = "Image file type is invalid";
							break;
						}

						// Generate unique filename and move file
						$filename = uniqid() . '_' . $_FILES['img']['name'][$k];
						$spath = base_app . $upload_path . '/' . $filename;
						if (!move_uploaded_file($_FILES['img']['tmp_name'][$k], $spath)) {
							$err = "Failed to move uploaded file";
							break;
						}
					}
				}
				if (!empty($err)) {
					$resp['status'] = 'failed';
					$resp['msg'] = 'Product successfully saved but ' . $err;
					$resp['id'] = $pid;
				}
			}

			// Success response
			if (!isset($resp)) {
				$resp['status'] = 'success';
				if (empty($id))
					$this->settings->set_flashdata('success', "New Product successfully saved.");
				else
					$this->settings->set_flashdata('success', "Product successfully updated.");
			}
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}

		return json_encode($resp);
	}




	function delete_product()
	{
		extract($_POST);
		$del = $this->conn->query("UPDATE `products` set delete_flag = 1 where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', " Product successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function delete_img()
	{
		extract($_POST);
		if (is_file($path)) {
			if (unlink($path)) {
				$resp['status'] = 'success';
			} else {
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete ' . $path;
			}
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown ' . $path . ' path';
		}
		return json_encode($resp);
	}
	function save_inventory()
	{
		extract($_POST);

		// Initialize data array
		$data = [];

		// Loop through POST data to build the data array
		foreach ($_POST as $k => $v) {
			// Skip columns that should not be included
			if (!in_array($k, array('id', 'description'))) {
				// Skip user_id_inventory if already set
				if ($k == 'user_id_inventory') {
					continue;
				}
				$data[] = "`{$k}` = '{$v}'";
			}
		}



		// Ensure user_id_inventory is included only once
		if (isset($user_id_inventory)) {
			$data[] = "`user_id_inventory` = '{$user_id_inventory}'";
		}

		// Convert array to string for SQL
		$dataString = implode(", ", $data);

		// Check for duplicate inventory
		$checkQuery = "SELECT * FROM `inventory` WHERE `product_id` = '{$product_id}' AND variant = '{$variant}'";
		if (!empty($id)) {
			$checkQuery .= " AND id != '{$id}'";
		}
		$check = $this->conn->query($checkQuery)->num_rows;

		if ($this->capture_err()) {
			return $this->capture_err();
		}

		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Inventory already exists.";
			return json_encode($resp);
			exit;
		}

		// Insert or Update SQL query
		if (empty($id)) {
			$sql = "INSERT INTO `inventory` SET {$dataString}";
		} else {
			$sql = "UPDATE `inventory` SET {$dataString} WHERE id = '{$id}'";
		}

		// Execute query
		$save = $this->conn->query($sql);

		// Handle response
		if ($save) {
			$resp['status'] = 'success';
			if (empty($id)) {
				$this->settings->set_flashdata('success', "New Inventory successfully saved.");
			} else {
				$this->settings->set_flashdata('success', "Inventory successfully updated.");
			}
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}

		return json_encode($resp);
	}


	function delete_inventory()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `inventory` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Invenory successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function register()
	{
		extract($_POST);
		$data = "";
		$_POST['password'] = md5($_POST['password']);
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `clients` where `email` = '{$email}' " . (!empty($id) ? " and id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Email already taken.";
			return json_encode($resp);
			exit;
		}
		if (empty($id)) {
			$sql = "INSERT INTO `clients` set {$data} ";
		} else {
			$sql = "UPDATE `clients` set {$data} where id = '{$id}' ";
		}
		$save = $this->conn->query($sql);
		if ($save) {
			$cid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "Account successfully created.");
			else
				$this->settings->set_flashdata('success', "Account successfully updated.");
			$this->settings->set_userdata('login_type', 2);
			foreach ($_POST as $k => $v) {
				$this->settings->set_userdata($k, $v);
			}
			$this->settings->set_userdata('id', $cid);
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function add_to_cart()
	{
		extract($_POST);
		$data = " client_id = '" . $this->settings->userdata('id') . "' ";
		$_POST['price'] = str_replace(",", "", $_POST['price']);
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `cart` where `inventory_id` = '{$inventory_id}' and client_id = " . $this->settings->userdata('id'))->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$sql = "UPDATE `cart` set quantity = quantity + {$quantity} where `inventory_id` = '{$inventory_id}' and client_id = " . $this->settings->userdata('id');
		} else {
			$sql = "INSERT INTO `cart` set {$data} ";
		}

		$save = $this->conn->query($sql);
		if ($this->capture_err())
			return $this->capture_err();
		if ($save) {
			$resp['status'] = 'success';
			$resp['cart_count'] = $this->conn->query("SELECT SUM(quantity) as items from `cart` where client_id =" . $this->settings->userdata('id'))->fetch_assoc()['items'];
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function update_cart_qty()
	{
		extract($_POST);

		$save = $this->conn->query("UPDATE `cart` set quantity = '{$quantity}' where id = '{$id}'");
		if ($this->capture_err())
			return $this->capture_err();
		if ($save) {
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function empty_cart()
	{
		$delete = $this->conn->query("DELETE FROM `cart` where client_id = " . $this->settings->userdata('id'));
		if ($this->capture_err())
			return $this->capture_err();
		if ($delete) {
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_cart()
	{
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM `cart` where id = '{$id}'");
		if ($this->capture_err())
			return $this->capture_err();
		if ($delete) {
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_order()
	{
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM `orders` where id = '{$id}'");
		$delete2 = $this->conn->query("DELETE FROM `order_list` where order_id = '{$id}'");
		$delete3 = $this->conn->query("DELETE FROM `sales` where order_id = '{$id}'");
		if ($this->capture_err())
			return $this->capture_err();
		if ($delete) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Order successfully deleted");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function place_order()
	{
		if (empty($id)) {
			$prefix = date("Ym");
			$code = sprintf("%'.05d", 1);
			while (true) {
				$check = $this->conn->query("SELECT * FROM `orders` where ref_code = '{$prefix}{$code}' ")->num_rows;
				if ($check > 0) {
					$code = sprintf("%'.05d", ceil($code) + 1);
				} else {
					break;
				}
			}
			$_POST['ref_code'] = $prefix . $code;
		}
		extract($_POST);
		$client_id = $this->settings->userdata('id');

		$data = " client_id = '{$client_id}' ";
		if (isset($ref_code))
			$data .= " ,ref_code = '{$ref_code}' ";
		$data .= " ,payment_method = '{$payment_method}' ";
		$data .= " ,amount = '{$amount}' ";
		$data .= " ,paid = '{$paid}' ";
		$data .= " ,delivery_address = '{$delivery_address}' ";
		$order_sql = "INSERT INTO `orders` set $data";
		$save_order = $this->conn->query($order_sql);
		if ($this->capture_err())
			return $this->capture_err();
		if ($save_order) {
			$order_id = $this->conn->insert_id;
			$data = '';
			$cart = $this->conn->query("SELECT c.*,p.name,i.price,p.id as pid from `cart` c inner join `inventory` i on i.id=c.inventory_id inner join products p on p.id = i.product_id where c.client_id ='{$client_id}' ");
			while ($row = $cart->fetch_assoc()) :
				// Check if inventory_id exists in inventory table
				$inventory_check = $this->conn->query("SELECT * FROM `inventory` WHERE id = '{$row['inventory_id']}'")->num_rows;
				if ($inventory_check > 0) {
					if (!empty($data)) $data .= ", ";
					$total = $row['price'] * $row['quantity'];
					$data .= "('{$order_id}','{$row['inventory_id']}','{$row['quantity']}','{$row['price']}', $total)";
				} else {
					// Handle case where inventory_id does not exist
					// You can choose to skip this item or handle it as needed
				}
			endwhile;
			if (!empty($data)) {
				$list_sql = "INSERT INTO `order_list` (order_id,inventory_id,quantity,price,total) VALUES {$data} ";
				$save_olist = $this->conn->query($list_sql);
				if ($this->capture_err())
					return $this->capture_err();
				if ($save_olist) {
					$empty_cart = $this->conn->query("DELETE FROM `cart` where client_id = '{$client_id}'");
					$data = " order_id = '{$order_id}'";
					$data .= " ,total_amount = '{$amount}'";
					$save_sales = $this->conn->query("INSERT INTO `sales` set $data");
					if ($this->capture_err())
						return $this->capture_err();
					$resp['status'] = 'success';
					$this->settings->set_flashdata('success', " Order has been placed successfully.");
				} else {
					$resp['status'] = 'failed';
					$resp['err_sql'] = $save_olist;
				}
			} else {
				// Handle case where no valid inventory_id exists
				$resp['status'] = 'failed';
				$resp['error'] = 'No valid inventory_id found.';
			}
		} else {
			$resp['status'] = 'failed';
			$resp['err_sql'] = $save_order;
		}
		return json_encode($resp);
	}

	function update_order_status()
	{
		extract($_POST);
		$update = $this->conn->query("UPDATE `orders` set `status` = '$status' where id = '{$id}' ");
		if ($update) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata("success", " Order status successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function pay_order()
	{
		extract($_POST);
		$update = $this->conn->query("UPDATE `orders` set `paid` = '1' where id = '{$id}' ");
		if ($update) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata("success", " Order payment status successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function update_account()
	{
		if (!empty($_POST['password']))
			$_POST['password'] = md5($password);
		else
			unset($_POST['password']);
		extract($_POST);
		$data = "";
		if (md5($cpassword) != $this->settings->userdata('password')) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Current Password is Incorrect";
			return json_encode($resp);
			exit;
		}
		$check = $this->conn->query("SELECT * FROM `clients`  where `email`='{$email}' and `id` != $id ")->num_rows;
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Email already taken.";
			return json_encode($resp);
			exit;
		}
		foreach ($_POST as $k => $v) {
			if ($k == 'cpassword' || ($k == 'password' && empty($v)))
				continue;
			if (!empty($data)) $data .= ",";
			$data .= " `{$k}`='{$v}' ";
		}
		$save = $this->conn->query("UPDATE `clients` set $data where id = $id ");
		if ($save) {
			foreach ($_POST as $k => $v) {
				if ($k != 'cpassword')
					$this->settings->set_userdata($k, $v);
			}

			$this->settings->set_userdata('id', $this->conn->insert_id);
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', ' Your Account Details has been updated successfully.');
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function update_client()
	{
		if (!empty($_POST['password']))
			$_POST['password'] = md5($password);
		else
			unset($_POST['password']);
		extract($_POST);
		$data = "";

		$check = $this->conn->query("SELECT * FROM `clients`  where `email`='{$email}' and `id` != $id ")->num_rows;
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Email already taken.";
			return json_encode($resp);
			exit;
		}
		foreach ($_POST as $k => $v) {
			if (in_array($k, ['id']))
				continue;
			if (!empty($data)) $data .= ",";
			$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
		}
		$save = $this->conn->query("UPDATE `clients` set $data where id = $id ");
		if ($save) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', ' Client Details Successfully Updated.');
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function delete_client()
	{
		extract($_POST);
		$delete = $this->conn->query("UPDATE `clients` set delete_flag = 1 where id = '{$id}'");
		if ($delete) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', " Client successfully deleted");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_production_harvesting()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'crops'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='" . $this->conn->real_escape_string($v) . "' ";
			}
		}
		if (isset($_POST['crops'])) {
			if (!empty($data)) $data .= ",";
			$data .= " `crops`='" . addslashes(htmlentities($crops)) . "' ";
		}
		$check = $this->conn->query("SELECT * FROM `production_harvesting` WHERE `crops` = '{$crops}' " . (!empty($id) ? " AND id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Crops entry already exists.";
			return json_encode($resp);
			exit;
		}
		if (empty($id)) {
			$sql = "INSERT INTO `production_harvesting` SET {$data} ";
			$save = $this->conn->query($sql);
		} else {
			$sql = "UPDATE `production_harvesting` SET {$data} WHERE id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if ($save) {
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "New Production Harvesting entry successfully saved.");
			else
				$this->settings->set_flashdata('success', "Production Harvesting entry successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_production()
	{
		extract($_POST);
		$del = $this->conn->query("UPDATE `production_harvesting` set delete_flag = 1 where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', " Product and Harvesting Details Successfully Deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_inorganic_fertilizers()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'crops_applied'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='" . $this->conn->real_escape_string($v) . "' ";
			}
		}

		// Add crops_applied if it's not already included in the loop
		if (isset($_POST['crops_applied']) && !empty($crops_applied)) {
			if (!empty($data)) $data .= ",";
			$data .= " `crops_applied`='" . $this->conn->real_escape_string($crops_applied) . "' ";
		}

		// Check if an entry with the same brand already exists
		$check = $this->conn->query("SELECT * FROM `inorganic_fertilizers` WHERE `brand` = '{$brand}' " . (!empty($id) ? " AND id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err()) {
			return $this->capture_err();
		}


		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Brand entry already exists.";
			return json_encode($resp);
			exit;
		}

		// Insert or update depending on whether an ID is provided
		if (empty($id)) {
			$sql = "INSERT INTO `inorganic_fertilizers` SET {$data} ";
			$save = $this->conn->query($sql);
		} else {
			$sql = "UPDATE `inorganic_fertilizers` SET {$data} WHERE id = '{$id}' ";
			$save = $this->conn->query($sql);
		}

		if ($save) {
			$resp['status'] = 'success';
			if (empty($id)) {
				$this->settings->set_flashdata('success', "New Inorganic Fertilizer entry successfully saved.");
			} else {
				$this->settings->set_flashdata('success', "Inorganic Fertilizer entry successfully updated.");
			}
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}

		// Return the response as JSON
		return json_encode($resp);
	}

	function delete_inorganic_fertilizers()
	{
		extract($_POST);
		$del = $this->conn->query("UPDATE `inorganic_fertilizers` set delete_flag = 1 where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', " Product and Harvesting Details Successfully Deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_organic_fertilizers()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'crops_applied'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='" . $this->conn->real_escape_string($v) . "' ";
			}
		}

		// Add crops_applied if it's not already included in the loop
		if (isset($_POST['crops_applied']) && !empty($crops_applied)) {
			if (!empty($data)) $data .= ",";
			$data .= " `crops_applied`='" . $this->conn->real_escape_string($crops_applied) . "' ";
		}

		// Check if an entry with the same brand already exists
		$check = $this->conn->query("SELECT * FROM `organic_fertilizers` WHERE `brand` = '{$brand}' " . (!empty($id) ? " AND id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err()) {
			return $this->capture_err();
		}


		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Brand entry already exists.";
			return json_encode($resp);
			exit;
		}

		// Insert or update depending on whether an ID is provided
		if (empty($id)) {
			$sql = "INSERT INTO `organic_fertilizers` SET {$data} ";
			$save = $this->conn->query($sql);
		} else {
			$sql = "UPDATE `organic_fertilizers` SET {$data} WHERE id = '{$id}' ";
			$save = $this->conn->query($sql);
		}

		if ($save) {
			$resp['status'] = 'success';
			if (empty($id)) {
				$this->settings->set_flashdata('success', "New Organic Fertilizer entry successfully saved.");
			} else {
				$this->settings->set_flashdata('success', "Organic Fertilizer entry successfully updated.");
			}
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}

		// Return the response as JSON
		return json_encode($resp);
	}

	function delete_organic_fertilizers()
	{
		extract($_POST);
		$del = $this->conn->query("UPDATE `organic_fertilizers` set delete_flag = 1 where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', " Product and Harvesting Details Successfully Deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_pesticides()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'brand_name'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='" . $this->conn->real_escape_string($v) . "' ";
			}
		}

		if (isset($_POST['brand_name']) && !empty($crops_applied)) {
			if (!empty($data)) $data .= ",";
			$data .= " `brand_name`='" . $this->conn->real_escape_string($brand_name) . "' ";
		}

		// Check if an entry with the same brand already exists
		$check = $this->conn->query("SELECT * FROM `pesticides` WHERE `brand_name` = '{$brand_name}' " . (!empty($id) ? " AND id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err()) {
			return $this->capture_err();
		}


		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Brand Name entry already exists.";
			return json_encode($resp);
			exit;
		}

		// Insert or update depending on whether an ID is provided
		if (empty($id)) {
			$sql = "INSERT INTO `pesticides` SET {$data} ";
			$save = $this->conn->query($sql);
		} else {
			$sql = "UPDATE `pesticides` SET {$data} WHERE id = '{$id}' ";
			$save = $this->conn->query($sql);
		}

		if ($save) {
			$resp['status'] = 'success';
			if (empty($id)) {
				$this->settings->set_flashdata('success', "Pesticides entry successfully saved.");
			} else {
				$this->settings->set_flashdata('success', "Pesticides Fertilizer entry successfully updated.");
			}
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}

		// Return the response as JSON
		return json_encode($resp);
	}

	function delete_pesticides()
	{
		extract($_POST);
		$del = $this->conn->query("UPDATE `pesticides` set delete_flag = 1 where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', " Pesticides Details Successfully Deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function save_sanitizer()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'brand_name'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='" . $this->conn->real_escape_string($v) . "' ";
			}
		}

		if (isset($_POST['brand_name'])) {
			if (!empty($data)) $data .= ",";
			$data .= " `brand_name`='" . $this->conn->real_escape_string($brand_name) . "' ";
		}

		// Check if an entry with the same brand already exists
		$check = $this->conn->query("SELECT * FROM `sanitizers` WHERE `brand_name` = '{$brand_name}' " . (!empty($id) ? " AND id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err()) {
			return $this->capture_err();
		}


		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Brand Name entry already exists.";
			return json_encode($resp);
			exit;
		}

		// Insert or update depending on whether an ID is provided
		if (empty($id)) {
			$sql = "INSERT INTO `sanitizers` SET {$data} ";
			$save = $this->conn->query($sql);
		} else {
			$sql = "UPDATE `sanitizers` SET {$data} WHERE id = '{$id}' ";
			$save = $this->conn->query($sql);
		}

		if ($save) {
			$resp['status'] = 'success';
			if (empty($id)) {
				$this->settings->set_flashdata('success', "Sanitizer entry successfully saved.");
			} else {
				$this->settings->set_flashdata('success', "Sanitizer entry successfully updated.");
			}
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}

		// Return the response as JSON
		return json_encode($resp);
	}

	function delete_sanitizer()
	{
		extract($_POST);
		$del = $this->conn->query("UPDATE `sanitizers` set delete_flag = 1 where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', " Pesticides Details Successfully Deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function farmer_register()
	{
		extract($_POST);
		$data = "";
		$_POST['password'] = md5($_POST['password']); // Hash password
		$_POST['type'] = 2; // Set type to 2 for farmers

		// Construct the data for insertion/updating, excluding 'id' from INSERT query
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}

		// Check if username already exists
		$check_query = "SELECT * FROM `users` WHERE `username` = '{$username}'" . (!empty($id) ? " AND id != {$id}" : "");
		$check = $this->conn->query($check_query)->num_rows;

		if ($this->capture_err())
			return $this->capture_err();

		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Username already taken.";
			return json_encode($resp);
			exit;
		}

		if (empty($id)) {
			// Insert query - do not include `id`
			$sql = "INSERT INTO `users` SET {$data}";
		} else {
			// Update query
			$sql = "UPDATE `users` SET {$data} WHERE id = '{$id}'";
		}

		$save = $this->conn->query($sql);

		if ($save) {
			$cid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if (empty($id)) {
				$this->settings->set_flashdata('success', "Account successfully created.");
			} else {
				$this->settings->set_flashdata('success', "Account successfully updated.");
			}
			$this->settings->set_userdata('login_type', 2);
			foreach ($_POST as $k => $v) {
				$this->settings->set_userdata($k, $v);
			}
			$this->settings->set_userdata('id', $cid);
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}

		return json_encode($resp);
	}
	function ati_register()
	{
		extract($_POST);
		$data = "";
		$_POST['password'] = md5($_POST['password']); // Hash password
		$_POST['type'] = 3; // Set type to 2 for farmers

		// Construct the data for insertion/updating, excluding 'id' from INSERT query
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}

		// Check if username already exists
		$check_query = "SELECT * FROM `users` WHERE `username` = '{$username}'" . (!empty($id) ? " AND id != {$id}" : "");
		$check = $this->conn->query($check_query)->num_rows;

		if ($this->capture_err())
			return $this->capture_err();

		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Username already taken.";
			return json_encode($resp);
			exit;
		}

		if (empty($id)) {
			// Insert query - do not include `id`
			$sql = "INSERT INTO `users` SET {$data}";
		} else {
			// Update query
			$sql = "UPDATE `users` SET {$data} WHERE id = '{$id}'";
		}

		$save = $this->conn->query($sql);

		if ($save) {
			$cid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if (empty($id)) {
				$this->settings->set_flashdata('success', "Account successfully created.");
			} else {
				$this->settings->set_flashdata('success', "Account successfully updated.");
			}
			$this->settings->set_userdata('login_type', 3);
			foreach ($_POST as $k => $v) {
				$this->settings->set_userdata($k, $v);
			}
			$this->settings->set_userdata('id', $cid);
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}

		return json_encode($resp);
	}

	function bpi_register()
	{
		extract($_POST);
		$data = "";
		$_POST['password'] = md5($_POST['password']); // Hash password
		$_POST['type'] = 4; // Set type to 2 for farmers

		// Construct the data for insertion/updating, excluding 'id' from INSERT query
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}

		// Check if username already exists
		$check_query = "SELECT * FROM `users` WHERE `username` = '{$username}'" . (!empty($id) ? " AND id != {$id}" : "");
		$check = $this->conn->query($check_query)->num_rows;

		if ($this->capture_err())
			return $this->capture_err();

		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Username already taken.";
			return json_encode($resp);
			exit;
		}

		if (empty($id)) {
			// Insert query - do not include `id`
			$sql = "INSERT INTO `users` SET {$data}";
		} else {
			// Update query
			$sql = "UPDATE `users` SET {$data} WHERE id = '{$id}'";
		}

		$save = $this->conn->query($sql);

		if ($save) {
			$cid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if (empty($id)) {
				$this->settings->set_flashdata('success', "Account successfully created.");
			} else {
				$this->settings->set_flashdata('success', "Account successfully updated.");
			}
			$this->settings->set_userdata('login_type', 4);
			foreach ($_POST as $k => $v) {
				$this->settings->set_userdata($k, $v);
			}
			$this->settings->set_userdata('id', $cid);
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}

		return json_encode($resp);
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_brand':
		echo $Master->save_brand();
		break;
	case 'delete_brand':
		echo $Master->delete_brand();
		break;
	case 'save_category':
		echo $Master->save_category();
		break;
	case 'delete_category':
		echo $Master->delete_category();
		break;
		/* 	case 'save_sub_category':
		echo $Master->save_sub_category();
		break;
	case 'delete_sub_category':
		echo $Master->delete_sub_category();
		break; */
	case 'save_product':
		echo $Master->save_product();
		break;
	case 'delete_product':
		echo $Master->delete_product();
		break;
	case 'save_inventory':
		echo $Master->save_inventory();
		break;
	case 'delete_inventory':
		echo $Master->delete_inventory();
		break;
	case 'register':
		echo $Master->register();
		break;
	case 'add_to_cart':
		echo $Master->add_to_cart();
		break;
	case 'update_cart_qty':
		echo $Master->update_cart_qty();
		break;
	case 'delete_cart':
		echo $Master->delete_cart();
		break;
	case 'empty_cart':
		echo $Master->empty_cart();
		break;
	case 'delete_img':
		echo $Master->delete_img();
		break;
	case 'place_order':
		echo $Master->place_order();
		break;
	case 'update_order_status':
		echo $Master->update_order_status();
		break;
	case 'pay_order':
		echo $Master->pay_order();
		break;
	case 'update_account':
		echo $Master->update_account();
		break;
	case 'update_client':
		echo $Master->update_client();
		break;
	case 'delete_order':
		echo $Master->delete_order();
		break;
	case 'delete_client':
		echo $Master->delete_client();
		break;
	case 'save_production_harvesting':
		echo $Master->save_production_harvesting();
		break;
	case 'delete_production':
		echo $Master->delete_production();
		break;
	case 'save_inorganic_fertilizers':
		echo $Master->save_inorganic_fertilizers();
		break;
	case 'delete_inorganic_fertilizers':
		echo $Master->delete_inorganic_fertilizers();
		break;
	case 'save_organic_fertilizers':
		echo $Master->save_organic_fertilizers();
		break;
	case 'delete_organic_fertilizers':
		echo $Master->delete_organic_fertilizers();
		break;
	case 'save_pesticides':
		echo $Master->save_pesticides();
		break;
	case 'delete_pesticides':
		echo $Master->delete_pesticides();
		break;
	case 'save_sanitizer':
		echo $Master->save_sanitizer();
		break;
	case 'delete_sanitizer':
		echo $Master->delete_sanitizer();
		break;
	case 'farmer_register':
		echo $Master->farmer_register();
		break;
	case 'ati_register':
		echo $Master->ati_register();
		break;
	case 'bpi_register':
		echo $Master->bpi_register();
		break;
	default:
		// echo $sysset->index();
		break;
}
