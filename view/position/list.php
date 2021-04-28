<?php include '../../classes/position.php' ?>
<?php
  $position = new Position();
  if(isset($_GET['delid'])){
    $id = $_GET['delid'];
    $deleted = $position->del_position($id);
  }
?>
<?php include '../../inc/header.php' ?>
<div class="body row">
  <?php include '../../inc/sidebar.php' ?>
  <div class="content  col-10 col-sm-9 col-xl-10">
    <h3 class="text-center display-block">Position List</h3>
    <?php
      if(isset($deleted)){
        echo $deleted;
      }
    ?>
    <table id="list-position" class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Ordinal</th>
          <th scope="col">Position Id</th>
          <th scope="col">Position Name</th>
          <th scope="col">Basic Salary</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $show = $position->show('t_Position');
          if($show){
            $i = 0;
            while ($result = $show->fetch_assoc()){
              $i++;
        ?>
        <tr>
          <td class="py-3"><?php echo $i ?></td>
          <td class="py-3"><?php echo $result['Position_id']; ?></td>
          <td class="py-3"><?php echo $result['Position_name']; ?></td>
          <td class="py-3"><?php echo $result['Basic_salary']; ?></td>
          <td>
            <a href="edit.php?editid=<?php echo $result['Position_id'] ?>"><i class="fas fa-pencil-alt btn btn-primary"></i></a>
            <a href="?delid=<?php echo $result['Position_id'] ?>" onclick="return confirm('Are you want to delete?')"><i class="fas fa-trash-alt btn btn-danger"></i></a>
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
