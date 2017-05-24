<?php 	
require('config.php');
require('credentials.php');
include "navbar.php"; 

$stmt = $db->prepare('SELECT postID, postTitle, postCont, postDate, postComments FROM blog_posts WHERE postID = :postID');
$stmt->execute(array(':postID' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if($row['postID'] == ''){
	header('Location: ./');
	exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blog - <?php echo $row['postTitle'];?></title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>

	<div id="wrapper">

		<hr />


		<?php	
			echo '<div class="well">';
				echo '<h1>'.$row['postTitle'].'</h1>';
				echo '<h6><span class="label label-default">Posted on '.date('jS M Y', strtotime($row['postDate'])).'</span></h6>';
				echo '<p>'.$row['postCont'].'</p>';
				if(isset($_COOKIE["userid"]) && $_COOKIE["userid"]  ) {
					echo '<button class="btn"><a href="edit-post.php?id='.$row['postID'].'"> Edit/Remove this post</a></button>';				
				}
				echo '</div>';			
				echo '<div class="commentdiv">';
				// if ($row['postComments'] == 0) {
				// 	echo '<h3> This post has no comments, post a comment below!</h3>';
				// } else {
					echo '<h3> Comments on this post</h3>';
				// }
				$comments = $row['postID'];
				$stmt2 = $db->query("SELECT * FROM blog_comments WHERE commentedPost ='{$comments}'");
				while($post_comments = $stmt2->fetch()){
					echo '<h6><span class="label label-default"> Commented on '.$post_comments['commentDate']. ' by '.$post_comments['commenterName'].', '.$post_comments['commenterWebsite'].', ' .$post_comments['commenterEmail']. '</span></h6>';
					echo '<p>'.$post_comments['comment'].'</p>';
				}
				echo '</div>';
				echo '<button class="btn"><a href="comment.php?id='.$row['postID'].'">Comment on this post</a></button>';

		?>

	</div>

</body>
</html>