<!-- This is Trainers of sidebar -->

<div >
  <h3 class="text-center">Trainers Details</h3>
  <table class="table ">
  <thead>
      <tr>
        <th>Trainer Name</th>
        <th>Email</th>
        <th>Contact</th>
        <th class="text-center" colspan="2">Action</th>
     </tr>
    </thead>
    <?php
      include_once "db.php";
      $sql="SELECT * from trainers";
      $result=$conn-> query($sql);
      $count=1;
      if ($result-> num_rows > 0){
        while ($row=$result-> fetch_assoc()) {
    ?>
       <tr>
          <td><?=$row["trainer_name"]?></td>
          <td><?=$row["image"]?></td>
          <td><?=$row["phone_number"]?></td>
          <td><button class="btn btn-primary" onclick="trainerUpdate('<?=$row['trainer_id']?> ')">Edit</button></td>
          <td><button class="btn btn-danger" style="height:40px" onclick="trainerDelete('<?=$row['trainer_id']?>')">Delete</button></td>
        </tr>
      <?php
            $count=$count+1;
          }
        }
      ?>
  </table>


        <!-- Add New Trainer Start -->

 <!-- Trigger the modal with a button -->
 <button type="button" class="btn btn-secondary" style="height:40px" data-toggle="modal" data-target="#myModal">
    Add New Trainer
  </button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">New Trainer Details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form  enctype='multipart/form-data' action="./controller/addNewTrainerController.php" method="POST">
            <!-- 1 -->
            <!-- <div class="form-group">
              <label for="trainer_id">Trainer_ID:</label>
              <input type="number" class="form-control" name="trainer_id" required>
            </div> -->
            <!-- 2 -->
            <div class="form-group">
              <label for="trainer_name">Trainer_Name:</label>
              <input type="text" class="form-control" name="trainer_name" required>
            </div>
            <!-- 3 -->
            <div class="form-group">
              <label for="email">Image:</label>
              <input type="file" class="form-control" name="image" required>
            </div>
            <!-- 4 -->
            <div class="form-group">
              <label for="contact">Phone:</label>
              <input type="number" class="form-control" name="contact" required>
            </div>
            <!-- 5 -->

            <div class="form-group">
              <label for="contact">address:</label>
              <input type="text" class="form-control" name="address" required>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-secondary" name="trainer_submit" style="height:40px">Add Trainer</button>
            </div>
          </form>
        <!-- Add New Trainer Start -->


        <!-- Update Trainer Start -->

        <!-- Add New Trainer End -->



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  
</div>
   