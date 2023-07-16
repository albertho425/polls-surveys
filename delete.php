<?php
include 'functions.php';
displays_errors();
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the poll ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the poll record exists with the id specified
    if ($poll) {
        // MySQL Query that will get all the answers from the "poll_answers" table ordered by the number of votes (descending) (highest to lowest)
        $stmt = $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id = ? ORDER BY votes DESC');
        $stmt->execute([$_GET['id']]);
        // Fetch all poll answers
        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Total number of votes, will be used to calculate the percentage
        $total_votes = 0;
        foreach ($poll_answers as $poll_answer) {
            // Every poll answers votes will be added to total votes
            $total_votes += $poll_answer['votes'];
        }
    }
    if (!$poll) {
        die ('Poll doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM polls WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            // We also need to delete the answers for that poll
            $stmt = $pdo->prepare('DELETE FROM poll_answers WHERE poll_id = ?');
            $stmt->execute([$_GET['id']]);
            // Output msg
            $msg = 'You have deleted the poll!';
        } else {
            // User clicked the "No" button, redirect them back to the home/index page
            header('Location: index.php');
            exit;
        }
    }
} else {
    die ('No ID specified!');
}
?>

<?=template_header("Delete", "fas fa-vote-yea fa-2x")?>


<div class="container mt-5 mb-5">
	<h2>Delete Poll - <?=$poll['title'] . "?"?></h2>
    
    <!-- if there is an  message, display with bootstrap class -->
    <?php if ($msg): ?>
        <div class="alert alert-success text-center mt-5 mb-5" role="alert">
            <p><?=$msg?></p>
        </div>
        <a class="btn btn-success" href="index.php">Home</a>
    <?php else: ?>

	

    <table class="table table-hover table-light table-striped mt-5">
        <thead class="table-success">
            <tr>
                <th scope="col">Field</th>
                <th scope="col">Data</th>
				
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><span>ID</td>
                <td><?=$poll['id']?></td>
            </tr>
            <tr>
                <td><span>Title</td>
                <td><?=$poll['title']?></td>
            </tr>
            <tr>
                <td><span>Description</td>
                <td><?=$poll['desc']?></td>
            </tr>
            <tr>
                <td><span>Date created</td>
                <td><?php formatDate($poll['timestamp']);?></td>
            </tr>
            <tr>
                <td><span>Total votes cast</td>
                <td><?php echo $total_votes; ?></td>
            </tr>
        </tbody>
    </table>
        <p class="mt-5">Are you sure you want to delete poll #<?=$poll['id']?>?</p>
            
    <div class="yesno">
        <a class="btn btn-danger" href="delete.php?id=<?=$poll['id']?>&confirm=yes">Yes</a>
        <a class="btn btn-primary" href="delete.php?id=<?=$poll['id']?>&confirm=no">No</a>  
    </div>

    

    <?php endif; ?>
</div>

<?=template_footer()?>