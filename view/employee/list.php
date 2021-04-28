<?php include '../../classes/employee.php' ?>
<?php
  $employee = new Employee();
  if(isset($_GET['delid'])){
    $id = $_GET['delid'];
    $deleted = $employee->del_employee($id);
  }
?>
<?php include '../../inc/header.php' ?>
<div class="body row">
  <?php include '../../inc/sidebar.php' ?>
  <div class="content  col-10 col-sm-9 col-xl-10">
    <h3 class="text-center display-block">Employee List</h3>
    <?php
      if(isset($deleted)){
        echo $deleted;
      }
    ?>
    <table id="list-employee" class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Ordinal</th>
          <th scope="col">Employee Id</th>
          <th scope="col">Full Name</th>
          <th scope="col">Gender</th>
          <th scope="col">Position Id</th>
          <th scope="col">Department Id</th>
          <th scope="col">Level Id</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $show = $employee->show('t_Information_of_employee');
          if($show){
            $i = 0;
            while ($result = $show->fetch_assoc()){
              $i++;
        ?>
        <tr>
          <td class="py-3"><?php echo $i ?></td>
          <td class="py-3"><?php echo $result['Employee_id']; ?></td>
          <td class="py-3"><?php echo $result['Fullname']; ?></td>
          <td class="py-3"><?php echo $result['Gender']; ?></td>
          <td class="py-3"><?php echo $result['Position_id']; ?></td>
          <td class="py-3"><?php echo $result['Department_id']; ?></td>
          <td class="py-3"><?php echo $result['Level_id']; ?></td>
          <td>
            <a href="edit.php?editid=<?php echo $result['Employee_id'] ?>"><i class="fas fa-pencil-alt btn btn-primary"></i></a>
            <a href="?delid=<?php echo $result['Employee_id'] ?>" onclick="return confirm('Are you want to delete?')"><i class="fas fa-trash-alt btn btn-danger"></i></a>
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
