<?php require('includes/config.php'); 

$stmt = $db->prepare('SELECT postID, postTitle, authorFirstName, authorLastName, pubDate, embed, genre, postCont, postDate FROM blog_posts WHERE postID = :postID');
$stmt->execute(array(':postID' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if($row['postID'] == ''){
	header('Location: ./');
	exit;
}

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

	<div id="wrapper">

		<h1>Annette Arrigucci's bookshelf</h1>
		<hr />
		<p><a href="./">Blog Index</a></p>
-->
<?php
    include "includes/head.php";
?>
        <div id="main">
		<?php	
                    echo '<div id = "bookembed">'.$row['embed'].'</div>';	
                    echo '<div>';
                    echo '<h2>'.$row['postTitle'].'</h2>';
                    echo '<p><b>By '.$row['authorFirstName'].' '.$row['authorLastName'].'</b></p>';
                    echo '<p><b>Published in '.$row['pubDate'].'</b></p>';
                    echo '<p><b>Genre:</b> '.$row['genre'].'</p>';
                    echo '<p>Posted on '.date('jS M Y', strtotime($row['postDate'])).'</p>';
                    echo '<p>'.$row['postCont'].'</p>';				
                    echo '</div>';
		?>

	
       
</div>
<?php
    include "includes/menu.php";
?>
<?php
    include "includes/footer.php";
?>
<!--</body>
</html>-->