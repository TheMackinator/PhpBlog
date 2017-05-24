<html>
    <head>
        <title>Blog Main</title>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="style/normalize.css">
    	<link rel="stylesheet" href="style/main.css">
	</head>
    <body>
		<?php
		// session_start();
		 
		include "credentials.php";
		require('config.php');
		include "navbar.php";

		?>
		<div id="wrapper">
				<div class="page-header">
				<h1>PHP Based Blog</h1>
			</div>
		<?php
			// $_SESSION["logged_in"] = false;

			// if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true  ) {
				if(isset($_COOKIE["userid"]) && $_COOKIE["userid"]  ) {
					
						try {
							
							$stmt = $db->query('SELECT postID, postTitle, postDesc, postDate, postedBy,postComments FROM blog_posts ORDER BY postID DESC');
							while($row = $stmt->fetch()){
								$poster = $row['postedBy'];
								$stmt2 = $db->query("SELECT * FROM blog_members WHERE memberID ='{$poster}'");
								$posters = $stmt2->fetch();
								echo '<div class="well">';
									echo '<h1><a href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h1>';
									echo '<h5><span class="label label-default">Posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).' by '.$posters['name'].', '.$posters['email'].', '.$posters['website']. '</span></h5>';
									echo '<p>'.$row['postDesc'].'</p>';				
									echo '<p><a href="viewpost.php?id='.$row['postID'].'">Read full post</a></p>';
									// echo '<p> This post has '.$row['postComments'].' comments </p>';
								echo '</div>';		
							}
						} catch(PDOException $e) {
							echo $e->getMessage();
						}
					?>
				
			
			<?php
			} else {
				header('Location: index.php');
			}
			?>
		</div>
	</body>
</html>