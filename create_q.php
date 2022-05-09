
<?php
include_once './includes/db.inc.php';

if (!$user->is_logged_in()) {
    $user->redirect('index.php');
}

if (isset($_POST['save_question'])) {
    $content = trim($_POST['question']);

    if (empty($content)) {
        array_push($errors, "Please enter a valid question.");
    }
    else {
        try{        
        $sql = "INSERT INTO post(creator_id, content) VALUES(:creator_id, :content)";
        $query = $db_conn->prepare($sql);
        $query->bindParam(':creator_id', $_SESSION['user_session']);
        $query->bindParam(':content', $content); 
        $query->execute();
        $user->redirect('home.php');
        }
        catch (PDOException $e) {
            array_push($errors, $e->getMessage());
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create new question</title>

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
<form style="background: #ece4e4;" class="form card px-5 py-5" action="create_q.php" method="POST">
    <h2 class="h1">Create your question</h2>
        <div class="forms-inputs mb-4">
        <label class="label" for="quation">Your question</label>
        <input class='form-control' type="text" name="question" id="question" required>
        </div>


        <input class="btn btn-dark" type="submit" name="save_question" value="Save">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <script src="./assets/script.js"> </script>
</body>
</html>