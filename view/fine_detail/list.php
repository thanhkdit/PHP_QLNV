<?php include '../../classes/fine_detail.php' ?>
<?php
  $fine_detail = new Fine_detail();
  if(isset($_GET['delid'])){
    $id = $_GET['delid'];
    $deleted = $fine_detail->del_fine_detail($id);
  }
?>
<?php include '../../inc/header.php' ?>
<div class="body row">
  <?php include '../../inc/sidebar.php' ?>
  <div class="content  col-10 col-sm-9 col-xl-10">
    <h3 class="text-center display-block">Fine Detail List</h3>
    <?php
      if(isset($deleted)){
        echo $deleted;
      }
    ?>
    <table id="list-fineDetail" class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Ordinal</th>
          <th scope="col">Fine Id</th>
          <th scope="col">Fine Reason</th>
          <th scope="col">Fine</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $show = $fine_detail->show('t_Fine_detail');
          if($show){
            $i = 0;
            while ($result = $show->fetch_assoc()){
              $i++;
        ?>
        <tr>
          <td class="py-3"><?php echo $i ?></td>
          <td class="py-3"><?php echo $result['Fine_id']; ?></td>
          <td class="py-3"><?php echo $result['Fine_reason']; ?></td>
          <td class="py-3"><?php echo $result['Fine']; ?></td>
          <td>
            <a href="edit.php?editid=<?php echo $result['Fine_id'] ?>"><i class="fas fa-pencil-alt btn btn-primary"></i></a>
            <a href="?delid=<?php echo $result['Fine_id'] ?>" onclick="return confirm('Are you want to delete?')"><i class="fas fa-trash-alt btn btn-danger"></i></a>
          </td>
        </tr>
        <?php
          }
        }
        ?>


      </tbody>
    </table>
  </div>
</div>
<?php include '../../inc/footer.php' ?>
