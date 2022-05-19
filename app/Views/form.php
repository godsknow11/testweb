<!DOCTYPE html>
<html lang="en">



<?php
if (isset($data)) {
    $fname = $data['firstName'];
    $lname = $data['lastName'];
    $email = $data['email'];
    // $fname = '';
    // $lname = '';
    // $email = '';
    $event = "update";
} else {
    $fname = '';
    $lname = '';
    $email = '';
    $event = "insert";
}



?>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css">
</head>

<body>


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- /.card -->
                <div class="card">
                    <form id="emp_from">

                        <label for="fname">First name:</label><br>
                        <input type="text" id="fname" name="fname" value="<?php echo $fname ?>"><br>
                        <label for="lname">Last name:</label><br>
                        <input type="text" id="lname" name="lname" value="<?php echo $lname ?>"><br>
                        <label for="email">Email:</label><br>
                        <input type="text" id="email" name="email" value="<?php echo $email ?>"><br>
                        <br>
                        <input type="submit" value="Submit">
                    </form>

                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>





</body>
<script>
$("#emp_from").submit(function(e) {
    e.preventDefault()

    var firstname = $('#fname').val();
    var lastname = $('#lname').val();
    var email = $('#email').val();
    var id = '<?php echo $_GET['id'] ?>';
    var event = '<?php echo $event ?>';
    if (event == "update") {
        $.ajax({
            type: "POST",
            url: "<?php echo esc(base_url('ajax')); ?>",
            data: {
                process: 'update_employeesdata',
                id: id,
                lastName: lastname,
                firstName: firstname,
                email: email,
            },
            dataType: "JSON"
        }).done(function(data) {
            console.log(data);
            if (data.status == true) {
                alert('อัพเดทข้อมูลสำเร็จ !')
                location.href = "<?php echo esc(base_url('Home/test')); ?>";

            } else {
                alert('อัพเดทข้อมูลล้มเหลว !')
            }
        }).fail(function() {
            alert('อัพเดทข้อมูลล้มเหลว !')
        })

    } else {
        $.ajax({
            type: "POST",
            url: "<?php echo esc(base_url('ajax')); ?>",
            data: {
                process: 'insert_employeesdata',
                lastName: lastname,
                firstName: firstname,
                email: email,
            },
            dataType: "JSON"
        }).done(function(data) {
            console.log(data);
            if (data.status == true) {
                alert('เพิ่มข้อมูลสำเร็จ !')
                location.href = "<?php echo esc(base_url('Home/test')); ?>";

            } else {
                alert('เพิ่มข้อมูลล้มเหลว !')
            }
        }).fail(function() {
            alert('เพิ่มข้อมูลล้มเหลว !')
        })

    }


})
</script>



</html>