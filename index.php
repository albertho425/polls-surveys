<?php
include 'functions.php';
displays_errors();
// Connect to MySQL
$pdo = pdo_connect_mysql();
// MySQL query that selects all the polls and poll answers
$stmt = $pdo->query('SELECT p.*, 
                    GROUP_CONCAT(pa.title ORDER BY pa.id) 
                    AS answers FROM polls p 
                    LEFT JOIN poll_answers pa ON pa.poll_id = p.id 
                    GROUP BY p.id');

$polls = $stmt->fetchAll(PDO::FETCH_ASSOC);

$res = $pdo->query('SELECT COUNT(*) FROM polls');
$num_rows = $res->fetchColumn();
echo $num_rows;
echo "hi";

?>

<?=template_header("Polls and Surveys", "fas fa-vote-yea fa-2x")?>

<div class="container mt-5">

	
    <div class="row">
        <div class="col mt-5">
        <h2>Polls</h2>
            <p>Create a poll, view a poll, participate in a poll, or delete a poll</p>
            <p>To participate in a poll, click on a poll to view, and once inside you will be able to vote or see current results</p>        
        </div>
    </div>
	
	<div class="mt-5 mb-5">
    <a class="btn btn-primary btn-large" href="create.php">Create New Poll</a>
    </div>
	<table class="table table-hover table-light table-striped">
        <thead class="table-success">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Poll</th>
				<th scope="col">Answers</th>
                <th scope="col">Timestamp</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Go through the foreach loop -->
            <?php foreach ($polls as $poll): ?>
            <tr>
                <td><?=$poll['id']?></td>
                <td><?=$poll['title']?></td>
				<td><?=$poll['answers']?></td>
                <td><?php formatDate($poll['timestamp']);
                ?></td>
                
                <td class="actions">
					<a href="vote.php?id=<?=$poll['id']?>" class="view" title="View Poll"><i class="fas fa-eye"></i></a>
                    <a href="delete.php?id=<?=$poll['id']?>" class="trash" title="Delete Poll"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php
            ?>
        </tbody>
    </table>
</div>
 


<?=template_footer()?>
