
<!-- This is the plans view of sidebar -->

<div >
  <h2 class="text-center">All Plans</h2>
  <table class="table ">
    <thead>
      <tr>
        <th class="text-center">Plan_ID</th>
        <th class="text-center">Plan name</th>
        <th class="text-center">Plan Price (rs.) </th>
        <th class="text-center">Plan description</th>
        <th class="text-center">Plan duration(in months)</th>
        <th class="text-center" colspan="2">Action</th>
      </tr>
    </thead>
    <?php
      include_once "db.php";
      $sql="SELECT * from plans";
      $result=$conn-> query($sql);
      $count=1;
      if ($result-> num_rows > 0){
        while ($row=$result-> fetch_assoc()) {
           
    ?>
    <tr>
      <td><?=$row["plans_id"]?></td>
      <td><?=$row["plan_name"]?></td>
      <td><?=$row["price"]?></td>
      <td><?=$row["description"]?></td>
      <td><?=$row["duration"]?></td>

       <!-- eg start -->
        <td><button class="btn btn-primary" style="height:40px" onclick="updatePlan()">Update</button></td>
          <!-- eg end -->

          
          
          
          <td><button class="btn btn-danger" style="height:40px" onclick="planDelete('<?=$row['plans_id']?>')">Delete</button></td>
        </tr>
        <?php
            $count=$count+1;
           
        }
      }
      ?>
  </table>
  
  <!-- Add New Plan Start -->
  
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-secondary" style="height:40px" data-toggle="modal" data-target="#myModal">
    Add New Plans
  </button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">New Plan Details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form  enctype='multipart/form-data' action="./controller/addNewPlanController.php" method="POST">
            <!-- 1 -->
            <div class="form-group">
              <label for="plans_id">Plan_ID:</label>
              <input type="number" class="form-control" name="plans_id" required>
            </div>
            <!-- 2 -->
            <div class="form-group">
              <label for="plan_name">Plan_Name:</label>
              <input type="text" class="form-control" name="plan_name" required>
            </div>
            <!-- 3 -->
            <div class="form-group">
              <label for="description">Plan_Description:</label>
              <input type="textarea" class="form-control" name="description" required>
            </div>

            <div class="form-group">
              <label for="duration">Plan_duration:</label>
              <input type="number" class="form-control" name="duration" required>
            </div>

            <div class="form-group">
              <label for="price">Plan_Price:</label>
              <input type="number" class="form-control" name="price" required>
            </div>
            
            <div class="form-group">
              <button type="submit" class="btn btn-secondary" name="plan_submit" style="height:40px">Add Plan</button>
            </div>
          </form>
        <!-- Add New Plan End -->
        
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

    <!-- <td><button class="btn btn-primary" style="height:40px" onclick="planUpdate('<?=$row['plans_id']?> ')">Edit</button></td> -->