$("#dateFilterDongGoi").datepicker({
    dateFormat: "dd-mm-yy",
});
// $("#dateFilterDongGoi").datepicker("setDate", new Date());

let tableDongGoi = new DataTable("#donggoiTable", {
    ajax: {
        url: "/get-data-donggoi",
        type: "GET",
        data: function (d) {
            d.date = $("#dateFilterDongGoi").val();
            d.link = $("#linkFilterDongGoi").val();
            d.nongtruong = $("#nongtruongFilterDongGoi").val();
        },
    },
    createdRow: function (row, data, dataIndex) {
        $(row).attr("id", data.id);
    },
    select: {
        style: "multi",
    },
    paging: false,
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
    order: [[3, "asc"]],
    columns: [
        { data: "date", name: "date" },
        { data: "company", name: "company" },
        {
            data: "name",
            name: "name",
            render: function (data, type, row) {
                return `<span class='fw-bold'>${data}</span>`;
            },
        },
        { data: "end_time", name: "heated_end" },
        { data: "link", name: "link" },

        {
            data: "status",
            name: "status",
            render: function (data, type, row) {
                return "<span class='text-success'>Đã ép kiện</span>";
            },
        },

        { data: "bale_number", name: "bale_number" },
        { data: "press_temperature", name: "press_temperature" },
        { data: "weight", name: "weight" },
        { data: "cut_check", name: "cut_check" },
        { data: "evaluation", name: "evaluation" },
    ],
    scrollX: true,
    autoWidth: false,
});

//filter date

$("#btnDongGoiFilter").on("click", function () {
    tableDongGoi.ajax.reload();
});

$(document).ready(function () {
    tableDongGoi.on("click", "tr", function (e) {
        $(this).toggleClass("selected");
        updateButtonsDongGoi();
    });

    $("#selectAllBtnDG").on("click", function () {
        var rows = tableDongGoi.rows().nodes();
        var isAllSelected =
            tableDongGoi.rows({ selected: true }).count() === rows.length;

        if (isAllSelected) {
            tableDongGoi.rows().deselect();
        } else {
            tableDongGoi.rows().select();
        }

        updateButtonsDongGoi();
    });
});

function updateButtonsDongGoi() {
    let allRows = tableDongGoi.rows().nodes();

    let selectedRows = Array.from(allRows).filter(
        (row) => $(row).hasClass("selected") && !$(row).hasClass("no-select")
    );

    let values = selectedRows.map((row) => row.id);

    // console.log("Selected values: ", values);

    $("#selected-drums").val(values.join(","));
    $("#selectedCount").text("Đã chọn: " + selectedRows.length);

    if (values.length > 0) {
        $(".form-heat-items").removeClass("d-none");
    } else {
        $(".form-heat-items").addClass("d-none");
    }
}

$("#updatebale").on("click", function () {
    var baleCount = $("#bale_count").val();
    var sampleCut = $("#sample_cut").val();
    var pressingTemp = $("#pressing_temp").val();
    var evaluation = $("#evaluation").val();
    var baleId = $("#selected-drums").val();

    console.log(baleCount);

    $.ajax({
        url: "/update-bale",
        type: "PUT",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: JSON.stringify({
            ids: baleId,
            bale_count: baleCount,
            sample_cut: sampleCut,
            pressing_temp: pressingTemp,
            evaluation: evaluation,
        }),
        success: function (data) {
            var table = $("#datatable").DataTable();
            data.updated_bales.forEach(function (item) {
                var row = $(`#${item.id}`);

                if (row.length) {
                    row.find("td").eq(6).text(item.bale_count);
                    row.find("td").eq(9).text(item.sample_cut);
                    row.find("td").eq(7).text(item.pressing_temp);
                    row.find("td").eq(10).text(item.evaluation);
                } else {
                    console.warn(`Row with ID ${item.id} not found`);
                }
            });

            table.draw();
            alert("Cập nhật thành công");

            $("#exampleModal").modal("hide");
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
            alert("Đã xảy ra lỗi khi cập nhật.");
        },
    });
});

//table 2/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$("#dateFilterDongGoi2").datepicker({
    dateFormat: "dd-mm-yy",
});
// $("#dateFilterDongGoi2").datepicker("setDate", new Date());

let tableDongGoi2 = new DataTable("#donggoiTable2", {
    ajax: {
        url: "/get-data-donggoi2",
        type: "GET",
        data: function (d) {
            d.date = $("#dateFilterDongGoi2").val();
            d.link = $("#linkFilterDongGoi2").val();
            d.nongtruong = $("#nogtruongFilterDongGoi2").val();
        },
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
    order: [[5, "asc"]],
    columns: [
        { data: "date", name: "date" },
        { data: "company", name: "company" },
        {
            data: "name",
            name: "name",
            render: function (data, type, row) {
                return `<span class='fw-bold'>${data}</span>`;
            },
        },

        { data: "batch_codes", name: "batch_codes" },
        { data: "bale_counts", name: "bale_counts" },
        { data: "heated_end_time", name: "heated_end" },
        { data: "link", name: "link" },
        // { data: "type", name: "type" },
        {
            data: "status",
            name: "status",
            render: function (data, type, row) {
                return `<span class='text-success'>${data}</span>`;
            },
        },
        { data: "press_temperature", name: "press_temperature" },
        { data: "weight", name: "weight" },
        { data: "cut_check", name: "cut_check" },
        { data: "evaluation", name: "evaluation" },
    ],
    scrollX: true,
    autoWidth: false,
});

$("#btnDongGoiFilter2").on("click", function () {
    tableDongGoi2.ajax.reload();
});
