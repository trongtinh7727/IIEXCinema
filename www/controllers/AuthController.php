<?php
class AuthController
{
    public $model;

    public function setModel($model)
    {
        $this->model = $model;
    }

    function isAuthenticated()
    {
        if (!isset($_SESSION['userLogin'])) {
            header("Location: /?login");
            exit;
        }
    }

    function validateParams($params)
    {
        foreach ($params as $param) {
            if (!isset($_POST[$param]) || strlen($_POST[$param]) < 1) {
                die(json_encode(array('status' => false, 'data' => 'Parameters not valid: ' . $param)));
            }
        }
        return array_map('trim', $_POST);
    }

    function Login()
    {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            // $tb use to check if user or admin login
            $tb = $_POST['tb'];
            // check login 
            $check =  $this->model->CheckUserLogin($username, $password, $tb);
            if ($check != null) {
                // if login successful storage account info to session
                $_SESSION['userLogin']['username'] = $username;
                $_SESSION['userLogin']['name'] = $check['FIRSTNAME'] . " " . $check['LASTNAME'];
                $_SESSION['userLogin']['ID'] = $check['ID'];
                if ($tb == 'staff') {
                    // admin -> redirec to admin page
                    $_SESSION['userLogin']['role'] = 1;
                    header("Location: /?admin/staff");
                } else {
                    // if user -> redirec to home page
                    $_SESSION['userLogin']['role'] = 2;
                    header("Location: /?");
                }
            }
        }
        // if is authicated then redirec to admin or home page by role
        if (isset($_SESSION['userLogin'])) {
            if ($_SESSION['userLogin']['role'] == 1) {
                header("Location: /?admin/staff");
            } else {
                header("Location: /?");
            }
        } else {
            // if is't authicated then load login form
            if (strpos($_SERVER['REQUEST_URI'], 'admin') !== false) {
                require_once('views/Admin/Auths/login.php');
            } else {
                require_once('views/Client/Auths/login.php');
            }
        }
    }

    public function changePassword()
    {

        if (isset($_POST['newpassword'])) {
            $username = $_SESSION['userLogin']['username'];
            $password = $_POST['password'];
            $newpassword = $_POST['newpassword'];
            $tb = $_POST['tb'];
            $check =  $this->model->changePassword($username, $password, $newpassword, $tb);
            if ($check != null) {
                $msg = "Đổi mật khẩu thành công";
                require_once('views/Client/Auths/changepass.php');
            } else {
                $err = "Có lỗi xảy ra!";
                require_once('views/Client/Auths/changepass.php');
            }
        } else {
            require_once('views/Client/Auths/changepass.php');
        }
    }

    function register()
    {
        $params = array(
            'USERNAME', 'FIRSTNAME', 'LASTNAME', 'SEX', 'BIRTHDAY', 'PHONE', 'ADDRESS', 'PASSWORD'
        );
        $data = $this->validateParams($params);
        $check =  $this->model->add(
            $data['USERNAME'],
            $data['PASSWORD'],
            $data['FIRSTNAME'],
            $data['LASTNAME'],
            $data['SEX'],
            $data['BIRTHDAY'],
            $data['PHONE'],
            $data['ADDRESS']
        );

        if ($check == true) {
            $_POST['username'] = $data['USERNAME'];
            $_POST['password'] =  $data['PASSWORD'];
            $_POST['tb'] = "Client";
            $this->Login();
        } else {
            $err = $check;
        }
    }

    function logout()
    {
        unset($_SESSION['userLogin']);
        if (strpos($_SERVER['REQUEST_URI'], 'admin') !== false) {
            require_once('views/Admin/Auths/login.php');
        } else {
            require_once('views/Client/Auths/login.php');
        }
    }
}
