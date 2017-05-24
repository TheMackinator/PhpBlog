<?php //include config
require_once('config.php');

//if not logged in redirect to login page
// if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
	<title>Comment post</title>
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="style/normalize.css">
	<link rel="stylesheet" href="style/main.css">
</head>
<body>

<div id="wrapper">

	<?php include('navbar.php');
	?>
	<h2>Comment this post</h2>
    <?php
    //Show the post which is being commented on
    $stmt = $db->prepare('SELECT postID, postTitle, postCont, postDate,postComments FROM blog_posts WHERE postID = :postID');
    $stmt->execute(array(':postID' => $_GET['id']));
    $row = $stmt->fetch();
    $postID = $row['postID'];
        echo '<div class="postdiv">';
            echo '<h1>'.$row['postTitle'].'</h1>';
            echo '<p>'.$row['postCont'].'</p>';				
        echo '</div>';
        
	//if form has been submitted process it
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );
        $commentAmount = $row['postComments'] +1;
        $stmt2 = $db->prepare('UPDATE blog_posts SET postComments = :postComments WHERE postID = :postID');
        $stmt2->bindParam(':postComments', $commentAmount);

		//collect form data
		extract($_POST);

		//very basic validation
		if($comment ==''){
			$error[] = 'Please enter your comment text.';
		}

		if($commenterName ==''){
			$error[] = 'Please enter your name.';
		}

		if($commenterWebsite ==''){
			$error[] = 'Please enter your website.';
		}
        if($commenterEmail ==''){
        $error[] = 'Please enter your email.';
		}

		if(!isset($error)){
            
			try { 

				//insert into database
				$stmt = $db->prepare('INSERT INTO blog_comments (commentedPost,comment,commenterName,commentDate,commenterWebsite,commenterEmail) VALUES (:commentedPost, :comment, :commenterName, :commentDate, :commenterWebsite, :commenterEmail)');
				$stmt->execute(array(
                    ':commentedPost' => $postID, 
					':comment' => $comment,
					':commenterName' => $commenterName,
                    ':commentDate' => date('Y-m-d H:i:s'),
					':commenterWebsite' => $commenterWebsite,
                    ':commenterEmail' => $commenterEmail
				));

				//redirect to index page
				header('Location: dashboard.php?action=addedcomment');
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

		<p><label>Comment Text</label><br />
		<textarea name='comment' cols='40' rows='8'<?php if(isset($error)){ echo $_POST["comment"];}?>></textarea></p>
        <div class="input-group">
            <p><label>Your Name</label><br />
            <input type='text'class="form-control" name='commenterName'<?php if(isset($error)){ echo $_POST['commenterName'];}?>></p>

            <p><label>Your Website</label><br />
            <input type='text'class="form-control" name='commenterWebsite' <?php if(isset($error)){ echo $_POST['commenterWebsite'];}?>></p>
            
            <p><label>Your Email</label><br />
            <input type='email'class="form-control" name='commenterEmail' <?php if(isset($error)){ echo $_POST['commenterEmail'];}?>></p>
        </div>
		<input type='submit'class="btn-success" name='submit' value='Submit'>

	</form>

</div>
