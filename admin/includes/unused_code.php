//Unused Code

<?php 
$parse = parse_url($_SERVER['REQUEST_URI']);
$my_path = $parse['path'];
$path_parts = explode('/', $my_path);
$final_parts = $path_parts[3];

    echo  "$final_parts";

if($final_parts === '../includes/users.php' ) {?>
    <div class="form-group pull-right">
    <input class="btn btn-primary" type="submit" name="edit_user" value="Add User">        
    </div>
    

<?php }
else {
}
?>


//pagination

<?php //CREATING PAGINATION STUDENT CODE WITH PREVIOUS / NEXT BUTTON

if($page != 1 && $page != ""){

$prev_page = $page - 1;

echo "<li><a class='page-link' href='index.php?page={$prev_page}' aria-label='Previous'><span aria-hidden='true'>&laquo;</span>
<span class='sr-only'>Previous</span></a></li>";


}

for($i = 1; $i <= $count ; $i++){

if($i == $page || ($i == 1 && $page == 1)){

echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
} else {

echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";

}

}

if($page != $count && $page != ""){

$next_page = $page + 1;

// echo "<li><a href='index.php?page={$next_page}'>NEXT</a></li>";
echo "<li><a class='page-link' href='index.php?page={$prev_page}' aria-label='Next'><span aria-hidden='true'>&raquo;</span>
<span class='sr-only'></span></a></li>";


}


?>
