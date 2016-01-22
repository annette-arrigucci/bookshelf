<?php require('includes/config.php'); ?>
<!DOCTYPE html>

<?php
    include "includes/head.php";
?>
         
	<div id="main">

            <p id="intro">Hi, I'm Annette Arrigucci. I started this site as a way to remember details about all the books I read and, hopefully, to share my love of books with others. My taste in books tends toward nonfiction, biographies and essay collections, with the occasional foray into fiction. Have a question, comment or suggestion? E-mail me at <a href="mailto:annette.arrigucci@gmail.com" target="_blank">annette.arrigucci@gmail.com</a>.</p>		
            <h1>Most recently read</h1>

		<?php
			try {

				$stmt = $db->query('SELECT postID, postTitle, authorFirstName, authorLastName, embed, genre, postDesc, postDate, pubDate FROM blog_posts ORDER BY postID DESC');
				for($i=0; $i<2; $i++)
                                {
                                     $row = $stmt->fetch();
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
			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>
            <h2><a href="./show-all.php">See more posts</a></h2>
	</div>
<?php
    include "includes/menu.php";
?>
      
<?php
    include "includes/footer.php";
?>

