<?php 
	if(isset($_POST['create_post'])){
		$post_title = escape($_POST['post_title']);
		$post_category_id = escape($_POST['post_category']);
		$post_user = escape($_POST['post_user']);
		$post_status = escape($_POST['post_status']);

		$post_image = $_FILES['image']['name'];
		$post_image_temp = $_FILES['image']['tmp_name'];

		$post_tags = escape($_POST['post_tags']);
		$post_content = escape($_POST['post_content']);
		$post_date = date('d-m-y');
		$post_comment_count = 0;
		move_uploaded_file($post_image_temp, "../images/$post_image");

		$query = "INSERT INTO posts(post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_comment_count, post_status) ";
		$query .= "VALUES({$post_category_id}, '{$post_title}', '{$post_user}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_comment_count}', '{$post_status}') ";

		$create_post_query = mysqli_query($connection, $query);

		confirm($create_post_query);
		header("Location: posts.php");
	}
?>

<form action="" method="post" enctype="multipart/form-data"> 
	<div class="form-group">
		<label for="title">Post Title</label>
		<input type="text" class="form-control" name="post_title">
	</div>
<div class="form-group">
		<label for="category">Category</label>
		<select name="post_category" id="">
			<?php 
	        $query = "SELECT * FROM categories";
	        $select_categories = mysqli_query($connection, $query);
	        confirm($select_categories);
	        while($row = mysqli_fetch_assoc($select_categories)){
	            $cat_title =  $row['cat_title'];
	            $cat_id = $row['cat_id'];

	            echo "<option value='$cat_id'>{$cat_title}</option>";

	        }
			?>
		</select>
	</div>
<!-- 	<div class="form-group">
		<label for="author">Post Author</label>
		<input type="text" class="form-control" name="post_author">
	</div> -->
	<div class="form-group">
		<label for="category">Users</label>
		<select name="post_user" id="">
			<?php 
	        $query = "SELECT * FROM users";
	        $select_users = mysqli_query($connection, $query);
	        confirm($select_users);
	        while($row = mysqli_fetch_assoc($select_users)){
	            $username =  $row['username'];
	            $user_id = $row['user_id'];

	            echo "<option value='$username'>{$username}</option>";

	        }
			?>
		</select>
	</div>
	<div class="form-group">
		<select name="post_status" id="">
			<option value="draft">Draft</option>
			<option value="published">Publish</option>
			?>
		</select>
	</div>
	<div class="form-group">
		<label for="post_image">Post Image</label>
		<input type="file" name="image">
	</div>
	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input type="text" class="form-control" name="post_tags">
	</div>
	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea class="form-control" name="post_content" id="" cols="30" rows="10">
		</textarea>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
	</div>
</form>