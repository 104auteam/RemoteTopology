<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/site/session.php');
    if (!$_SESSION['adminpriv']) {
        Redirect('');
    }
    // Init

    // Connect to DB
    $conn           = ConnectToDB();
    $users_table    = "`credentials`"; 
    
    // Check if page has been clicked
    if (!isset($_GET['pageNumber']) or !isset($_GET['perPageCount'])) {
        $page  = 1;
        $limit = 20;
    } else{
        $page  = $_GET['pageNumber'];
        $limit = $_GET['perPageCount'];
    }

    $starting_limit = ($page-1)*$limit;
    $select_count = "SELECT MAX(Number) FROM $users_table";
    $select_data = "SELECT `Number`,`Username`,`adminpriv`
              FROM $users_table";
    $order_limit = "ORDER BY `Number` LIMIT $starting_limit, $limit";
    

    $parameters = [];
    $sql_count  = $conn->query($select_count);
    
    $sql_data   = $conn->query($select_data.$order_limit);    
    
    $num_results = $sql_count->fetch(); $num_results = $num_results[0];
    $results = $sql_data->fetchAll();

    $total_pages = ceil($num_results/$limit);
?>

<table class="admin-table-main">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Adminpriv</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $row): ?>
            <tr>
                <td><?=$row["Number"]?></td>
                <td><?=$row['Username']?></td>
                <td><?=$row['adminpriv']?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<?php

    // Paginating part itself
    for ($page=1; $page <= $total_pages ; $page++):?>

    <!-- <a href='<?php echo "features/getPageData.php?pageNumber=$page";?>'><?php  echo $page; ?>
    </a> -->

<?php endfor; ?>