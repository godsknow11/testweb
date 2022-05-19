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

                                <!-- <input
                                    onclick="window.location='<?php echo $link_add_product . '?shopid=' . $_GET['shopid'] ?>';"
                                    type="button" class="form-control btn-success" value="เพิ่มสินค้า"> -->


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
            process: 'getemployeesdata'
        },
        dataType: "JSON"
    }).done(function(data) {
        console.log(data);
        let tableData = []
        if (data.response != null) {

            // check statuts rider //

            data.response.forEach(function(item, index) {

                // CHECK FIRSTTIME and ADD array cancel click


                tableData.push([
                    ++index,
                    item.employeeNumber,
                    item.firstName,
                    item.lastName,
                    item.email,
                    item.jobTitle,
                    `<div class="btn-group" role="group">
					<button type="button" class="btn btn-info" id="edit_rider" data-riderid="${item.employeeNumber}" data-index="${index}">
					<i class="fas fa-edit"></i> จัดการข้อมูลพนักงาน
					</button>
					<button type="button" class="btn btn-danger" id="delete" data-id="${item.employeeNumber}" data-index="${index}">
						<i class="far fa-trash-alt"></i> ลบพนักงาน
					</button>
				</div>`
                ])

            })
            initDataTables(tableData, data.message)

        } else {
            initDataTables(tableData, data.message);
        }
        //initDataTables(tableData)
    }).fail(function() {



    })

    function initDataTables(tableData) {




        // console.log(tableData);

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



                // $(document).on('click', '#edit_rider', function() {
                //     let id = $(this).data('riderid')
                //     location.href = '<?php echo $linkedit ?>' + "?riderid=" + id;
                // })

                // $(document).on('click', '#delete', function() {
                //     let id = $(this).data('id')
                //     let index = $(this).data('index')
                //     Swal.fire({
                //         text: "คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?",
                //         icon: 'warning',
                //         showCancelButton: true,
                //         confirmButtonText: 'ใช่! ลบเลย',
                //         cancelButtonText: 'ยกเลิก'
                //     }).then((result) => {
                //         if (result.isConfirmed) {
                //             $.ajax({
                //                 type: "DELETE",
                //                 url: "../../service/manager/delete.php",
                //                 data: {
                //                     id: id
                //                 }
                //             }).done(function() {
                //                 Swal.fire({
                //                     text: 'รายการของคุณถูกลบเรียบร้อย',
                //                     icon: 'success',
                //                     confirmButtonText: 'ตกลง',
                //                 }).then((result) => {
                //                     location.reload()
                //                 })
                //             })
                //         }
                //     })
                // })
            },
            responsive: {
                details: {
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                        tableClass: 'table'
                    })
                }
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
};
</script>



</html>