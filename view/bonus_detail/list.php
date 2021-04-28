<?php include '../../classes/bonus_detail.php' ?>
<?php
  $bonus_detail = new Bonus_detail();
  if(isset($_GET['delid'])){
    $id = $_GET['delid'];
    $deleted = $bonus_detail->del_bonus_detail($id);
  }
?>
<?php include '../../inc/header.php' ?>
<div class="body row">
  <?php include '../../inc/sidebar.php' ?>
  <div class="content  col-10 col-sm-9 col-xl-10">
    <h3 class="text-center display-block">Bonus_detail List</h3>
    <?php
      if(isset($deleted)){
        echo $deleted;
      }
    ?>
    <table id="list-bonusDetail" class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Ordinal</th>
          <th scope="col">Bonus Id</th>
          <th scope="col">Bonus Reason</th>
          <th scope="col">Bonus</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $show = $bonus_detail->show_bonus_detail();
          if($show){
            $i = 0;
            while ($result = $show->fetch_assoc()){
              $i++;
        ?>
        <tr>
          <td class="py-3"><?php echo $i ?></td>
          <td class="py-3"><?php echo $result['Bonus_id']; ?></td>
          <td class="py-3"><?php echo $result['Bonus_reason']; ?></td>
          <td class="py-3"><?php echo $result['Bonus']; ?></td>
          <td>
            <a href="edit.php?editid=<?php echo $result['Bonus_id'] ?>"><i class="fas fa-pencil-alt btn btn-primary"></i></a>
            <a href="?delid=<?php echo $result['Bonus_id'] ?>" onclick="return confirm('Are you want to delete?')"><i class="fas fa-trash-alt btn btn-danger"></i></a>
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
