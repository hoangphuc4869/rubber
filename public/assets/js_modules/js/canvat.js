$("#dateFilterCanvat").datepicker({
    dateFormat: "dd-mm-yy",
});
$("#dateFilterCanvat").datepicker("setDate", new Date());

let tableCanvat = new DataTable("#canvatTable", {
    ajax: {
        url: "/get-canvat-data",
        type: "GET",
        data: function (d) {
            d.date = $("#dateFilterCanvat").val();
            d.status = $("#statusFilterCanvat").val();
            d.area = $("#areaFilterCanvat").val();
        },
    },
    createdRow: function (row, data, dataIndex) {
        $(row).attr("id", data.id);
        $(row).attr("data-status", data.status);
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
        sUrl: "",
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
        { data: "date", name: "date" },
        { data: "code", name: "code" },
        {
            data: "status",
            name: "status",
            render: function (data, type, row) {
                if (data === 0) {
                    return row.remaining > 0
                        ? "<span class='text-warning'>Gia công 1 phần</span>"
                        : "<span class='text-danger'>Chờ gia công</span>";
                } else {
                    return "<span class='text-success'>Đã gia công</span>";
                }
            },
        },
        { data: "time", name: "time" },
        { data: "area_code", name: "curing_area_id" },
        { data: "house_code", name: "curing_house_id" },
        { data: "weight_to_roll", name: "weight_to_roll" },
        { data: "remaining", name: "remaining" },
        { data: "date_curing", name: "date_curing" },
        { data: "timeRoll", name: "timeRoll" },
    ],
    scrollX: true,
    autoWidth: false,
});

//filter date

$("#btnCanvatFilter").on("click", function () {
    tableCanvat.ajax.reload();
});

// tableCanvat.on("select", updateNguyenLieuButtons);
// tableCanvat.on("deselect", updateNguyenLieuButtons);

// function updateNguyenLieuButtons() {
//     let allRows = tableCanvat.rows().nodes();

//     let selectedRows = Array.from(allRows).filter(
//         (row) =>
//             $(row).hasClass("selected") &&
//             !$(row).hasClass("no-select") &&
//             $(row).data("status") != 1
//     );

//     let values = selectedRows.map((row) => row.id);

//     $("#selected-drums").val(values.join(","));

//     $("#rubbersDRC").val(values.join(","));

//     if (values.length > 0) {
//         $(".form-delete-items").removeClass("d-none");
//         $(".editMat").removeClass("d-none");
//         $(".editDRC").removeClass("d-none");
//     } else {
//         $(".form-delete-items").addClass("d-none");
//         $(".editMat").addClass("d-none");
//         $(".editDRC").addClass("d-none");
//     }
// }
