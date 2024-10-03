<?php
require_once('../config.php');

class Users extends DBConnection {
    private $settings;

    public function __construct() {
        global $_settings;
        $this->settings = $_settings;
        parent::__construct();
    }

    public function __destruct() {
        parent::__destruct();
    }

    public function saveUsers() {
        extract($_POST);

        // Check if username already exists
        $checkQuery = "SELECT * FROM `users` WHERE username ='{$username}' " . ($id > 0 ? "AND id != '{$id}'" : "");
        $checkResult = $this->conn->query($checkQuery);
        if ($checkResult->num_rows > 0) {
            return 3; // Username already exists
        }

        $data = [];
        foreach ($_POST as $key => $value) {
            if (!in_array($key, ['id', 'password'])) {
                $data[] = "`{$key}` = '{$value}'";
            }
        }

        if (!empty($password)) {
            $hashedPassword = md5($password);
            $data[] = "`password` = '{$hashedPassword}'";
        }

        if (!empty($_FILES['img']['tmp_name'])) {
            $avatarFilename = 'uploads/' . strtotime(date('Y-m-d H:i')) . '_' . $_FILES['img']['name'];
            $moveSuccess = move_uploaded_file($_FILES['img']['tmp_name'], '../' . $avatarFilename);
            if ($moveSuccess) {
                $data[] = "avatar = '{$avatarFilename}'";
                if (isset($_SESSION['userdata']['avatar']) && is_file('../' . $_SESSION['userdata']['avatar']) && $_SESSION['userdata']['id'] == $id) {
                    unlink('../' . $_SESSION['userdata']['avatar']);
                }
            }
        }

        $dataString = implode(', ', $data);

        if (empty($id)) {
            $query = "INSERT INTO users SET {$dataString}";
        } else {
            $query = "UPDATE users SET {$dataString} WHERE id = {$id}";
        }

        $queryResult = $this->conn->query($query);
        if ($queryResult) {
            $message = empty($id) ? 'User details successfully saved.' : 'User details successfully updated.';
            $this->settings->set_flashdata('success', $message);
            return 1;
        } else {
            return 2; // Error occurred while saving/updating user details
        }
    }

    public function deleteUsers() {
        extract($_POST);
        $avatarQuery = "SELECT avatar FROM users WHERE id = '{$id}'";
        $avatarFilename = $this->conn->query($avatarQuery)->fetch_array()['avatar'];

        $deleteQuery = "DELETE FROM users WHERE id = $id";
        $deleteResult = $this->conn->query($deleteQuery);
        if ($deleteResult) {
            $this->settings->set_flashdata('success', 'User details successfully deleted.');
            if (is_file(base_app . $avatarFilename)) {
                unlink(base_app . $avatarFilename);
            }
            return json_encode(['status' => 'success']);
        } else {
            return json_encode(['status' => 'failed']);
        }
    }

    public function saveClient() {
        if (!empty($_POST['password'])) {
            $_POST['password'] = md5($_POST['password']);
        } else {
            unset($_POST['password']);
        }

        if (isset($_POST['oldpassword'])) {
            if ($this->settings->userdata('id') > 0 && $this->settings->userdata('login_type') == 2) {
                $getUserQuery = "SELECT * FROM `client_list` WHERE id = '{$this->settings->userdata('id')}'";
                $userResult = $this->conn->query($getUserQuery);
                $user = $userResult->fetch_array();
                if ($user['password'] != md5($_POST['oldpassword'])) {
                    return json_encode([
                        'status' => 'failed',
                        'msg' => 'Current password is incorrect.'
                    ]);
                }
            }
            unset($_POST['oldpassword']);
        }

        extract($_POST);
        $data = [];
        foreach ($_POST as $key => $value) {
            if (!in_array($key, ['id'])) {
                $data[] = "`{$key}` = '{$value}'";
            }
        }
        $dataString = implode(', ', $data);

        $checkQuery = "SELECT * FROM `client_list` WHERE email = '{$email}' AND delete_flag = '0' " . (is_numeric($id) && $id > 0 ? "AND id != '{$id}'" : "");
        $checkResult = $this->conn->query($checkQuery);
        if ($checkResult->num_rows > 0) {
            return json_encode([
                'status' => 'failed',
                'msg' => 'Email already exists in the database.'
            ]);
        }

        if (empty($id)) {
            $sql = "INSERT INTO `client_list` SET {$dataString}";
        } else {
            $sql = "UPDATE `client_list` SET {$dataString} WHERE id = '{$id}'";
        }

        $saveResult = $this->conn->query($sql);
        if ($saveResult) {
            $response = ['status' => 'success'];
            if (empty($id)) {
                $response['msg'] = 'Account is successfully registered.';
            } else if ($this->settings->userdata('id') == $id && $this->settings->userdata('login_type') == 2) {
                $response['msg'] = 'Account details have been updated successfully.';
                foreach ($_POST as $key => $value) {
                    if (!in_array($key, ['password'])) {
                        $this->settings->set_userdata($key, $value);
                    }
                }
            } else {
                $response['msg'] = 'Client\'s account details have been updated successfully.';
            }
        } else {
            $response = ['status' => 'failed'];
            if (empty($id)) {
                $response['msg'] = 'Account has failed to register for some reason.';
            } else if ($this->settings->userdata('id') == $id && $this->settings->userdata('login_type') == 2) {
                $response['msg'] = 'Account details have failed to update.';
            } else {
                $response['msg'] = 'Client\'s account details have failed to update.';
            }
        }

        if ($response['status'] == 'success') {
            $this->settings->set_flashdata('success', $response['msg']);
        }
        return json_encode($response);
    }

    public function deleteClient() {
        extract($_POST);
        $deleteQuery = "UPDATE `client_list` SET delete_flag = 1 WHERE id='{$id}'";
        $deleteResult = $this->conn->query($deleteQuery);
        if ($deleteResult) {
            $message = 'Client account has been deleted successfully.';
            $this->settings->set_flashdata('success', $message);
            return json_encode(['status' => 'success', 'msg' => $message]);
        } else {
            $message = 'Client account has failed to delete.';
            return json_encode(['status' => 'failed', 'msg' => $message]);
        }
    }
}

$users = new Users();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
    case 'save':
        echo $users->saveUsers();
        break;
    case 'delete':
        echo $users->deleteUsers();
        break;
    case 'save_client':
        echo $users->saveClient();
        break;
    case 'delete_client':
        echo $users->deleteClient();
        break;
    default:
        // echo $sysset->index();
        break;
}
?>
