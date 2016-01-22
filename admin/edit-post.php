<?php //include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<?php
    include "../includes/adminhead.php";
?>
  <title>Admin - Edit Post</title>
  <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
  <script>
          tinymce.init({
              selector: "textarea",
              plugins: [
                  "advlist autolink lists link image charmap print preview anchor",
                  "searchreplace visualblocks code fullscreen",
                  "insertdatetime media table contextmenu paste"
              ],
              toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
          });
  </script>
</head>
<body>

<div id="wrapper">

	<?php include('menu.php');?>
	<p><a href="./">Blog Admin Index</a></p>

	<h2>Edit Post</h2>


	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		//collect form data
		extract($_POST);

		//very basic validation
		if($postID ==''){
			$error[] = 'This post is missing a valid id!.';
		}

		if($postTitle ==''){
			$error[] = 'Please enter the title.';
		}
                
                if($authorFirstName ==''){
			$error[] = 'Please enter the author\'s first name.';
		}
                
                if($authorLastName ==''){
			$error[] = 'Please enter the author\'s last name.';
		}
                
                if($pubDate ==''){
			$error[] = 'Please enter the year of publication.';
		}
                
                if($genre ==''){
			$error[] = 'Please enter the genre.';
		}
                
                if($embed ==''){
			$error[] = 'Please enter the image embed.';
		}

		if($postDesc ==''){
			$error[] = 'Please enter the description.';
		}

		if($postCont ==''){
			$error[] = 'Please enter the content.';
		}

		if(!isset($error)){

			try {
                                $authorSortName = $authorLastName.', '.$authorFirstName;
				//insert into database
				$stmt = $db->prepare('UPDATE blog_posts SET postTitle = :postTitle, postDesc = :postDesc, authorFirstName = :authorFirstName, authorLastName = :authorLastName, authorSortName = :authorSortName, pubDate = :pubDate, genre = :genre, embed = :embed, postCont = :postCont WHERE postID = :postID') ;
				$stmt->execute(array(
					':postTitle' => $postTitle,
                                        ':authorFirstName' => $authorFirstName,
                                        ':authorLastName' => $authorLastName,
                                        ':authorSortName' => $authorSortName,
                                        ':pubDate' => $pubDate,
                                        ':genre' => $genre,
					':postDesc' => $postDesc,
                                        ':embed' => $embed,
					':postCont' => $postCont,
					':postID' => $postID
				));

				//redirect to index page
				header('Location: index.php?action=updated');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	?>


	<?php
	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo $error.'<br />';
		}
	}

		try {

			$stmt = $db->prepare('SELECT postID, postTitle, pubDate, authorFirstName, authorLastName, genre, postDesc, embed, postCont FROM blog_posts WHERE postID = :postID') ;
			$stmt->execute(array(':postID' => $_GET['id']));
			$row = $stmt->fetch(); 

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}

	?>

	<form action='' method='post'>
		<input type='hidden' name='postID' value='<?php echo $row['postID'];?>'>

		<p><label>Title</label><br />
		<input type='text' name='postTitle' value='<?php echo $row['postTitle'];?>'></p>
                
                <p><label>Author first name</label><br />
		<input type='text' name='authorFirstName' value='<?php echo $row['authorFirstName'];?>'></p>
                
                 <p><label>Author last name</label><br />
		<input type='text' name='authorLastName' value='<?php echo $row['authorLastName'];?>'></p>
                 
                <p><label>Genre</label><br />
		<input type='text' name='genre' value='<?php echo $row['genre'];?>'></p> 
                
                <p><label>Year of publication</label><br />
		<input type='text' name='pubDate' value='<?php echo $row['pubDate'];?>'></p>

		<p><label>Description</label><br />
		<textarea name='postDesc' cols='60' rows='10'><?php echo $row['postDesc'];?></textarea></p>
                
                <p><label>Image embed</label><br />
		<textarea name='embed' cols='60' rows='10'><?php echo $row['embed'];?></textarea></p>

		<p><label>Content</label><br />
		<textarea name='postCont' cols='60' rows='10'><?php echo $row['postCont'];?></textarea></p>

		<p><input type='submit' name='submit' value='Update'></p>

	</form>

</div>

</body>
</html>	
