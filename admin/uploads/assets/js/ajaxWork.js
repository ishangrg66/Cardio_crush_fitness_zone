function updatePlan() {
  window.location.href = "updateplan.php";
}

// Show data onclick start

// Total registration
function showTotalRegisteredUsers() {
  $.ajax({
    url: "./adminView/viewTotalRegisteredUsers.php",
    method: "post",
    data: { record: 1 },
    success: function (data) {
      $(".allContent-section").html(data);
    },
  });
}

// New membership
function showNewMembership() {
  $.ajax({
    url: "./adminView/viewNewMembership.php",
    method: "post",
    data: { record: 1 },
    success: function (data) {
      $(".allContent-section").html(data);
    },
  });
}

// Trainers
function showTrainers() {
  event.preventDefault(); // Prevent default behavior
  $.ajax({
    url: "./adminView/viewTrainers.php",
    method: "post",
    data: { record: 1 },
    success: function (data) {
      $(".allContent-section").html(data);
    },
  });
}

// Plans
function showPlans() {
  $.ajax({
    url: "./adminView/viewPlans.php",
    method: "post",
    data: { record: 1 },
    success: function (data) {
      $(".allContent-section").html(data);
    },
  });
}

// Show data onclick end

// Delete data onclick start

// Total Registered Users Delete
function totalRegisteredUsersDelete(user_id) {
  $.ajax({
    url: "./controller/totalUsersDeleteController.php",
    method: "post",
    data: { record: user_id },
    success: function (data) {
      alert("User Successfully deleted");
      $("form").trigger("reset");
      showTotalRegisteredUsers();
    },
  });
}

// New Membership Delete
function newMembershipDelete(member_id) {
  $.ajax({
    url: "./controller/newMembershipDeleteController.php",
    method: "post",
    data: { record: member_id },
    success: function (data) {
      alert("User Successfully deleted");
      $("form").trigger("reset");
      showNewMembership();
    },
  });
}

// Trainer Delete
function trainerDelete(trainer_id) {
  $.ajax({
    url: "./controller/trainerDeleteController.php",
    method: "post",
    data: { record: trainer_id },
    success: function (data) {
      alert("Trainer Successfully deleted");
      $("form").trigger("reset");
      showTrainers();
    },
  });
}

// Plan Delete
function planDelete(plans_id) {
  $.ajax({
    url: "./controller/planDeleteController.php",
    method: "post",
    data: { record: plans_id },
    success: function (data) {
      alert("Plan Successfully deleted");
      $("form").trigger("reset");
      showPlans();
    },
  });
}

// Delete data onclick end

// Update data onclick start

//Total Registered Users Update
function totalRegisteredUsersUpdate(user_id) {
  $.ajax({
    url: "./controller/totalUsersUpdateController.php",
    method: "post",
    data: { record: user_id },
    success: function (data) {
      alert("New User Successfully updated");
      $("form").trigger("reset");
      showTotalRegisteredUsers();
    },
  });
}

//update new membership
function newMembershipUpdate(member_id) {
  $.ajax({
    url: "./controller/newMembershipUpdateController.php",
    method: "post",
    data: { record: member_id },
    success: function (data) {
      alert("New Member Successfully updated");
      $("form").trigger("reset");
      showNewMembership();
    },
  });
}

//update trainer
function trainerUpdate(trainer_id) {
  $.ajax({
    url: "./controller/trainerUpdateController.php",
    method: "post",
    data: { record: trainer_id },
    success: function (data) {
      alert("trainer Successfully updated");
      $("form").trigger("reset");
      showTrainers();
    },
  });
}

//update plan
function planUpdate(plan_id) {
  $.ajax({
    url: "./controller/planUpdateController.php",
    method: "post",
    data: { record: plan_id },
    success: function (data) {
      alert("Plan Successfully updated");
      $("form").trigger("reset");
      showPlans();
    },
  });
}
// Update data onclick end
