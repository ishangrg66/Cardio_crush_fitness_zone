<style>
  /* Plans View Section */
  .plans-view {
    padding: 20px;
    font-family: Arial, sans-serif;
  }

  .plans-view h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 1.8rem;
    color: #333;
  }

  /* Table Styles */
  .plans-table {
    width: 100%;
    border-collapse: collapse;
    margin: 0 auto;
  }

  .plans-table th,
  .plans-table td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: center;
    font-size: 1rem;
    color: #555;
  }

  /* Header Row Styling */
  .plans-table th {
    background-color: #007BFF;
    /* Blue header background */
    color: white;
    /* White text */
    font-weight: bold;
  }

  /* Alternate Row Styling */
  .plans-table tr:nth-child(even) {
    background-color: #f9f9f9;
  }

  /* Hover Effect */
  .plans-table tr:hover {
    background-color: #f1f1f1;
  }

  /* No Data Styling */
  .no-data {
    text-align: center;
    font-size: 1.1rem;
    color: #888;
  }

  /* Button Styles */
  .action-button {
    padding: 8px 15px;
    font-size: 0.9rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  /* Edit Button */
  .action-button.edit {
    background-color: #4CAF50;
    color: white;
  }

  .action-button.edit:hover {
    background-color: #45a049;
  }

  /* Delete Button */
  .action-button.delete {
    background-color: #f44336;
    color: white;
  }

  .action-button.delete:hover {
    background-color: #d32f2f;
  }
</style>
<div class="plans-view">
  <h2>All Plans</h2>
  <table class="plans-table">
    <thead>
      <tr>
        <th>Plan Name</th>
        <th>Plan Price (Rs.)</th>
        <th>Plan Description</th>
        <th>Plan Duration (Months)</th>
        <th colspan="2">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      include_once "db.php";
      $sql = "SELECT * from plans";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
      ?>
          <tr>
            <td><?= htmlspecialchars($row["plan_name"]) ?></td>
            <td><?= htmlspecialchars($row["price"]) ?></td>
            <td><?= htmlspecialchars($row["description"]) ?></td>
            <td><?= htmlspecialchars($row["duration"]) ?></td>

            <!-- Edit Button -->
            <td>
              <button class="action-button edit" onclick="populateEditForm('<?= $row['plans_id'] ?>', '<?= htmlspecialchars($row['plan_name']) ?>', '<?= htmlspecialchars($row['description']) ?>', '<?= htmlspecialchars($row['duration']) ?>', '<?= htmlspecialchars($row['price']) ?>')">
                Edit
              </button>
            </td>

            <!-- Delete Button -->
            <td>
              <button class="action-button delete" onclick="planDelete('<?= $row['plans_id'] ?>')">
                Delete
              </button>
            </td>
          </tr>
      <?php
        }
      } else {
        echo "<tr><td colspan='6' class='no-data'>No Plans Available</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>


<!-- Add New Plan Button and Modal -->
<button type="button" class="btn btn-secondary" style="height:40px" data-toggle="modal" data-target="#myModal">
  Add New Plan
</button>

<!-- Add Plan Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">New Plan Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form enctype='multipart/form-data' action="./controller/addNewPlanController.php" method="POST">
          <div class="form-group">
            <label for="plan_name">Plan Name:</label>
            <input type="text" class="form-control" name="plan_name" required>
          </div>
          <div class="form-group">
            <label for="description">Plan Description:</label>
            <input type="text" class="form-control" name="description" required>
          </div>
          <div class="form-group">
            <label for="duration">Plan Duration:</label>
            <input type="number" class="form-control" name="duration" required>
          </div>
          <div class="form-group">
            <label for="price">Plan Price:</label>
            <input type="number" class="form-control" name="price" required>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-secondary" name="plan_submit" style="height:40px">Add Plan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Plan Modal -->
<div class="modal fade" id="editPlanModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Plan</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="editPlanForm" enctype="multipart/form-data" action="./controller/updatePlan.php" method="POST">
          <!-- Hidden Input for plans_id -->
          <input type="hidden" name="plans_id" id="edit_plans_id">

          <div class="form-group">
            <label for="edit_plan_name">Plan Name:</label>
            <input type="text" class="form-control" id="edit_plan_name" name="plan_name" required>
          </div>
          <div class="form-group">
            <label for="edit_description">Plan Description:</label>
            <textarea class="form-control" id="edit_description" name="description" required></textarea>
          </div>
          <div class="form-group">
            <label for="edit_duration">Plan Duration:</label>
            <input type="number" class="form-control" id="edit_duration" name="duration" required>
          </div>
          <div class="form-group">
            <label for="edit_price">Plan Price:</label>
            <input type="number" class="form-control" id="edit_price" name="price" required>
          </div>
          <div class="form-group text-center">
            <button type="submit" class="btn btn-secondary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  // Function to populate the Edit Plan modal form
  function populateEditForm(plans_id, plan_name, description, duration, price) {
    document.getElementById('edit_plans_id').value = plans_id;
    document.getElementById('edit_plan_name').value = plan_name;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_duration').value = duration;
    document.getElementById('edit_price').value = price;

    // Show the modal
    $('#editPlanModal').modal('show');
  }

  // Form validation before submission
  document.getElementById('editPlanForm').addEventListener('submit', function(e) {
    const name = document.getElementById('edit_plan_name').value.trim();
    const price = document.getElementById('edit_price').value.trim();
    const description = document.getElementById('edit_description').value.trim();
    const duration = document.getElementById('edit_duration').value.trim();

    if (!name || !price || !description || !duration) {
      alert('All fields are required.');
      e.preventDefault();
    } else if (isNaN(price) || price <= 0) {
      alert('Price must be a valid number greater than zero.');
      e.preventDefault();
    } else if (isNaN(duration) || duration <= 0) {
      alert('Duration must be a valid number greater than zero.');
      e.preventDefault();
    }
  });
</script>
</div>