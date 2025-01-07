<div>
  <h2 class="text-center">New Membership Verification</h2>
  <table class="table">
    <thead>
      <tr>
        <th class="text-center">Name</th>
        <th class="text-center">Plan Name</th>
        <th class="text-center">Start Date</th>
        <th class="text-center">End Date</th>
        <th class="text-center">Payment Status</th>
        <th class="text-center">Payment Proof</th>
        <th class="text-center" colspan="2">Action</th>
      </tr>
    </thead>
    <?php
      include_once "db.php";  // Include your DB connection

      // SQL query to fetch data from memberships, plans, and users
      $sql = "
        SELECT m.membership_id, u.f_name, u.l_name, p.plan_name, m.start_date, m.end_date, m.payment_status, m.payment_proof
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
      <td><?= htmlspecialchars($row["payment_status"]) ?></td>
      <td>
        <?php if ($row["payment_proof"]): ?>
          <img src="uploads/payment_proofs/<?= htmlspecialchars($row["payment_proof"]) ?>" alt="Payment Proof" width="100px" height="100px">
        <?php else: ?>
          No payment proof uploaded
        <?php endif; ?>
      </td>
      <td>
        <button class="btn btn-success" onclick="verifyMembership(<?= $row['membership_id'] ?>, 'accept')">Accept</button>
      </td>
      <td>
        <button class="btn btn-danger" onclick="verifyMembership(<?= $row['membership_id'] ?>, 'reject')">Reject</button>
      </td>
    </tr>
    <?php
        }
      } else {
        echo "<tr><td colspan='7' class='text-center'>No new memberships found.</td></tr>";
      }
    ?>
  </table>      
</div>

<script>
  // Function to handle membership acceptance or rejection
  function verifyMembership(membership_id, action) {
    const confirmation = confirm(`Are you sure you want to ${action} this membership?`);
    if (confirmation) {
      // Make an AJAX request to update the membership status
      fetch(`verify_membership.php?membership_id=${membership_id}&action=${action}`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert(`Membership has been ${action}ed successfully.`);
            location.reload();  // Reload the page to reflect changes
          } else {
            alert('Error: Unable to process the request.');
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    }
  }
</script>
