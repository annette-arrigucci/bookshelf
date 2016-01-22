<?php //include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<?php
    include "../includes/adminhead.php";
?>
  <title>Admin - Add Post</title>
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

	<h2>Add Post</h2>

	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		//collect form data
		extract($_POST);

		//very basic validation
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

		if($postDesc ==''){
			$error[] = 'Please enter the description.';
		}
                
                if($genre ==''){
			$error[] = 'Please enter the genre.';
		}
                
                if($embed ==''){
			$error[] = 'Please enter the image embed.';
		}

		if($postCont ==''){
			$error[] = 'Please enter the content.';
		}

		if(!isset($error)){

			try {
                                $authorSortName = $authorLastName.', '.$authorFirstName;
				//insert into database
				$stmt = $db->prepare('INSERT INTO blog_posts (postTitle, authorFirstName, authorLastName, authorSortName, pubDate, genre, postDesc, embed, postCont, postDate) VALUES (:postTitle, :authorFirstName, :authorLastName, :authorSortName, :pubDate, :genre, :postDesc, :embed, :postCont, :postDate)') ;
				$stmt->execute(array(
					':postTitle' => $postTitle,
                                        ':authorFirstName' => $authorFirstName,
                                        ':authorLastName' => $authorLastName,
                                        ':authorSortName' => $authorSortName,
				        ':pubDate' => $pubDate,
                                        ':genre' => $genre,
                                        ':postDesc' => $postDesc,
                                        ':embed'=> $embed,
					':postCont' => $postCont,
					':postDate' => date('Y-m-d H:i:s')
				));

				//redirect to index page
				header('Location: index.php?action=added');
				exit;

			} catch(PDOException $e) {
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

	<form action='' method='post'>

		<p><label>Title</label><br />
		<input type='text' name='postTitle' value='<?php if(isset($error)){ echo $_POST['postTitle'];}?>'></p>
                
                <p><label>Author's first name</label><br />
		<input type='text' name='authorFirstName' value='<?php if(isset($error)){ echo $_POST['authorFirstName'];}?>'></p>
                
                <p><label>Author's last name</label><br />
		<input type='text' name='authorLastName' value='<?php if(isset($error)){ echo $_POST['authorLastName'];}?>'></p>
                
                <p><label>Year of Publication</label><br />
		<input type='text' name='pubDate' value='<?php if(isset($error)){ echo $_POST['pubDate'];}?>'></p>
                
                <p><label>Genre</label><br />
		<input type='text' name='genre' value='<?php if(isset($error)){ echo $_POST['genre'];}?>'></p>

		<p><label>Description</label><br />
		<textarea name='postDesc' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postDesc'];}?></textarea></p>
                
                <p><label>Image Embed</label><br />
		<textarea name='embed' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['embed'];}?></textarea></p>

		<p><label>Content</label><br />
		<textarea name='postCont' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea></p>

		<p><input type='submit' name='submit' value='Submit'></p>

	</form>

</div>
