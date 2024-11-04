$("#dateFilterNhiet").datepicker({
    dateFormat: "dd-mm-yy",
});
$("#dateFilterNhiet").datepicker("setDate", new Date());

let tableNhiet = new DataTable("#giacongnhietTable", {
    ajax: {
        url: "/get-giacongnhiet-data",
        type: "GET",
        data: function (d) {
            d.date = $("#dateFilterNhiet").val();
            d.link = $("#linkFilterNhiet").val();
            d.status = $("#statusFilterNhiet").val();
        },
    },
    createdRow: function (row, data, dataIndex) {
        $(row).attr("id", data.id);
        $(row).attr("data-status", data.status);

        // Add class based on status value
        if (data.status == 2) {
            $(row).addClass("thunggiaoca");
        } else if (data.status == 3) {
            $(row).addClass("thungdoica");
        }
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
    order: [[0, "desc"]],
    columns: [
        { data: "date", name: "date" },
        {
            data: "status",
            name: "status",
            render: function (data, type, row) {
                if (data === 0) {
                    return "<span class='text-danger'>Chờ xử lý nhiệt</span>";
                } else if (data === 2) {
                    return "<span class='text-warning'>Chuyển ca</span>";
                } else if (data === 3) {
                    return "<span class='text-primary'>Đổi ca</span>";
                }
            },
        },
        { data: "name", name: "name" },
        { data: "link", name: "link" },
        { data: "house_code", name: "curing_house_id" },
        { data: "thickness", name: "thickness" },
        { data: "trang_thai_com", name: "trang_thai_com" },
        { data: "supervisor", name: "supervisor" },
    ],
    scrollX: true,
    autoWidth: false,
});

//filter date

$("#btnNhietFilter").on("click", function () {
    tableNhiet.ajax.reload();
});

$(document).ready(function () {
    var tableNhiet = $("#giacongnhietTable").DataTable();

    $("#selectAllBtn").on("click", function () {
        var rows = tableNhiet.rows().nodes();
        var isAllSelected =
            tableNhiet.rows({ selected: true }).count() === rows.length;

        if (isAllSelected) {
            tableNhiet.rows().deselect();
        } else {
            tableNhiet.rows().select();
        }

        updateButtonsNhiet();
    });

    $("#selectEvenBtn").on("click", function () {
        var selectedEven = [];
        tableNhiet.rows().every(function (rowIdx) {
            if (rowIdx % 2 === 0) {
                selectedEven.push(this.node());
            }
        });

        if (selectedEven.every((row) => tableNhiet.row(row).selected())) {
            tableNhiet.rows(selectedEven).deselect();
        } else {
            tableNhiet.rows(selectedEven).select();
        }

        updateButtonsNhiet();
    });

    $("#selectOddBtn").on("click", function () {
        var selectedOdd = [];
        tableNhiet.rows().every(function (rowIdx) {
            if (rowIdx % 2 !== 0) {
                selectedOdd.push(this.node());
            }
        });

        if (selectedOdd.every((row) => tableNhiet.row(row).selected())) {
            tableNhiet.rows(selectedOdd).deselect();
        } else {
            tableNhiet.rows(selectedOdd).select();
        }

        updateButtonsNhiet();
    });

    $("#giacongnhietTable tbody").on("click", "tr", function () {
        $(this).toggleClass("selected");
        updateButtonsNhiet();
    });
});

function updateButtonsNhiet() {
    let allRows = tableNhiet.rows().nodes();

    let selectedRows = Array.from(allRows).filter(
        (row) => $(row).hasClass("selected") && !$(row).hasClass("no-select")
    );

    console.log(selectedRows.length);

    let values = selectedRows.map((row) => row.id);

    $("#selected-drums").val(values.join(","));
    $("#drumIdsNhanCa").val(values.join(","));

    $("#selectedCount").text("Đã chọn: " + selectedRows.length);

    if (values.length > 0) {
        $(".form-heat-items").removeClass("d-none");
    } else {
        $(".form-heat-items").addClass("d-none");
    }
}

//table 2/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$("#dateFilterNhiet2").datepicker({
    dateFormat: "dd-mm-yy",
});
// $("#dateFilterNhiet2").datepicker("setDate", new Date());

