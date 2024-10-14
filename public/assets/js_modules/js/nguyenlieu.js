$("#dateFilterNguyenLieu").datepicker({
    dateFormat: "dd-mm-yy",
});
$("#dateFilterNguyenLieu").datepicker("setDate", new Date());

let tableNguyenLieu = new DataTable("#nguyenlieu", {
    ajax: {
        url: "/get-nguyenlieu-data",
        type: "GET",
        data: function (d) {
            d.date = $("#dateFilterNguyenLieu").val();
            d.status = $("#statusFilterNguyenLieu").val();
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
        { data: "time_ve_date", name: "time_ve_date" },
        { data: "time_ve_time", name: "time_ve_time" },
        {
            data: "input_status",
            name: "input_status",
            render: function (data, type, row) {
                return data === 0
                    ? "<span class='text-danger'>Chưa xác nhận</span>"
                    : "<span class='text-success'>Đã xác nhận</span>";
            },
        },
        { data: "fresh_weight", name: "fresh_weight" }, // Khối lượng mủ tươi (kg)
        { data: "truck_name", name: "truck_name" }, // Số xe
        { data: "farm_name", name: "farm_name" }, // Nguồn nguyên liệu
        { data: "area_name", name: "area_name" }, // Nơi tiếp nhận
        { data: "company_code", name: "company_code" }, // Công ty
        { data: "latex_type", name: "latex_type" }, // Chủng loại mủ
        { data: "tai_xe", name: "tai_xe" }, // Tài xế
        { data: "material_age", name: "material_age" }, // Tuổi nguyên liệu (ngày)
        { data: "drc_percentage", name: "drc_percentage" }, // DRC(%)
        { data: "dry_weight", name: "dry_weight" }, // Quy khô (kg)
        { data: "material_condition", name: "material_condition" }, // Tình trạng nguyên liệu
        { data: "impurity_type", name: "impurity_type" }, // Tạp chất
        { data: "grade", name: "grade" }, // Phân hạng nguyên liệu
        { data: "note", name: "note" }, // Ghi chú
    ],
    scrollX: true,
    autoWidth: false,
});

//filter date

$("#btnNguyenLieuFilter").on("click", function () {
    tableNguyenLieu.ajax.reload();
});

tableNguyenLieu.on("select", updateNguyenLieuButtons);
tableNguyenLieu.on("deselect", updateNguyenLieuButtons);

function updateNguyenLieuButtons() {
    let allRows = tableNguyenLieu.rows().nodes();

    let selectedRows = Array.from(allRows).filter(
        (row) => $(row).hasClass("selected") && !$(row).hasClass("no-select")
    );

    let values = selectedRows.map((row) => row.id);

    $("#selected-drums").val(values.join(","));
    $("#selected-drums2").val(values.join(","));
    $("#batchesToExport").val(values.join(","));
    $("#drumsEdit").val(values.join(","));
    $("#rubberEdit").val(values.join(","));
    $("#rubbersDRC").val(values.join(","));

    if (values.length > 0) {
        $(".form-delete-items").removeClass("d-none");
        $(".editMat").removeClass("d-none");
        $(".storeButton").removeClass("d-none");
        $(".storeButton").removeClass("d-none");
        $(".editDRC").removeClass("d-none");
    } else {
        $(".form-delete-items").addClass("d-none");
        $(".storeButton").addClass("d-none");
        $(".editMat").addClass("d-none");
        $(".editDRC").addClass("d-none");
    }
}

//DRC update

$(document).ready(function () {
    $("#btnDRC").on("click", function () {
        updateTableWithDRC();
    });

    $("#nguyenlieu tbody").on("click", "tr", function () {
        var rowId = $(this).attr("id");

        console.log(rowId);

        var editLink = "/rubber/:id/edit";
        editLink = editLink.replace(":id", rowId);
        $("#editLink").attr("href", editLink);
    });
});

function fetchDRCAndWeight(ids, drc) {
    return fetch("/update-drc", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ ids: ids, drc: drc }),
    })
        .then((response) => response.json())
        .catch((error) =>
            console.error("Error fetching DRC and Weight:", error)
        );
}

function updateTableWithDRC() {
    const selectedIds = $("#rubbersDRC").val().split(",").map(Number);

    // console.log(selectedIds);

    var drc = $("#drcInput").val();

    fetchDRCAndWeight(selectedIds, drc)
        .then((data) => {
            console.log(data.results);

            if (data.success) {
                var table = $("#tableNguyenLieu").DataTable();

                data.results.forEach((item) => {
                    const row = $(`#${item.id}`);

                    if (row.length) {
                        row.find("td").eq(11).text(item.drc.toFixed(2));
                        row.find("td").eq(12).text(item.dry_weight.toFixed(2));
                    } else {
                        console.warn(`Row with ID ${item.id} not found`);
                    }
                });

                table.draw();
                alert("Cập nhật thành công");
            } else {
                console.error("Failed to fetch DRC and weight data");
            }
        })
        .catch((error) => {
            console.error("Error fetching data:", error);
        });
}
