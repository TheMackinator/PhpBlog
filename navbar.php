
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <span class="navbar-brand" href="#">Blog</span>
            <ul class="nav nav-pills">
            <li role="presentation">
                <a class="nav-link" href="dashboard.php">Blog Home</a>
            </li>

      <?php
      if(isset($_COOKIE["userid"]) && $_COOKIE["userid"]  ) {
            echo '<li role="presentation"><a class="nav-link" href="add-post.php">New Post</a></li>';
            echo '<p class="navbar-text navbar-right"><a href="index.php">Log out</a>';
                $userID = $_COOKIE["userid"];
                $stmt = $db->query("SELECT * FROM blog_members WHERE memberID = '{$userID}'");
                $stmt->execute();
                $blog_user = $stmt->fetch();
            echo '<p class="navbar-text navbar-right">Signed in as '.$blog_user['name'].'  </p>';
        } else {
            echo '<p class="navbar-text navbar-right"><a href="login.php">Log in/Register</a>';
        }
      
      ?>
      </ul>
    </div>
</nav>