let tableNhiet2 = new DataTable("#giacongnhietTable2", {
    ajax: {
        url: "/get-giacongnhiet2-data",
        type: "GET",
        data: function (d) {
            d.date = $("#dateFilterNhiet2").val();
            d.link = $("#linkFilterNhiet2").val();
        },
    },
    createdRow: function (row, data, dataIndex) {
        $(row).attr("id", data.id);
        $(row).attr("data-status", data.status);
        $(row).attr("data-dry", data.time_to_dry);
        $(row).attr("data-date", data.heated_date);
        $(row).attr("data-start", data.heated_start);
        $(row).attr("data-link", data.link);
        $(row).attr("data-oven", data.oven);
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
    order: [[5, "asc"]],
    columns: [
        { data: "date", name: "date" },
        {
            data: "status",
            name: "status",
            render: function (data, type, row) {
                if (data === 1) {
                    return "<span class='text-success'>Đang xử lý nhiệt</span>";
                }
            },
        },
        { data: "name", name: "name" },
        { data: "heated_start", name: "heated_start" },
        { data: "time_to_dry", name: "time_to_dry" },
        { data: "end_time", name: "heated_end" },
        { data: "heated_date", name: "heated_date" },
        { data: "note", name: "note" },
        { data: "temp", name: "temp" },
        { data: "temp2", name: "temp2" },
        { data: "oven", name: "oven" },
        { data: "link", name: "link" },
        { data: "validation", name: "validation" },
        { data: "state", name: "state" },
        { data: "supervisor", name: "supervisor" },
    ],
    scrollX: true,
    autoWidth: false,
});

$("#btnNhietFilter2").on("click", function () {
    tableNhiet2.ajax.reload();
});

$("#linkFilterNhiet2").on("change", function () {
    $("#doneLink").val($("#linkFilterNhiet2").val());
});

$(document).ready(function () {
    var tableNhiet2 = $("#giacongnhietTable2").DataTable();

    $("#doneLink").val($("#linkFilterNhiet2").val());

    $("#selectAllBtn2").on("click", function () {
        var rows = tableNhiet2.rows().nodes();
        var isAllSelected =
            tableNhiet2.rows({ selected: true }).count() === rows.length;

        if (isAllSelected) {
            tableNhiet2.rows().deselect();
        } else {
            tableNhiet2.rows().select();
        }

        updateButtonsNhiet2();
    });

    $("#giacongnhietTable2 tbody").on("click", "tr", function () {
        $(this).toggleClass("selected");
        updateButtonsNhiet2();
    });
});

function updateButtonsNhiet2() {
    let allRows = tableNhiet2.rows().nodes();

    let selectedRows = Array.from(allRows).filter(
        (row) => $(row).hasClass("selected") && !$(row).hasClass("no-select")
    );

    console.log(selectedRows.length);

    let values = selectedRows.map((row) => row.id);

    $("#selected-drums2").val(values.join(","));

    $("#selectedCount2").text("Đã chọn: " + selectedRows.length);

    if (values.length > 0) {
        $(".form-delete-items2").removeClass("d-none");
    } else {
        $(".form-delete-items2").addClass("d-none");
    }
}

//giao ca

$(document).ready(function () {
    var selectedDrums = [];

    $(".switch_within_day").on("click", function () {
        // Lấy số thùng người dùng muốn giao
        var numDrums = parseInt($("#numberOfDrums").val(), 10);
        if (isNaN(numDrums) || numDrums <= 0) {
            alert("Vui lòng nhập số thùng hợp lệ.");
            return;
        }

        var lineFilter = $("#linkFilterNhiet2").val();
        var totalRows = tableNhiet2.data().length;

        var buttonId = $(this).attr("id");
        $("#typeInput").val(buttonId);

        var oven1Data = [];
        var oven2Data = [];
        var oven3Data = [];

        for (var i = 0; i < totalRows; i++) {
            var row = tableNhiet2.row(i).node();
            var drumId = parseInt($(row).attr("id"), 10);
            var dataOven = $(row).data("oven");
            var dataLink = $(row).data("link");

            if (dataOven == 1 && dataLink == 6) {
                oven1Data.push({ row: row, id: drumId });
            } else if (dataOven == 2 && dataLink == 6) {
                oven2Data.push({ row: row, id: drumId });
            } else if (dataOven == 3 && dataLink == 3) {
                oven3Data.push({ row: row, id: drumId });
            }
        }

        if (lineFilter == 3) {
            var rowsData = oven3Data;

            if (rowsData.length < numDrums) {
                alert(
                    `Không đủ thùng: Chỉ có ${rowsData.length} thùng, cần đủ ${numDrums} thùng.`
                );
            } else {
                rowsData.sort(function (a, b) {
                    return b.id - a.id;
                });
                rowsData = rowsData.slice(0, numDrums);

                selectedDrums = [];
                rowsData.forEach(function (data) {
                    $(data.row).addClass("selected");
                    selectedDrums.push(data.id);
                });

                $("#drumsInput").val(selectedDrums.join(","));
                $(".so-thung-giao-ca").text(selectedDrums.length);
                $("#confirmModal").modal("show");
            }
        } else {
            if (oven1Data.length < numDrums || oven2Data.length < numDrums) {
                var missingOven1 = Math.max(numDrums - oven1Data.length, 0);
                var missingOven2 = Math.max(numDrums - oven2Data.length, 0);
                alert(
                    `Không đủ thùng: Thiếu ${missingOven1} thùng từ lò 1, và ${missingOven2} thùng từ lò 2.`
                );
            } else {
                oven1Data.sort(function (a, b) {
                    return b.id - a.id;
                });
                oven2Data.sort(function (a, b) {
                    return b.id - a.id;
                });

                var selectedOven1 = oven1Data.slice(0, numDrums);
                var selectedOven2 = oven2Data.slice(0, numDrums);

                selectedDrums = [];

                selectedOven1.forEach(function (data) {
                    $(data.row).addClass("selected");
                    selectedDrums.push(data.id);
                });

                selectedOven2.forEach(function (data) {
                    $(data.row).addClass("selected");
                    selectedDrums.push(data.id);
                });

                $("#drumsInput").val(selectedDrums.join(","));
                $(".so-thung-giao-ca").text(selectedDrums.length);
                $("#confirmModal").modal("show");
            }
        }
    });

    $(".close-modal").on("click", function () {
        $("#confirmModal").modal("hide");
        selectedDrums = [];
        $("#drumsInput").val("");
    });
});

$(document).ready(function () {
    $("#ncaBtn").on("click", function () {
        $("#nhanCaModal").modal("show");
    });

    $(".closenhanca").on("click", function () {
        $("#nhanCaModal").modal("hide");
    });
});

$(document).ready(function () {
    var initialStartTime = "";

    $('select[name="oven"]').on("change", function () {
        var selectedOven = $(this).val();

        var rows = tableNhiet2.rows().nodes();
        var filteredRows = [];
        $(rows).each(function () {
            var rowOven = $(this).data("oven");
            var rowStatus = $(this).data("status");

            if (rowOven == selectedOven && rowStatus == 1) {
                filteredRows.push(this);
            }
        });

        if (filteredRows.length > 0) {
            var lastRow = filteredRows[filteredRows.length - 1];
            var startTime = $(lastRow).find("td:eq(3)").text();

            var extraMinutes = parseInt($(lastRow).find("td:eq(4)").text());

            initialStartTime = startTime;

            var startTimeParts = startTime.split(":");
            var startHour = parseInt(startTimeParts[0]);
            var startMinutes = parseInt(startTimeParts[1]);
            var totalStartMinutes = startHour * 60 + startMinutes;

            var endTotalMinutes = totalStartMinutes + extraMinutes;

            var endHour = Math.floor(endTotalMinutes / 60);
            var endMinutes = endTotalMinutes % 60;

            var formattedEndHour = endHour.toString().padStart(2, "0");
            var formattedEndMinutes = endMinutes.toString().padStart(2, "0");

            $("#timeInput").val(`${formattedEndHour}:${formattedEndMinutes}`);
        } else {
            const now = new Date();
            let hours = now.getHours();
            let minutes = now.getMinutes();

            hours = String(hours).padStart(2, "0");
            minutes = String(minutes).padStart(2, "0");

            const currentTime = `${hours}:${minutes}`;
            $("#timeInput").val(currentTime);
            initialStartTime = currentTime;
        }
    });
});
