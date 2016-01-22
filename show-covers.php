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
		<hr />-->
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
                                       $stmt = $db->query('SELECT postID, postTitle, authorFirstName, authorLastName, authorSortName, embed, genre, postDesc, postDate FROM blog_posts ORDER BY authorSortName ASC');
                                       showCovers($stmt);
                                   }
                                   elseif (isset($_GET['titleSort'])){
                                       $stmt = $db->query('SELECT postID, postTitle, authorFirstName, authorLastName, embed, genre, postDesc, postDate FROM blog_posts ORDER BY postTitle ASC');
                                       showCovers($stmt);
                                   }
                                   elseif (isset($_GET['postdateSort'])){
                                       $stmt = $db->query('SELECT postID, postTitle, authorFirstName, authorLastName, embed, genre, postDesc, postDate FROM blog_posts ORDER BY postDate DESC');
                                       showCovers($stmt);
                                  // }
                                  }
                                  else {
                                       $stmt = $db->query('SELECT postID, postTitle, authorFirstName, authorLastName, embed, genre, postDesc, postDate FROM blog_posts ORDER BY authorLastName ASC');
                                       showCovers($stmt);
                                  }
                                  
			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
                                                
                        function showCovers($result) {
                            try {
                                //$stmt = $db->query('SELECT postID, postTitle, bookAuthor, embed, postDesc, postDate FROM blog_posts ORDER BY bookAuthor DESC');
                                echo '<table class="bookcovers"><tr>';
                                $i=1;
                                while($row = $result->fetch()){
				    echo '<td><div><p>'.$row['embed'].'</p><p><b><a href="viewpost.php?id='.$row['postID'].'">Read review</a></b></p></div></td>';
                                    
				    if($i%3==0){				
					echo '</tr><tr>';
                                    }
                                    $i++;
                               }
                               echo '</tr></table>';
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