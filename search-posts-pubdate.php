<?php
//include config
require_once('./includes/config.php');

/*//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//show message from add / edit page
*/
?>
<!doctype html>
<!--<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin</title>
  <link rel="stylesheet" href="./style/normalize.css">
  <link rel="stylesheet" href="./style/main.css">
</head>
<body>-->
<?php
    include "includes/head.php";
?>
	<div id="main">

	<?php
		try {
                        echo '<form action ="" method="get">';
                        echo '<select name="publicationDate">';
			echo '<option value ="">Choose publication date</option>';
			$stmt = $db->query('SELECT DISTINCT pubDate FROM blog_posts ORDER BY pubDate DESC');
			while($row = $stmt->fetch()){
                                $myPubDate = $row['pubDate'];
				echo '<option value="'.$myPubDate.'">'.$myPubDate.'</option>';
                        }				
                        echo '</select>';
                        echo '<p><input type="submit" name="submit"></p>';
                        echo '</form>';
                        //echo '<p><a href="viewpost.php?id='.$row['postID'].'">Read More</a></p>';
		} 
                catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	
        <?php

	//if form has been submitted process it
	if(isset($_GET['submit'])){

		//collect form data
	        $_GET = array_map( 'stripslashes', $_GET);
                extract($_GET);

		//very basic validation
		if($publicationDate ==''){
			$error[] = 'Please make a selection.';
		}

		if(!isset($error)){

			try {
                                /*$authorSelect = $_POST['authorSelection'];
                                echo $authorSelect;*/
				//insert into database
                            
                                //echo $_POST['authorSelection'];
                                
                                $stmt = $db->prepare('SELECT postID, postTitle, authorFirstName, authorLastName, pubDate, embed, genre, postDesc, postDate FROM blog_posts WHERE pubDate = :pubDate');
                                $stmt->execute(array(':pubDate' => $_GET['publicationDate']));
                                
                               //$row = $stmt->fetch();
                               //echo $row['postID'];
                                
                                while ($row = $stmt->fetch()) {
                            
                                   echo '<div id = "bookembed">'.$row['embed'].'</div>';        
                                                echo '<div>';
                                                echo '<h2><a href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h2>';
						echo '<p><b>By '.$row['authorFirstName'].' '.$row['authorLastName'].'</b></p>';
                                                echo '<p><b>Published in '.$row['pubDate'].'</b></p>';
                                                echo '<p><b>Genre:</b> '.$row['genre'].'</p>';
                                                echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).'</p>';
                                                echo '<p>'.$row['postDesc'].'</p>';				
						echo '<p><b><a href="viewpost.php?id='.$row['postID'].'">Read More</a></b></p>';
                                                echo '</div>';
                                }
                        }    
                                catch(PDOException $e) {
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
</div>
<!--
</body>
</html>-->
<?php
    include "includes/menu.php";
?>

<?php
    include "includes/footer.php";
?>