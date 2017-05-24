<?php //include config
require_once('config.php');

//if not logged in redirect to login page
// if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
	<title>Admin - Add Post</title>
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="style/normalize.css">
	<link rel="stylesheet" href="style/main.css">
	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  	<script>
          tinymce.init({
              selector: "textarea",
              plugins: [
                  "advlist autolink lists link image charmap print preview anchor",
                  "searchreplace visualblocks code fullscreen",
                  "insertdatetime media table contextmenu paste"
              ],
              toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
          });
  </script>
</head>
<body>

<div id="wrapper">

	<?php include('navbar.php');
	//Connect to User database to determine author of post
	$userID = $_COOKIE["userid"];
	$stmt2 = $db->query("SELECT * FROM blog_members WHERE memberID = '{$userID}'");
	$stmt2->execute();
	$blog_user = $stmt2->fetch();
	?>
	<h2>Add Post</h2>

	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		//collect form data
		extract($_POST);

		//very basic validation
		if($postTitle ==''){
			$error[] = 'Please enter the title.';
		}

		if($postDesc ==''){
			$error[] = 'Please enter the description.';
		}

		if($postCont ==''){
			$error[] = 'Please enter the content.';
		}
		// if($postCategory ==''){
		// 	$error[] = 'Please select a category';
		// }

		if(!isset($error)){

			try {

				//insert into database
				$stmt = $db->prepare('INSERT INTO blog_posts (postTitle,postDesc,postCont,postDate,postedBy) VALUES (:postTitle, :postDesc, :postCont, :postDate, :postedBy)') ;
				$stmt->execute(array(
					':postTitle' => $postTitle,
					':postDesc' => $postDesc,
					':postCont' => $postCont,
					':postDate' => date('Y-m-d H:i:s'),
					':postedBy' => $blog_user["memberID"],
					// ':postCategory' => $postCategory
				));

				//redirect to index page
				header('Location: dashboard.php?action=added');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		}
	}
	?>

	<form action='' method='post'>

		<p><label>Title</label><br />
		<input type='text' name='postTitle' value='<?php if(isset($error)){ echo $_POST['postTitle'];}?>'></p>

		<p><label>Description</label><br />
		<textarea name='postDesc' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postDesc'];}?></textarea></p>

		<p><label>Content</label><br />
		<textarea name='postCont' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea></p>
		
		<!--<p><label>Category</label><br />
		<select name="Select a Category">
			<option value="<?php if(isset($error)){ echo $_POST['postCategory'];}?>">No Category</option>
			<option value="<?php if(isset($error)){ echo $_POST['postCategory'];}?>">Misc Category</option> 
			<option value="<?php if(isset($error)){ echo $_POST['postCategory'];}?>">Tech category</option>
		</select>
		<!--</p>-->

		<p><input type='submit' name='submit' value='Submit'></p>

	</form>

</div>
