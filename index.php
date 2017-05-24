<html>
    <head>
        <title>Start</title>
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
        include "navbar.php";
    ?>

        </div>
        <?php require('config.php'); ?>
            <div id="wrapper">

                <h1>Blog</h1>
                <hr />

                <?php
                    try {

                        $stmt = $db->query('SELECT postID, postTitle, postDesc, postDate, postedBy FROM blog_posts ORDER BY postID DESC');
                        while($row = $stmt->fetch()){
                            $poster = $row['postedBy'];
                            $stmt2 = $db->query("SELECT * FROM blog_members WHERE memberID ='{$poster}'");
                            $posters = $stmt2->fetch();
                            echo '<div class="postdiv">';
                                echo '<h1><a href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h1>';
                                echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).' by '.$posters['name'].', '.$posters['email'].', '.$posters['website']. '</p>';
                                echo '<p>'.$row['postDesc'].'</p>';				
                                echo '<p><a href="viewpost.php?id='.$row['postID'].'">Read full post</a></p>';
                                // echo '<p> This post has X comments </p>';
                            echo '</div>';
                        }

                    } catch(PDOException $e) {
                        echo $e->getMessage();
                    }
                ?>

            </div>
    </body>
</html>