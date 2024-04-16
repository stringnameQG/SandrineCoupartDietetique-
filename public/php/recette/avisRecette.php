<?php 
function requeteView(
    int $score,
    string $comment,
    int $recipe,
    int $userId
    ) {
        echo "acces php requeteView";
    $pdo = new PDO('mysql:host=localhost;dbname=stephaniecarondiatetique', 'root', '');
    $statement = $pdo->prepare(
        "INSERT INTO view 
        ( score, comment, recipe_id, user_id_id) 
        VALUES( :score, :comment, :recipe, :userId )");
    $statement->bindValue(':score', $score, PDO::PARAM_INT);
    $statement->bindValue(':comment', $comment, PDO::PARAM_STR);
    $statement->bindValue(':recipe', $recipe, PDO::PARAM_INT);
    $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
    if ($statement->execute()) {
        echo "enter execute";
        $view = $statement->fetchAll(PDO::FETCH_ASSOC);
        $view = json_encode($view);
        echo $view;
    } else {
        echo "error";
    }
}

if(isset($_POST['comment'])) {
    $score = $_POST['score'];
    $comment = $_POST['comment'];
    $recipe = $_POST['recipe'];
    $userId = $_POST['userId'];
    echo "acces php";
    requeteView(
        $score,
        $comment,
        $recipe,
        $userId
    );
}
?>