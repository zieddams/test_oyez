<?php
// Include necessary file
include_once './includes/db.inc.php';
include_once './includes/Posts.class.php';

// Check if user is not logged in

if (!$user->is_logged_in()) {
    $user->redirect('index.php');
}


$post = new Post($db_conn);
$list_q = $post->getAllquestions();


if (isset($_POST['save_anws'])) {
    $post_id = $_POST['post_id'];
    $ans = $_POST['your_answ_input'];
    $creator_id = $_SESSION['user_session'];
    $post->save_answer($post_id,$ans,$creator_id);
}
try {
    // Define query to select values from the users table
    $sql = "SELECT * FROM users WHERE user_id=:user_id";

    // Prepare the statement
    $query = $db_conn->prepare($sql);

    // Bind the parameters
    $query->bindParam(':user_id', $_SESSION['user_session']);

    // Execute the query
    $query->execute();

    // Return row as an array indexed by both column name
    $returned_row = $query->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    array_push($errors, $e->getMessage());
}

if (isset($_GET['logout']) && ($_GET['logout'] == 'true')) {
    $user->log_out();
    $user->redirect('index.php');
}

if(isset($_GET['create_question']) && ($_GET['create_question'] == 'true')){
    $user->redirect('create_q.php');
}
function getUserName($user_id){

   return $user->getUsename($user_id);
      
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet"  href="./assets/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <!-- Latest compiled JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


</head>
<body>

    <?php if (is_countable($errors > 0)): ?>
    <p>Error(s):</p>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach ?>
    </ul>
    <?php endif ?>
            <div>

    <p  class="btn btn-danger">Welcome, <?= $returned_row['user_name']; ?>. <a style="text-decoration: none;
color: white;" href="?logout=true">Log out</a></p>
<a href="?create_question=true" class="btn btn-success" style="float:left">Create new question</a>
        </div style="padding: 1rem;">
            <div class="card">

                <h1> Liste des questions</h1>

            <div class="list_q_container">
            <?php
            $l = "";
            foreach ($list_q as $q){
              
               echo '<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">By '.$user->getUsename($q['creator_id']).'</h5>
    <p class="card-text">'.$q['content'].'</p>
        <a href="#" class="card-link your_ans btn btn-sm" style="background: gray;color: white;" data-id="'.$q['id'].'">your Answer</a>
        <a href="#" class="card-link list_ans btn btn-sm" style="background: gray;color: white;">List answers</a>
                <div class="glob_form_'.$q['id'].'" id="'.$q['id'].'" style="text-align: center; display:none;">
                    <form action="home.php" method="POST">
                    <input style="margin-block:2rem" type="text" class="form-control your_answ_input"
                    name="your_answ_input" placeholder="your answer">
                     <input type="text" value="'.$q['id'].'" name="post_id" style="display:none;">
                    <input type="submit" name="save_anws" class="btn btn-primary" value="save"/>
                    </form>
                </div>

                <div>
                


    </div>
    </div>';

            }
            

            ?>
            </div>
            </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <script src="./assets/script.js"> </script>
</body>
</html>
