<!DOCTYPE html>
<html lang="en">

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
                    <div class="col-12">
                        <div class="col-2">
                            <div style=" margin:10px 0px;">

                                <input onclick="window.location='<?php echo esc(base_url('Home/add_emp_from')); ?>';"
                                    type="button" class="form-control btn-success" value="เพิ่มพนักงาน">


                            </div>
                        </div>
                        <div class="card card-primary card-outline card-outline-tabs">

                            <div class="card-body">
                                <table id="datatable" class="table table-hover" width="100%">
                                </table>
                            </div>

                        </div>
                    </div> <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>





</body>
<script>
$(document).ready(function() {

    innitdatatable();
});

function innitdatatable() {

    $.ajax({
        type: "POST",
        url: "<?php echo esc(base_url('ajax')); ?>",
        data: {
            process: 'get_employeesdata'
        },
        dataType: "JSON"
    }).done(function(data) {
        console.log(data.response);
        let tableData = []
        if (data.response != null) {
            data.response.forEach(function(item, index) {
                tableData.push([
                    ++index,
                    item.employeeNumber,
                    item.firstName,
                    item.lastName,
                    item.email,
                    item.jobTitle,
                    `<div class="btn-group" role="group">
                <button type="button" class="btn btn-info" id="edit_emp" data-empid="${item.employeeNumber}" data-index="${index}">
                <i class="fas fa-edit"></i> จัดการข้อมูลพนักงาน
                </button>
                <button type="button" class="btn btn-danger" id="delete" data-id="${item.employeeNumber}" data-index="${index}">
                    <i class="far fa-trash-alt"></i> ลบพนักงาน
                </button>
            </div>`
                ])

            })
            initDataTables(tableData)
            //console.log(tableData);
        } else {
            initDataTables(tableData);
        }
        //initDataTables(tableData)
    }).fail(function() {


        alert('error')
    })

    function initDataTables(tableData) {




        //  console.log(tableData);

        var table = $('#datatable').DataTable({
            data: tableData,
            columns: [{
                    title: "ลำดับ",
                    className: "align-middle"
                },
                {
                    title: "เลขประจำตัว",
                    className: "align-middle"
                },
                {
                    title: "ชื่อ",
                    className: "align-middle"
                },
                {
                    title: "นามสกุล",
                    className: "align-middle"
                },
                {
                    title: "อีเมลล์",
                    className: "align-middle"
                },
                {
                    title: "ตำแหน่ง",
                    className: "align-middle"
                },
                {
                    title: "จัดการข้อมูล",
                    className: "align-middle"
                }
            ],
            initComplete: function() {



                $(document).on('click', '#edit_emp', function() {
                    let id = $(this).data('empid')
                    location.href = '<?php echo esc(base_url('Home/edit_emp_from')); ?>' + "?id=" +
                        id;
                })

                $(document).on('click', '#delete', function() {
                    let id = $(this).data('id')

                    //console.log(id);

                    //confirm("คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?");
                    if (confirm("คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?")) { // confirm check box
                        $.ajax({
                            type: "POST",
                            url: "<?php echo esc(base_url('ajax')); ?>",
                            data: {
                                process: 'delete_employeesdata',
                                id: id
                            },
                            dataType: "JSON"
                        }).done(function(data) {
                            if (data.status == true) {
                                alert('ลบข้อมูลสำเร็จ !')
                                location.reload();
                            } else {
                                alert('ลบข้อมูลล้มเหลว !')
                            }
                        }).fail(function() {
                            alert('ลบข้อมูลล้มเหลว !')
                        })
                    } else {
                        // ดัก confirm
                    }
                })
            },
            responsive: {
                // details: {
                //     renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                //         tableClass: 'table'
                //     })
                // }
            },
            language: {
                "lengthMenu": "แสดงข้อมูล _MENU_ แถว",
                "zeroRecords": "ไม่พบข้อมูลที่ต้องการ",
                "info": "แสดงหน้า _PAGE_ จาก _PAGES_",
                "infoEmpty": "ไม่พบข้อมูลที่ต้องการ",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": 'ค้นหา'
            }
        })
    }

}
</script>