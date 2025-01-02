
<!-- all new members of user shown here who newly apply for gym membership or subscription -->

<div >
  <h2 class="text-center">New Membership Details</h2>
  <table class="table">
    <thead>
      <tr>
        <th class="text-center">Member_ID</th>
        <th class="text-center">Member Name</th>
        <th class="text-center">Email</th>
        <th class="text-center">Phone</th>
        <th class="text-center" colspan="2">Action</th>
      </tr>
    </thead>
    <?php
      include_once "db.php";
      // have to change later
      $sql="SELECT * from new_membership"; 
      $result=$conn-> query($sql);
      $count=1;
      if ($result-> num_rows > 0){
        while ($row=$result-> fetch_assoc()) {
    ?>
    <tr>
      <td><?=$row['member_id']?></td>
      <td><?=$row["member_name"]?></td>
      <td><?=$row["email"]?></td>
      <td><?=$row["contact"]?></td>
      <td><button class="btn btn-primary" onclick="newMembershipUpdate('<?=$row['member_id']?> ')">Edit</button></td>
      <td><button class="btn btn-danger" style="height:40px" onclick="newMembershipDelete('<?=$row['member_id']?>')">Delete</button></td>
    </tr>
    <?php
            $count=$count+1;
           
        }
    }
    ?>
  </table>


        <!-- Add New Membership Start -->

   <!-- Trigger the modal with a button -->
 <button type="button" class="btn btn-secondary" style="height:40px" data-toggle="modal" data-target="#myModal">
    Add New Membership
  </button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">New Member Details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form  enctype='multipart/form-data' action="./controller/addNewMembershipController.php" method="POST">
            <!-- 1 -->
            <div class="form-group">
              <label for="member_id">Member_ID:</label>
              <input type="number" class="form-control" name="member_id" required>
            </div>
            <!-- 2 -->
            <div class="form-group">
              <label for="member_name">Member_Name:</label>
              <input type="text" class="form-control" name="member_name" required>
            </div>
            <!-- 3 -->
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" name="email" required>
            </div>
            <!-- 4 -->
            <div class="form-group">
              <label for="contact">Phone:</label>
              <input type="number" class="form-control" name="contact" required>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-secondary" name="member_submit" style="height:40px">Add New Member</button>
            </div>
          </form>
        <!-- Add New Membership End -->

        <!-- Update Membership Start -->


        <!-- Update Membership End -->


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  
</div>
   