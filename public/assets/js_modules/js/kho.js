$("#dateFilterKho").datepicker({
    dateFormat: "dd-mm-yy",
});
$("#dateFilterKho").datepicker("setDate", new Date());

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
        style: "single",
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
    columns: [
        {
            data: "date",
            name: "date",
            title: "Ngày",
            render: function (data, type, row) {
                return moment(data).format("DD/MM/YYYY");
            },
        },
        {
            data: "warehouse.code",
            name: "warehouse.code",
            title: "Nơi lưu trữ",
            render: function (data, type, row) {
                return data
                    ? `<span class="fw-bold" style="color: #000a8d">${data}</span>`
                    : `<span class="text-danger">Trống</span>`;
            },
        },
        {
            // Add the custom actions (edit/delete)
            data: null,
            title: "Tùy chỉnh",
            orderable: false,
            searchable: false,
            render: function (data, type, row) {
                return `
                    <button type="button" class="editBtn editWare" data-bs-toggle="modal" data-bs-target="#modalCenter"
                        data-id="${data.id}" data-warehouseId='${data.warehouse_id}'>
                        <svg height="1em" viewBox="0 0 512 512">
                            <path
                                d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z">
                            </path>
                        </svg>
                    </button>
                `;
            },
        },
        {
            data: "company.code",
            name: "company.code",
            title: "Công ty",
        },
        {
            data: "batch_code",
            name: "batch_code",
            title: "Mã lô",
        },
        {
            data: "bale_count",
            name: "bale_count",
            title: "Số bành",
            render: function (data, type, row) {
                return data == 144
                    ? `<span class="text-dark">${data}</span>`
                    : `<span class="text-danger">${data}</span>`;
            },
        },
        {
            data: "checked",
            name: "checked",
            title: "Kiểm nghiệm",
            render: function (data, type, row) {
                return data == 0
                    ? `<span class="text-danger">Chưa</span>`
                    : `<span class="text-success">Đã kiểm nghiệm</span>`;
            },
        },
        {
            data: "exported",
            name: "exported",
            title: "Trạng thái xuất kho",
            render: function (data, type, row) {
                return data == 0
                    ? `<span class="text-danger">Chưa xuất kho</span>`
                    : `<span class="text-dark">Đã xuất kho</span>`;
            },
        },
        {
            data: "expected_grade",
            name: "expected_grade",
            title: "Hạng dự kiến",
        },
        {
            data: "sample_cut_number",
            name: "sample_cut_number",
            title: "Số mẫu cắt",
        },
        {
            data: "packaging_type",
            name: "packaging_type",
            title: "Dạng đóng gói",
        },
    ],
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
