<?php
require_once "Database.php";
require_once "Validator.php";
class User
{
  use Database, Validator;
  private string $table = 'users';

  protected function index(): array
  {
    $sql = "SELECT * FROM $this->table ORDER BY id ASC LIMIT 100;";
    $stmt = $this->connect()->query($sql);
    if ($stmt->rowCount() > 0) {
      $result = $stmt->fetchAll();
      $stmt = null;
      return $result;
    } else {
      return [];
    }
  }

  protected function sendPasswordResetLink(array $post): string
  {
    return "Yes";


  }

  protected function emailTokenValidation(string $email, string $token): bool
  {

    return true;

  }

  protected function updatePasswordViaWeb(array $post): string
  {
    return "Yes";
  }

  public function login($email, $password): string
  {
    $sql = "SELECT * FROM $this->table WHERE email=:email AND active=1 LIMIT 1;";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam('email', $email, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      $result = $stmt->fetch();
      $stmt = null;
      $db_password = $result->password;
      if ($this->check_hashed_passwords($password, $db_password)) {
        $_SESSION['loggedIn_user'] = $result->username;
        $_SESSION['user_type'] = $result->userType;
        $_SESSION['loggedIn_email'] = $result->email;
        $_SESSION['loggedIn_ID'] = $result->id;
        $_SESSION['store_id'] = $result->store_id;
        $_SESSION['last_activity'] = time();
        $sql_ = "UPDATE `{$this->table}` SET login_datetime=NOW() WHERE email=:email LIMIT 1;";
        $stmt = $this->connect()->prepare($sql_);
        $stmt->bindValue('email', $email, PDO::PARAM_STR);
        $stmt->execute();
        if ($result->userType === 'Administrator') {
          $_SESSION['user_type'] = "Admin";
          $token = $this->generateToken(101);
          $_SESSION['token'] = $token;
          $dashboardPath = "admin/";
        } else {
          $_SESSION['user_type'] = "Cashier";
          $token = $this->generateToken(98);
          $_SESSION['token'] = $token;
          $dashboardPath = "cashier/posv2";
        }

        //check for active loggedIn somewhere 
        $chk = "SELECT * FROM user_token_tbl WHERE email=:email LIMIT 1;";
        $stmt = $this->connect()->prepare($chk);
        $stmt->bindParam('email', $email, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
          //user is already loggedIn somewhere, so change the session token
          $update_query = "UPDATE user_token_tbl SET token=:token WHERE email=:email LIMIT 1;";
          $stmt = $this->connect()->prepare($update_query);
          $stmt->bindParam('token', $token, PDO::PARAM_STR);
          $stmt->bindParam('email', $email, PDO::PARAM_STR);
          $stmt->execute();
          $stmt = null;
        } else {
          $insertToken = "INSERT INTO user_token_tbl (email,token) VALUES (:email,:token);";
          $stmt = $this->connect()->prepare($insertToken);
          $stmt->bindParam('email', $email, PDO::PARAM_STR);
          $stmt->bindParam('token', $token, PDO::PARAM_STR);
          $stmt->execute();
          $stmt = null;
        }
        $response = $this->toast("success", "Login successful!") . "<script>
            setTimeout(function(){
             window.location.assign('" . $dashboardPath . "');
        },500);
        </script>";
      } else {
        $response = $this->toast("error", "Invalid credentials!");// 
      }
    } else {
      $response = $this->toast("error", "Either account not found or user is lock, Contact Admin!");// invalid account details
    }
    return $response;
  }

