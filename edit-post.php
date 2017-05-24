<?php //include config
	require('config.php');
	require('credentials.php');

	$stmt = $db->prepare('SELECT postID, postTitle, postCont, postDate FROM blog_posts WHERE postID = :postID');
	$stmt->execute(array(':postID' => $_GET['id']));
	$row = $stmt->fetch();
//if not logged in redirect to login page
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Edit Post</title>
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
<?php
	include "navbar.php";
?>
<div id="wrapper">

	<h2>Edit Post</h2>
		<?php
				echo '<div class="well">';
				echo '<h1>'.$row['postTitle'].'</h1>';
				echo '<p>Posted on '.date('jS M Y', strtotime($row['postDate'])).'</p>';
				echo '<p>'.$row['postCont'].'</p>';
				echo '</div>';

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		//collect form data
		extract($_POST);

		//very basic validation
		if($postID ==''){
			$error[] = 'This post is missing a valid id!.';
		}

		if($postTitle ==''){
			$error[] = 'Please enter the title.';
		}

		if($postDesc ==''){
			$error[] = 'Please enter the description.';
		}

		if($postCont ==''){
			$error[] = 'Please enter the content.';
		}

		if(!isset($error)){

			try {

				//insert into database
				$stmt = $db->prepare('UPDATE blog_posts SET postTitle = :postTitle, postDesc = :postDesc, postCont = :postCont WHERE postID = :postID') ;
				$stmt->execute(array(
					':postTitle' => $postTitle,
					':postDesc' => $postDesc,
					':postCont' => $postCont,
					':postID' => $postID
				));

				//redirect to index page
				header('Location: dashboard.php?action=updated');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	?>


	<?php
	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo $error.'<br />';
		}
	}

		try {

			$stmt = $db->prepare('SELECT postID, postTitle, postDesc, postCont FROM blog_posts WHERE postID = :postID') ;
			$stmt->execute(array(':postID' => $_GET['id']));
			$row = $stmt->fetch(); 

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
		// Remove Post
		if(isset($_POST['remove'])){
			try {

				$stmt = $db->prepare('DELETE FROM blog_posts WHERE postID = :postID') ;
				$stmt->execute(array(':postID' => $_GET['id']));
				$row = $stmt->fetch(); 
				header('Location: dashboard.php?action=removed');		
		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
		}
	?>

	<form action='' method='post'>
		<input type='hidden' name='postID' value='<?php echo $row['postID'];?>'>
		<div class="input-group">
			<p><label>Title</label><br />
			<input type='text' name='postTitle' value='<?php echo $row['postTitle'];?>'></p>

			<p><label>Description</label><br />
			<textarea name='postDesc' cols='60' rows='10'><?php echo $row['postDesc'];?></textarea></p>

			<p><label>Content</label><br />
			<textarea name='postCont' cols='60' rows='10'><?php echo $row['postCont'];?></textarea></p>
		</div>
		<p><input class="btn-primary" type='submit' name='submit' value='Update'></p>

	</form>
	<form action='' method='post'>
		<input type='hidden' name='postID' value='<?php echo $row['postID'];?>'>
		<p><input class="btn-danger" type='submit' name='remove' value='Remove Post'></p>
</div>

</body>
</html>	
