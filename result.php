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
    } else {
        die ('Poll with that ID does not exist.');
    }
} else {
    die ('No poll ID specified.');
}
?>

<?=template_header("Results", "fas fa-vote-yea fa-2x")?>

<div class="d-flex align-items-center text-center" style="min-height: 100vh">
    <div class="box w-100">
      <h2>Results</H2>
        <i class="fas fa-poll fa-2x"></i>
        <div class="container">
            <table class="table table-light table-striped mt-5 mb-5">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">Field</th>
                        <th scope="col">Data</th>
                        <th scope="col">% of Votes</th>
                    </tr>
                </thead>
                <tr>
                    <td>Poll Qestion</td>
                    <td><?=$poll['title'];?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><?=$poll['desc']?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Start of Poll</td>
                    <td><?=$poll['timestamp']?></td>
                    <td></td>
                </tr>
                <?php foreach ($poll_answers as $poll_answer): ?>
                    <tr>
                    <td><?=$poll_answer['title']?> </td>
                    <td><span>(<?=$poll_answer['votes']?> Votes)</span></td>
                    <!-- Display % of this vote to total votes -->
                    <td><?=round(($poll_answer['votes']/$total_votes) * 100) . "%";?>
                    </tr>
                <?php endforeach; ?>
            </table>

            <a class="btn btn-success mt-5 mb-5" href="index.php">Home</a>
            <a class="btn btn-info mt-5 mb-5" href="vote.php?id=<?=$poll['id']?>" title="View Poll">Back</a>
            

        </div>
        
      </div>
    </div>





<?=template_footer()?>