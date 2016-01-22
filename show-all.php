<?php
//include config
require_once('./includes/config.php');

/*//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//show message from add / edit page
*/
?>
<!DOCTYPE html>
<!--<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Annette Arrigucci's bookshelf</title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
</head>
<body>

	
    
		<h1>Annette Arrigucci's bookshelf</h1>
		<hr />
                -->
<?php
    include "includes/head.php";
?>
                <div id="main">
                <?php
		try {
                        echo '<form action= "" method="get">';
                        echo '<input type ="submit" name="authorSort" value="Author sort by last name (A to Z)">';
                        echo '<input type ="submit" name="titleSort" value="Title sort (A to Z)">';
                        echo '<input type ="submit" name="postdateSort" value="Post date sort (most recent first)">';
                        echo '<input type ="submit" name="pubdateSort" value="Publication date sort (oldest first)">';
                        echo '</form>';
                                
                        //echo '<p><a href="viewpost.php?id='.$row['postID'].'">Read More</a></p>';
		} 
                catch(PDOException $e) {
		    echo $e->getMessage();
                }
		?>
		<?php
			try {
                               //if(isset($_POST['submit'])){
                               //    echo "sort";
                                  
                                   if(isset($_GET['authorSort'])){
                                       $stmt = $db->query('SELECT postID, postTitle, authorFirstName, authorLastName, authorSortName, embed, genre, postDesc, postDate, pubDate FROM blog_posts ORDER BY authorSortName ASC');
                                       showResults($stmt);
                                   }
                                   elseif (isset($_GET['titleSort'])){
                                       $stmt = $db->query('SELECT postID, postTitle, authorFirstName, authorLastName, embed, genre, postDesc, postDate, pubDate FROM blog_posts ORDER BY postTitle ASC');
                                       showResults($stmt);
                                   }
                                   elseif (isset($_GET['postdateSort'])){
                                       $stmt = $db->query('SELECT postID, postTitle, authorFirstName, authorLastName, embed, genre, postDesc, postDate, pubDate FROM blog_posts ORDER BY postDate DESC');
                                       showResults($stmt);
                                  // }
                                  }
                                  elseif (isset($_GET['pubdateSort'])) {
                                      $stmt = $db->query('SELECT postID, postTitle, authorFirstName, authorLastName, embed, genre, postDesc, postDate, pubDate FROM blog_posts ORDER BY pubDate ASC');
                                       showResults($stmt);
                                  }
                                  else {
                                       $stmt = $db->query('SELECT postID, postTitle, authorFirstName, authorLastName, authorSortName, embed, genre, postDesc, postDate, pubDate FROM blog_posts ORDER BY authorSortName ASC');
                                       showResults($stmt);
                                  }
                                  
                               /*else {
				$stmt = $db->query('SELECT postID, postTitle, bookAuthor, embed, postDesc, postDate FROM blog_posts ORDER BY postID DESC');
				while($row = $stmt->fetch()){
					
					echo '<div>';
						echo '<h1><a href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h1>';
						echo '<p><b>By '.$row['bookAuthor'].'</b></p>';
                                                echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).'</p>';
                                                echo '<p>'.$row['embed'].'</p>';
						echo '<p>'.$row['postDesc'].'</p>';				
						echo '<p><a href="viewpost.php?id='.$row['postID'].'">Read More</a></p>';				
					echo '</div>';

				}
                               }*/
			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
                        function showResults($result) {
                            try {
                                //$stmt = $db->query('SELECT postID, postTitle, bookAuthor, embed, postDesc, postDate FROM blog_posts ORDER BY bookAuthor DESC');
                                while($row = $result->fetch()){
					
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
                       
		?>

	</div>
<!--</body>
</html>-->
<?php
    include "includes/menu.php";
?>

<?php
    include "includes/footer.php";
?>