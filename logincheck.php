<?php
include "credentials.php";

if(isset($_POST["login"])) {

	if( !empty($_POST["user"]) && !empty($_POST["pass"]) ) {

		$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

		$user = mysqli_real_escape_string($conn, $_POST["user"]);
		$pass = mysqli_real_escape_string($conn, $_POST["pass"]);

		$stmt = $conn->stmt_init();

		if($stmt->prepare("
			SELECT * FROM blog_members
			WHERE username = '{$user}'
			")) {
			$stmt->execute();

			$stmt->bind_result($id, $un, $up, $email, $name, $website);
			$stmt->fetch();
			//  if (password_verify($_POST["pass"], $up)) {
			 if($id != 0 && (password_verify($_POST["pass"], $up))) {
			 	setcookie("userid", $id, time() + (3600 * 8));
			 	header("Location: dashboard.php");
			} 
			else {
				echo "Finns inte.";
			}

		}

	}

}







