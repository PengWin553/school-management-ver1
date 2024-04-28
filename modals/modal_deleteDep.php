<?php
    $department_id = NULL;

    if (isset($_GET['department_id'])) {
        $department_id = $_GET['department_id'];
        echo $department_id;
    }
?>

<!-- TRIALLLLLLLLLLLLLLLLLL -->
<dialog id="DeleteDepartment" class="modal">
    <div class="wrapper">
        <div class="text"> <h1> Are you sure you want to delete <?php $department_id; ?> </h1> <div>
        <form action="" style="width: 500px;" method="POST" autocomplete="off" enctype="multipart/form-data">


            <div class="button-container">
                <button type="submit" id="submit" class="okay-modal" name="submit">Submit</button>
                <button onclick="closeDeleteDepartmentModal()" type="button" class="close-modal">Close</button>
            </div>
          
        </form>
    </div>

  
</dialog>

<script>

    // show modal for patient registration
    document.addEventListener('DOMContentLoaded', (event) => {
        // Open/Close Modal + get patient data base on ID
        const delete_department = document.getElementById("DeleteDepartment");

        window.openDeleteDepartmentModal = function(id) {
            delete_department.showModal();
        }

        window.closeDeleteDepartmentModal = function() {
            delete_department.close();
        }
    });

</script>


<!-- STORE NAME AND IMAGE INSIDE DATABASE -->
<?php

// establish a connection
require_once './connection.php';


?>
