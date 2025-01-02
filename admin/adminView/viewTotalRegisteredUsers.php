<!-- This is view registration of sidebar -->
<!-- total no of users who register in our website -->

<div >
  <h2 class="text-center">Registered Users Details</h2>
  <table class="table ">
    <thead>
      <tr>
        <!-- <th class="text-center">User_ID</th> -->
        <th class="text-center">Full Name</th>
        <th class="text-center">Email</th>
        <th class="text-center">Phone</th>
        <th class="text-center">Birthdate</th>
        <th class="text-center" colspan="2">Action</th>
      </tr>
    </thead>
    <?php
      include_once "db.php";
      $sql="SELECT * from user_account";
      $result=$conn-> query($sql);
      $count=1;
      if ($result-> num_rows > 0){
        while ($row=$result-> fetch_assoc()) {
    ?>
    <tr>
      <td><?=$row["id"]?></td>   
      <td><?=$row["f_name"]?><?=$row["l_name"]?></td>   
      <td><?=$row["email"]?></td>   
      <td><?=$row["phone"]?></td>   
      <td><button class="btn btn-primary" onclick="totalRegisteredUsersUpdate('<?=$row['id']?> ')">Edit</button></td>
      <td><button class="btn btn-danger" style="height:40px" onclick="totalRegisteredUsersDelete('<?=$row['id']?>')">Delete</button></td>
      </tr>
      <?php
            $count=$count+1;
          }
        }
      ?>
  </table>


        <!-- Add New User Start -->

   <!-- Trigger the modal with a button -->
 <button type="button" class="btn btn-secondary" style="height:40px" data-toggle="modal" data-target="#myModal">
    Add New User
  </button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">New User Details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form  enctype='multipart/form-data' action="./controller/addNewUsersController.php" method="POST">
            <!-- 1
            <div class="form-group">
              <label for="id">User_ID:</label>
              <input type="number" class="form-control" name="user_id" required>
            </div> -->
            <!-- 2 -->
            <div class="form-group">
              <label for="f_name">First_Name:</label>
              <input type="text" class="form-control" name="f_name" required>
            </div>
             <!-- 3 -->
             <!-- <div class="form-group">
              <label for="middle_name">Middle_Name:</label>
              <input type="text" class="form-control" name="middle_name">
            </div> -->
             <!-- 4 -->
             <div class="form-group">
              <label for="l_name">Last_Name:</label>
              <input type="text" class="form-control" name="l_name" required>
            </div>
            <!-- 5 -->
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" name="email" required>
            </div>
            <!-- 6 -->
            <div class="form-group">
              <label for="contact">Phone:</label>
              <input type="number" class="form-control" name="contact" required>
            </div>
             <!-- 7 -->
             <div class="form-group">
              <label for="birthdate">Date_of_Birth:</label>
              <input type="date" class="form-control" name="date_of_birth" required>
            </div>
             <!-- 8 -->
             <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" name="password" required>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-secondary" name="user_submit" style="height:40px">Add User</button>
            </div>
          </form>

        <!-- Add New User End -->


        <!-- Update User Start -->


        <!-- Update User End -->


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  
</div>