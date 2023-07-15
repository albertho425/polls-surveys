<?php
include 'functions.php';
displays_errors();
// Connect to MySQL
$pdo = pdo_connect_mysql();
// If the GET request "id" exists (poll id)...
if (isset($_GET['id'])) {
    // MySQL query that selects the poll records by the GET request "id"
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    // Fetch the record
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the poll record exists with the id specified
    if ($poll) {
        // MySQL query that selects all the poll answers
        $stmt = $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id = ?');
        $stmt->execute([$_GET['id']]);
        // Fetch all the poll anwsers
        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // If the user clicked the "Vote" button...
        if (isset($_POST['poll_answer'])) {
            // Update and increase the vote for the answer the user voted for
            $stmt = $pdo->prepare('UPDATE poll_answers SET votes = votes + 1 WHERE id = ?');
            $stmt->execute([$_POST['poll_answer']]);
            // Redirect user to the result page
            header ('Location: result.php?id=' . $_GET['id']);
            exit;
        }
    } else {
        die ('Poll with that ID does not exist.');
    }
} else {
    die ('No poll ID specified.');
}
?>

<?=template_header("Vote", "fas fa-vote-yea fa-2x")?>

<div class="d-flex align-items-center text-center" style="min-height: 100vh">
      <div class="box w-100 text-success">
        <h2 class=""><?=$poll['title']?></h2>
        <div class="container mt-5 text-center">
            <div class="card border-dark mb-3">
                <div class="card-header"><i class="fas fa-vote-yea"></i><br><?=$poll['desc']?></div>
                    <div class="card-body text-dark">
                        <h5 class="card-title"></h5>
                        <p class="card-text"></p>
                        
                        <div class="container mt-5 mb-5">
                            <div class="form-check">
                                <p>Please choose from one of the following choices:</p><br>
                                <form action="vote.php?id=<?=$_GET['id']?>" method="post">
                                    <div class="container">
                                    <?php for ($i = 0; $i < count($poll_answers); $i++): ?>
                                        <label class="form-check-label">
                                        <!-- (Condition) ? (Statement1) : (Statement2); -->

                                            <input class="vote" 
                                                    type="radio" 
                                                    name="poll_answer" 
                                                    value="<?=$poll_answers[$i]['id']?>"
                                                           <?=$i == 0 ? ' checked' : ''?>>
                                            <?=$poll_answers[$i]['title']?>
                                        </label><br>
                                    <?php endfor; ?>
                                    <div class="container mt-5 mb-5">
                                        <input type="submit" value="Vote" class="btn btn-primary">
                                        <a class="btn btn-info" href="result.php?id=<?=$poll['id']?>">Results</a>
                                        <a class="btn btn-success" href="index.php">Home</a>
                                    </div>
                                </form>
                                </div>
                            </div>    
                            <div class="text-muted">
                            <i class="fas fa-calendar-week"></i>
                                <span>Created on: </span>
                                <?=$poll['timestamp']?>
                            </div>
                        </div>
                    </div> 
            </div>
        </div>        
    </div>
</div>


<?=template_footer()?>