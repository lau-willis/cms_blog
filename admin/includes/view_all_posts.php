    <?php 
    include "delete_modal.php";
    if(isset($_POST['checkBoxArray'])){
        foreach($_POST['checkBoxArray'] as $postValueId){
           $bulk_options =  $_POST['bulk_options'];
           switch($bulk_options){
            case 'published': 
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
                $update_to_publish_status = mysqli_query($connection, $query);
                confirm($update_to_publish_status);
                break;
            case 'draft':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
                $update_to_draft_status = mysqli_query($connection, $query);
                confirm($update_to_draft_status);
                break;
            case 'clone':
                $query = "SELECT * FROM posts WHERE post_id = {$postValueId}";
                $select_post_query = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($select_post_query)){
                    $post_title =  $row['post_title'];
                    $post_id = $row['post_id'];
                    $post_user = $row['post_user'];
                    $post_category_id = $row['post_category_id'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_date = $row['post_date'];
                    $post_views_count = $row['post_views_count'];

                }
                $query = "INSERT INTO posts(post_title, post_user, post_category_id, post_status, post_image, post_tags, post_date) ";
                $query .= "VALUES('{$post_title}', '{$post_user}', {$post_category_id}, '{$post_status}', '{$post_image}', '${post_tags}', now())";

                $copy_query = mysqli_query($connection, $query);
                if(!$copy_query){
                    die('query failed' . mysqli_error($connection));
                }
                break;
            case 'reset_view':
                $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = {$postValueId}";
                $reset_view_query = mysqli_query($connection, $query);
                if(!$reset_view_query){
                    die('query failed' . mysqli_error($connection));
                }
                break;
            case 'delete':
                $query = "DELETE FROM posts WHERE post_id = {$postValueId} ";
                $update_to_delete_status = mysqli_query($connection, $query);
                confirm($update_to_delete_status);
                break;
           }
        }
    }
    ?>

    <form action="" method="post">

    <table class="table table-bordered table-hover">
        <div class="row">
            <div class="bulkOptionsContainer col-xs-4">
                <select class="form-control" name="bulk_options" id="">
                    <option value="">Select Options</option>
                    <option value="published">Publish</option>
                    <option value="draft">Draft</option>
                    <option value="clone">Clone</option>
                    <option value="reset_view">Reset View Count</option>
                    <option value="delete">Delete</option>
                </select>
            </div>
            <div class="col-xs-4 form-group">
                <input type="submit" name="submit" class="btn btn-success" value="Apply">
                <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
            </div>
        </div>
        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Id</th>
                <th>User</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>View Count</th>
                <th>View Post</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead> 
        <tbody>
            
            <?php
             $query = "SELECT * FROM posts ORDER BY post_id DESC";
                $select_posts = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_posts)){
                    $post_title =  $row['post_title'];
                    $post_id = $row['post_id'];
                    $post_author = $row['post_author'];
                    $post_user = $row['post_user'];
                    $post_category_id = $row['post_category_id'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_comment_count = $row['post_comment_count'];
                    $post_date = $row['post_date'];
                    $post_views_count = $row['post_views_count'];
                    
                    echo "<tr>";
                    ?>
                    <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td> 
                    <?php
                    echo "<td>{$post_id}</td>";

                    if(!empty($post_author)){
                        echo "<td>{$post_author}</td>";
                    }elseif(!empty($post_user)){
                        echo "<td>{$post_user}</td>";
                    }
                    echo "<td>{$post_title}</td>";
                     $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
                    $select_categories_id = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_assoc($select_categories_id)){
                        $cat_title =  $row['cat_title'];
                        $cat_id = $row['cat_id'];
                        echo "<td>{$cat_title}</td>";
                    }
                    echo "<td>{$post_status}</td>";
                    echo "<td><img width='100' src='../images/$post_image' alt='image'></td>";
                    echo "<td>{$post_tags}</td>";

                    $query = "SELECT * from comments WHERE comment_post_id = $post_id";
                    $send_comment_query = mysqli_query($connection, $query);

                    $row = mysqli_fetch_assoc($send_comment_query);
                    $comment_id = $row['comment_id'];
                    $count_comments = mysqli_num_rows($send_comment_query);
                    echo "<td><a href='post_comments.php?id=$post_id'>$count_comments</a></td>";
                    // echo "<td>{$post_comment_count}</td>";
                    echo "<td>{$post_date}</td>";
                    echo "<td>{$post_views_count}</td>";
                    echo "<td><a href='../post.php?p_id={$post_id}'>View Post</a></td>";
                    echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>EDIT</a></td>";
                    echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";
                    // echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete this post?'); \"href='posts.php?delete={$post_id}'>DELETE</a></td>";
                    echo "</tr>";
                }

            ?> 
        </tbody>  
    </table>

    <?php 
    if(isset($_GET['delete'])){
        $the_post_id = escape($_GET['delete']);
        $query = "DELETE FROM posts WHERE post_id = {$the_post_id}";
        $delete_query = mysqli_query($connection, $query);
        header("Location: posts.php");
    }
    ?>

    <script>
        $(document).ready(function(){
            $(".delete_link").on('click', function(){
                var id = $(this).attr('rel');

                var delete_url = `posts.php?delete=${id}`;
                
                $(".modal_delete_link").attr("href", delete_url);

                $("#myModal").modal('show');
            }) 
        })
    </script>

    </form>