  public function find($field, $value)
  {
    $sql = "SELECT * FROM $this->table WHERE $field=:field LIMIT 1;";
    $stmt = $this->connect()->prepare($sql);

    $type = gettype($value);
    $param_type = match ($type) {
      'integer' => PDO::PARAM_INT,
      'boolean' => PDO::PARAM_BOOL,
      default => PDO::PARAM_STR,
    };
    $stmt->bindParam('field', $value, $param_type);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      $response = $stmt->fetch();
      $stmt = null;
    } else {
      $response = [];
    }
    return $response;
  }

  protected function logout_admin($session_id, $email): string
  {

    $sql = "UPDATE $this->table SET status= 0, logout_datetime=now() WHERE id=:id LIMIT 1;";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam('id', $session_id, PDO::PARAM_INT);
    $stmt->execute();
    $statement = $this->connect()->prepare("UPDATE `user_token_tbl` SET token=NULL WHERE email=:email LIMIT 1");
    $statement->bindParam('email', $email, PDO::PARAM_STR);
    if ($statement->execute()) {
      $statement = null;
      $response = "Logout successful";
    } else {
      $response = "Logout not successful";
    }
    return $response;
  }

  protected function logout_cashier($session_id, $email): string
  {
    $sql = "UPDATE $this->table SET status= 0, logout_datetime=now() WHERE id=:id LIMIT 1;";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam('id', $session_id, PDO::PARAM_INT);
    $stmt->execute();
    $statement = $this->connect()->prepare("UPDATE `user_token_tbl` SET token=NULL WHERE email=:email LIMIT 1");
    $statement->bindParam('email', $email, PDO::PARAM_STR);
    if ($statement->execute()) {
      $statement = null;
      $response = "User Logout successful";
    } else {
      $response = "User logout not";
    }
    return $response;
  }

  public function isLoggedInUser()
  {
    if (!isset($_SESSION['loggedIn_ID']) || $_SESSION['loggedIn_ID'] === "") {
      return false;
    } else {
      return true;
    }
  }

  public function countAllUsers()
  {
    $query = "SELECT count(id) as totalUser FROM $this->table;";
    $stmt = $this->connect()->query($query);
    if ($stmt->rowCount() > 0) {
      $response = $stmt->fetch();
      $stmt = null;
      return $response->totalUser;
    } else {
      return 0;
    }
  }

  public function CreateUser()
  {

    return "Yes";

  }

  public function checkTokenExists($email, $token): bool
  {
    if (!$this->isEmptyStr($email) && !$this->isEmptyStr($token)) {
      $query = "SELECT * FROM user_token_tbl WHERE email=:email AND token=:token LIMIT 1;";
      $stmt = $this->connect()->prepare($query);
      $stmt->bindParam('email', $email, PDO::PARAM_STR);
      $stmt->bindParam('token', $token, PDO::PARAM_STR);
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
        //collect the current token from db
        $tokenRow = $stmt->fetch();
        $currentToken = $tokenRow->token;
        //compare the two tokens
        if ($token === $currentToken) {
          //return false
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    }
  }

  public function userUpdate(): string
  {
    return "Yes";

  }

  public function register_application(): string
  {
    return "Yes";
  }

  protected function image_extensions(): array
  {
    return array('png', 'jpg', 'jpeg');
  }

  public function validate_activation_code(): string
  {

    return "Yes";
  }


  protected function createActivationUser($code, $name): bool
  {
    $this->connect()->exec("DROP TABLE IF EXISTS `cms`;");
    $query = "CREATE TABLE IF NOT EXISTS `cms` (
    id INT(1) NOT NULL PRIMARY KEY,
    cms_code VARCHAR(255) NOT NULL,
    cms_name VARCHAR(255) NOT NULL,
    act_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    exp_date DATETIME DEFAULT NULL
)";
    $this->connect()->exec($query);
    $sql = $this->connect()->prepare("INSERT INTO cms (id,cms_code,cms_name,exp_date)
        VALUES (?,?,?,?)");
    $id = 1;
    date_default_timezone_set("Africa/Lagos");
    $exp_date = date('Y-m-d H:i:s', strtotime("+ 1 year"));
    if ($sql->execute([$id, $code, $name, $exp_date])) {
      return true;
    } else {
      return false;
    }
  }

  public function encrypt(string $string): string
  {
    return $this->doEncryption("code", $string);
  }

  public function decrypt(string $string): string
  {
    return $this->doEncryption("decode", $string);
  }

  private function doEncryption(string $action, mixed $string): string
  {
    $output = "";
    $Encrypt_method = ENCRYPTION_METHOD;//
    $Secret_key = FET_SECRET_ENCRYPTION_KEY;
    $Secret_iv = FET_SECRET_ENCRYPTION_KEY_IV;
    $key = hash('sha256', $Secret_key);
    $initialization_vector = substr(hash('sha256', $Secret_iv), 0, 16);

    if (!$this->isEmptyStr($string)) {
      //check the type of action
      if ($action == "code") {
        // encrypt string
        $output = openssl_encrypt($string, $Encrypt_method, $key, 0, $initialization_vector);
        $output = base64_encode($output);
      }
      if ($action == "decode") {
        // code...
        $output = base64_decode($string);
        $output = openssl_decrypt($output, $Encrypt_method, $key, 0, $initialization_vector);
      }
    }
    return $output;
  }


  protected function getApplicationName(): string
  {
    $query = "SELECT * FROM setup_tbl WHERE id =1 LIMIT 1";
    $stmt = $this->connect()->query($query);
    if ($stmt->rowCount() > 0) {
      $result = $stmt->fetch();
      return $result->company;
    } else {
      return "";
    }
  }


  protected function getApplicationDetails()
  {
    $query = "SELECT * FROM setup_tbl WHERE id=1 LIMIT 1";
    $stmt = $this->connect()->query($query);
    if ($stmt->rowCount() > 0) {
      return $stmt->fetch();
    } else {
      return "";
    }
  }


  public function register_admin_application_account(array $post): string
  {
    return "Yes";
  }

  protected function expire(): bool
  {
    // $sql = "SELECT * FROM cms WHERE DATE(exp_date) < DATE(NOW()) LIMIT 1";
    // $stmt = $this->connect()->query($sql);
    // if ($stmt->rowCount() > 0) {
    //   return true;
    // } else {
      return false;
    // }
  }

  protected function get_company_profile()
  {
    $sql = "SELECT * FROM setup_tbl WHERE id=1 LIMIT 1";
    $stmt = $this->connect()->query($sql);
    if ($stmt->rowCount() > 0) {
      return $stmt->fetch();
    } else {
      return [];
    }
  }

  protected function registerDemoUserAccount(array $request): string
  {
    return "Yes";

  }

  private function checkDemoLogger(string $field, string $value): bool
  {
    // $query = "SELECT * FROM demo_loggers_tbl WHERE $field=? LIMIT 1;";
    // $stmt = $this->connect()->prepare($query);
    // $stmt->execute([$value]);
    // if ($stmt->rowCount() > 0) {
    //   return true;
    // } else {
      return false;
    // }
  }

  private function createLoggers($ip, $email, $phone): bool
  {
    $sql = "INSERT INTO demo_loggers_tbl (ip_address,email,phone) VALUES (?,?,?);";
    $stmt = $this->connect()->prepare($sql);
    if ($stmt->execute([$ip, $email, $phone])) {
      return true;
    } else {
      return false;
    }
  }


  public function getClientIPAddress(): string
  {
    $ip = "";
    if (isset($_SERVER['HTTP_CLIENT_IP']) && !$this->isEmptyStr($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !$this->isEmptyStr($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (isset($_SERVER['REMOTE_ADDR']) && !$this->isEmptyStr($_SERVER['REMOTE_ADDR'])) {
      $ip = $_SERVER['REMOTE_ADDR'];
    } else {
      if ($ip == "::1") {

        $ip = "127.0.0.1";
      }

    }
    return $ip;
  }


}