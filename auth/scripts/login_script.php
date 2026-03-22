$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (empty($email) || empty($password)) {
  $message = "All fields are required";
  $mess = "alert-danger";

} elseif (!$user) {
  $message = "Invalid email or password";
  $mess = "alert-danger";

} elseif ($user['status'] == 0) {
  $message = "Your account has been disabled.";
  $mess = "alert-danger";

} elseif (!password_verify($password, $user["password"])) {
  $message = "Invalid email or password";
  $mess = "alert-danger";

} else {
  session_regenerate_id(true);

  $_SESSION["user_id"] = $user["id"];
  $_SESSION["user_name"] = $user["full_name"];
  $_SESSION["email"] = $user["email"];

  header("Location: ../products.php");
  exit();
}