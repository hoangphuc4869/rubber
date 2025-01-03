$("#dateFilterList").datepicker({
    dateFormat: "dd-mm-yy",
});
// $("#dateFilterList").datepicker("setDate", new Date());

let tableBatchList = new DataTable("#tableBatchList", {
    ajax: {
        url: "/get-batch-list-data",
        type: "GET",
        data: function (d) {
            d.date = $("#dateFilterList").val();
            d.link = $("#linkFilterList").val();
            d.nongtruong = $("#nongtruongFilterList").val();
        },
    },
    createdRow: function (row, data, dataIndex) {
        $(row).attr("id", data.id);
    },
    paging: true,
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
    scrollY: "500px",
    scrollCollapse: true,
    processing: true,
    serverSide: true,
    order: [[2, "asc"]],
    columns: [
        { data: "date", name: "date" },
        { data: "from_farm", name: "from_farm" },
        {
            data: "batch_code",
            name: "batch_code",
            render: function (data, type, row) {
                return `<span class='fw-bold text-dark'>${data}</span>`;
            },
        },
        { data: "time", name: "heated_end" },
        { data: "bale_count", name: "bale_count" },
        { data: "expected_grade", name: "expected_grade" },
        { data: "sample_cut_number", name: "sample_cut_number" },
        { data: "link", name: "link" },
        {
            data: "checked",
            name: "checked",
            render: function (data, type, row) {
                if (data === 0) {
                    return "<span class='text-danger'>Chưa kiểm nghiệm</span>";
                } else if (data === 1) {
                    return "<span class='text-success'>Đã kiểm nghiệm</span>";
                } else {
                    return "<span class='text-warning'>Không đạt</span>";
                }
            },
        },
        {
            data: "exported",
            name: "exported",
            render: function (data, type, row) {
                if (data === 0) {
                    return "<span class='text-danger'>Chưa xuất kho</span>";
                } else if (data === 1) {
                    return "<span class='text-warning'>Đã xuất kho</span>";
                } else {
                    return "<span class='text-warning'>Xuất kho một phần</span>";
                }
            },
        },
    ],
    scrollX: true,
    autoWidth: false,
    select: {
        style: "multi",
    },
});

$("#btnListFilter").on("click", function () {
    tableBatchList.ajax.reload();
});

$(document).ready(function () {
    $("#selectAllBtnList").on("click", function () {
        var rows = tableBatchList.rows().nodes();
        var isAllSelected =
            tableBatchList.rows({ selected: true }).count() === rows.length;

        if (isAllSelected) {
            tableBatchList.rows().deselect();
        } else {
            tableBatchList.rows().select();
        }

        updateButtonsList();
    });

    $("#tableBatchList tbody").on("click", "tr", function () {
        $(this).toggleClass("selected");
        updateButtonsList();
    });
});

function updateButtonsList() {
    let allRows = tableBatchList.rows().nodes();

    let selectedRows = Array.from(allRows).filter(
        (row) => $(row).hasClass("selected") && !$(row).hasClass("no-select")
    );

    let values = selectedRows.map((row) => row.id);

    $("#selectedBatch").val(values.join(","));

    if (values.length > 0) {
        $("#labelBtn").removeClass("d-none");
    } else {
        $("#labelBtn").addClass("d-none");
    }
}
