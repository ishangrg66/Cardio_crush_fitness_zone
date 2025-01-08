<div>
  <h2 class="text-center">New Membership Verification</h2>
  <table class="table">
    <thead>
      <tr>
        <th class="text-center">Name</th>
        <th class="text-center">Plan Name</th>
        <th class="text-center">Start Date</th>
        <th class="text-center">End Date</th>
        <th class="text-center">Status</th>
        <th class="text-center">Payment Status</th>
        <th class="text-center">Payment Proof</th>
        <th class="text-center" colspan="2">Action</th>
      </tr>
    </thead>
    <?php
      include_once "db.php";  // Include your DB connection

      // SQL query to fetch data from memberships, plans, and users
      $sql = "
        SELECT m.membership_id, u.f_name, u.l_name, p.plan_name, m.start_date, m.end_date, m.status, m.payment_status, m.payment_proof
        FROM memberships m
        JOIN user_account u ON m.id = u.id
        JOIN plans p ON m.plans_id = p.plans_id
      "; 
      $result = $conn->query($sql);  // Execute the query

      if ($result->num_rows > 0) {
        // Loop through each row of the result
        while ($row = $result->fetch_assoc()) {
    ?>
    <tr>
      <td><?= htmlspecialchars($row["f_name"]) . " " . htmlspecialchars($row["l_name"]) ?></td>
      <td><?= htmlspecialchars($row["plan_name"]) ?></td>
      <td><?= htmlspecialchars($row["start_date"]) ?></td>
      <td><?= htmlspecialchars($row["end_date"]) ?></td>
      <td><?= htmlspecialchars($row["status"]) ?></td>
      <td><?= htmlspecialchars($row["payment_status"]) ?></td>
      <td>
        <?php if (!empty($row["payment_proof"])): ?>
          <img src="<?= htmlspecialchars($row["payment_proof"]) ?>" 
               width="200px" 
               height="200px">
        <?php else: ?>
          <p>No payment proof provided.</p>
        <?php endif; ?>
      </td>
      <td>
  <form action="controller/update_membership_status.php" method="POST">
    <input type="hidden" name="membership_id" value="<?= $row['membership_id'] ?>">

    <?php if ($row['status'] !== 'active'): ?>
      <!-- Accept Button -->
      <button class="btn btn-success" type="submit" name="update_status" value="active">Accept</button>

      <!-- Reject Button -->
      <button class="btn btn-danger" type="submit" name="update_status" value="rejected">Reject</button>
    <?php else: ?>
      <!-- Cancel Membership Button -->
      <button class="btn btn-warning" type="submit" name="cancel_membership">Cancel Membership</button>
    <?php endif; ?>
  </form>
</td>


<script>
  function confirmAction(form) {
    return confirm("Are you sure you want to update the membership status?");
  }

  function confirmCancel(form) {
    return confirm("Are you sure you want to cancel this membership?");
  }
</script>



      </td>
    </tr>
    <?php
        }
      } else {
        echo "<tr><td colspan='7' class='text-center'>No memberships found.</td></tr>";
      }
    ?>
  </table>
</div>
<!-- <script>
  document.addEventListener('DOMContentLoaded', function() {
    // Function to handle membership status update
    function updateMembershipStatus(membershipId, status) {
        fetch('verify_membership.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ membership_id: membershipId, status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);
                // Optionally refresh the page or update the UI
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Attach event listeners for Accept and Reject buttons
    document.querySelectorAll('.btn-success, .btn-danger').forEach(button => {
        button.addEventListener('click', function() {
            const membershipId = this.closest('tr').querySelector('td').innerText; // Get the membership ID from the first column
            const status = this.classList.contains('btn-success') ? 'active' : 'rejected';
            updateMembershipStatus(membershipId, status);
        });
    });
});


</script> -->