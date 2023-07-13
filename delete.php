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

<?=template_header(" PHP Polls and Surveys - Delete", "fas fa-vote-yea fa-2x")?>


<div class="container mt-5 mb-5">
	<h2>Delete Poll #<?=$poll['id']?></h2>
    
    <!-- if there is an  message, display with bootstrap class -->
    <?php if ($msg): ?>
        <div class="alert alert-success text-center mt-5 mb-5" role="alert">
            <p><?=$msg?></p>
        </div>
        <a class="btn btn-success" href="index.php">Home</a>
    <?php else: ?>
	<p>Are you sure you want to delete poll #<?=$poll['id']?>?</p>
    <div class="yesno">
        <a class="btn btn-danger" href="delete.php?id=<?=$poll['id']?>&confirm=yes">Yes</a>
        <a class="btn btn-primary" href="delete.php?id=<?=$poll['id']?>&confirm=no">No</a>
        
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>