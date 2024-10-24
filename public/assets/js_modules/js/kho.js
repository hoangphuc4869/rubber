$("#dateFilterKho").datepicker({
    dateFormat: "dd-mm-yy",
});
$("#dateFilterKho").datepicker("setDate", new Date());

var onShipmentPage = window.location.pathname.includes("shipments");

let columns = [
    {
        data: "date",
        name: "date",
        render: function (data, type, row) {
            return moment(data).format("DD/MM/YYYY");
        },
    },
    {
        data: "warehouse.code",
        name: "warehouse.code",
        render: function (data, type, row) {
            return data
                ? `<span class="fw-bold" style="color: #000a8d">${data}</span>`
                : `<span class="text-danger">Trống</span>`;
        },
    },
    !onShipmentPage
        ? {
              data: null,
              orderable: false,
              searchable: false,
              render: function (data, type, row) {
                  return `
                    <button type="button" class="editBtn editWare" data-bs-toggle="modal" data-bs-target="#modalCenter"
                        data-id="${data.id}" data-warehouseId='${data.warehouse_id}'>
                        <svg height="1em" viewBox="0 0 512 512">
                            <path d="..."></path>
                        </svg>
                    </button>
                  `;
              },
          }
        : null,
    !onShipmentPage
        ? {
              data: "company.code",
              name: "company.code",
          }
        : null,
    {
        data: "batch_code",
        name: "batch_code",
    },
    {
        data: "bale_count",
        name: "bale_count",
        render: function (data, type, row) {
            return data == 144
                ? `<span class="text-dark">${data}</span>`
                : `<span class="text-danger">${data}</span>`;
        },
    },
    {
        data: "checked",
        name: "checked",
        render: function (data, type, row) {
            return data == 0
                ? `<span class="text-danger">Chưa</span>`
                : `<span class="text-success">Đã kiểm nghiệm</span>`;
        },
    },
    {
        data: "exported",
        name: "exported",
        render: function (data, type, row) {
            return data == 0
                ? `<span class="text-danger">Chưa xuất kho</span>`
                : `<span class="text-dark">Đã xuất kho</span>`;
        },
    },
    {
        data: "expected_grade",
        name: "expected_grade",
    },
    {
        data: "sample_cut_number",
        name: "sample_cut_number",
    },
    {
        data: "packaging_type",
        name: "packaging_type",
    },
];

columns = columns.filter((col) => col !== null);

let tableKho = new DataTable("#tableKho", {
    ajax: {
        url: "/get-kho-data",
        type: "GET",
        data: function (d) {
            d.date = $("#dateFilterKho").val();
            d.checked = $("#checkedFilterKho").val();
            d.grade = $("#gradeFilterKho").val();
            d.kho = $("#FilterKho").val();
            d.company = $("#company_id").val();
        },
    },
    createdRow: function (row, data, dataIndex) {
        $(row).attr("id", data.id);
    },
    select: {
        style: "multi",
    },
    language: {
        sProcessing: "Đang xử lý...",
        sLengthMenu: "Hiển thị _MENU_ mục trên mỗi trang",
        sZeroRecords: "Không tìm thấy kết quả",
        sEmptyTable: "Không có dữ liệu trong bảng",
        sInfo: "Hiển thị từ _START_ đến _END_ của _TOTAL_ mục",
        sInfoEmpty: "Hiển thị từ 0 đến 0 của 0 mục",
        sInfoFiltered: "(lọc từ _MAX_ mục)",
        sSearch: "Tìm kiếm:",
        oPaginate: {
            sFirst: "Đầu tiên",
            sPrevious: "Trước",
            sNext: "Tiếp theo",
            sLast: "Cuối cùng",
        },
    },
    processing: true,
    serverSide: true,
    order: [[0, "desc"]],
    columns: columns,
    scrollX: true,
    autoWidth: false,
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

//filter date

$("#btnKhoFilter").on("click", function () {
    tableKho.ajax.reload();
});

// tableNguyenLieu.on("select", updateNguyenLieuButtons);
// tableNguyenLieu.on("deselect", updateNguyenLieuButtons);

$(document).ready(function () {
    var $batch = $("#batch_id"); // input hidden
    var $update = $(".updateWare");
    var $slot = $("#slot");
    var $btnClose = $(".modalWare .btn-close");

    $("#tableKho tbody").on("click", "tr", function () {
        var batchId = $(this).attr("id");
        // console.log("Row clicked, id:", batchId);

        $batch.val(batchId);

        // $('#modalCenter').modal('show');
    });

    if ($update.length) {
        $update.on("click", function () {
            const slotValue = $slot ? $slot.val() : null;
            const data = {
                batchId: $batch.val(),
                slotId: slotValue,
            };

            console.log(data);

            $.ajax({
                url: "/store-location",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                contentType: "application/json",
                data: JSON.stringify(data),
                success: function (response) {
                    $btnClose.click();
                    window.location.reload();
                },
                error: function (error) {
                    console.error("Error:", error);
                },
            });
        });
    }
});
