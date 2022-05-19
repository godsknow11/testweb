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
            process: 'get_order'
        },
        dataType: "JSON"
    }).done(function(data) {
        // console.log(data.response);
        let tableData = []
        if (data.response != null) {
            data.response.forEach(function(item, index) {
                tableData.push([
                    ++index,
                    item.orderNumber,
                    item.orderDate,
                    item.requiredDate,
                    item.shippedDate,
                    item.status,
                    `<div class="btn-group" role="group">
                <button type="button" class="btn btn-info" id="order_detail" data-orid="${item.orderNumber}" data-index="${index}">
                <i class="fas fa-edit"></i> รายละเอียดออร์เดอร์
                </button>   `
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
                    title: "เลขออเดอร์",
                    className: "align-middle"
                },
                {
                    title: "วันที่สั่งซื้อ",
                    className: "align-middle"
                },
                {
                    title: "วันที่ลูกค้าต้องการ",
                    className: "align-middle"
                },
                {
                    title: "วันที่ส่ง",
                    className: "align-middle"
                },
                {
                    title: "สถานะ",
                    className: "align-middle"
                },
                {
                    title: "จัดการ",
                    className: "align-middle"
                },
            ],
            initComplete: function() {

                $(document).on('click', '#order_detail', function() {
                    let id = $(this).data('orid')

                    $.ajax({
                        type: "POST",
                        url: "<?php echo esc(base_url('ajax')); ?>",
                        data: {
                            process: 'get_order_detail',
                            id: id
                        },
                        dataType: "JSON"
                    }).done(function(data) {

                        console.log(data);
                        let orderdata = []
                        // var acc = []
                        $.each(data.response, function(index, value) {
                            orderdata.push([
                                ++index,
                                value.orderNumber,
                                value.productname,
                                value.quantityOrdered,
                                value.priceEach,
                                value.priceEach * value.quantityOrdered,
                            ])
                        });

                        let sumdata = [] // รวมราคาสินค้าทั้งหมด
                        $.each(orderdata, function(index, value) {
                            sumdata.push(value[5])
                        });

                        alert('เลขออร์เดอร์' + orderdata[0][1] + '\n' + JSON.stringify(
                                orderdata) + '\n' + 'ยอดรวมราคาสินค้า :' + sumdata
                            .reduce(function(acc, val) {
                                return Math.ceil(acc + val);
                            }, 0));

                    }).fail(function() {
                        alert('ดึงข้อมูลผิดพลาด !')
                    })

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