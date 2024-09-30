function confirmDelete() {
    return confirm("Bạn có chắc chắn muốn xóa không?");
}

function confirmExport() {
    return confirm("Xác nhận xuất các lô hàng đã chọn");
}

let classList = new DataTable("#datalist", {
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
    fixedColumns: {
        start: 2,
        end: 1,
    },
    scrollX: true,
    autoWidth: false,
});
//table-section

//date-filter

$("#min").datepicker({
    dateFormat: "dd/mm/yy",
    onSelect: function () {
        table.draw();
        classList.draw();
    },
});

var currentDate = new Date();
currentDate.setHours(currentDate.getHours() - 6);
currentDate.setMinutes(currentDate.getMinutes() - 30);

$("#min").datepicker("setDate", currentDate);

$("#min").on("change", function () {
    table.draw();
    classList.draw();
});

// $("#min").datepicker("setDate", new Date());

$("#lineFilter").on("change", function () {
    $("#link").val($("#lineFilter").val());
    table.draw();
});

$("#comFilter").on("change", function () {
    $("#company").val($("#comFilter").val());
    table.draw();
});

$(document).ready(function () {
    $("#lineFilter").val("3");

    table.draw();
});

$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    if (
        settings.nTable.id !== "datatable" &&
        settings.nTable.id !== "datalist"
    ) {
        return true;
    }
    let filterDateStr = $("#min").val();
    let filterDate = filterDateStr
        ? new Date(convertDate(filterDateStr))
        : null;
    let rowDateStr = data[1];
    let rowDate = rowDateStr ? new Date(convertDate(rowDateStr)) : null;

    let lineFilter = $("#lineFilter").val();
    let rowLine = data[6];

    let com = $("#comFilter").val();
    let rowCom = data[2];

    function convertDate(dateStr) {
        let parts = dateStr.split("/");
        return `${parts[2]}-${parts[1]}-${parts[0]}`;
    }

    if (filterDate && rowDate.toDateString() !== filterDate.toDateString()) {
        return false;
    }

    if (lineFilter && rowLine !== lineFilter) {
        return false;
    }

    if (com && rowCom !== com) {
        return false;
    }

    return true;
});

//end-date-filter

//table-settings
let table = new DataTable("#datatable", {
    fixedHeader: true,
    paging: false,
    columnDefs: [
        {
            orderable: false,
            render: DataTable.render.select(),
            targets: 0,
        },
    ],
    // fixedColumns: {
    //     start: 2,
    //     end: 1,
    // },
    scrollCollapse: true,
    scrollY: "80vh",
    order: [[1, "asc"]],
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
    select: {
        style: "multi",
    },
    scrollX: true,
    scrollX: true,
    autoWidth: false,
    rowCallback: function (row, data, index) {
        if ($(row).hasClass("no-select")) {
            $(row).addClass("disable-select");
            $(row).off("click");
        }
    },
});

$("#datatable").on("click", "tr.no-select", function (e) {
    e.stopImmediatePropagation();
});

table.on("select", updateButtons);
table.on("deselect", updateButtons);

$("#select-all").on("change", function () {
    let checked = $(this).prop("checked");
    let rows = table.rows({ search: "applied" }).nodes();

    let selectableRows = $(rows).filter(function () {
        return !$(this).hasClass("no-select");
    });

    if (checked) {
        selectableRows.each(function () {
            if (!$(this).hasClass("selected")) {
                table.row(this).select();
            }
        });
    } else {
        selectableRows.each(function () {
            if ($(this).hasClass("selected")) {
                table.row(this).deselect();
            }
        });
    }

    updateButtons();
});

function updateButtons() {
    let allRows = table.rows().nodes();

    let selectedRows = Array.from(allRows).filter(
        (row) => $(row).hasClass("selected") && !$(row).hasClass("no-select")
    );

    let values = selectedRows.map((row) => row.id);

    $("#selected-drums").val(values.join(","));
    $("#selected-drums2").val(values.join(","));
    $("#batchesToExport").val(values.join(","));

    if (values.length > 0) {
        $(".form-delete-items").removeClass("d-none");
        $(".editMat").removeClass("d-none");
        $(".storeButton").removeClass("d-none");
    } else {
        $(".form-delete-items").addClass("d-none");
        $(".storeButton").addClass("d-none");
        $(".editMat").addClass("d-none");
    }
}

$("#datatable tbody").on("click", "tr", function () {
    $(this).toggleClass("selected");
    updateButtons();
});

//end-table-settings

$(document).ready(function () {
    $(".custom-select").select2();
});

$(document).ready(function () {
    $(".custom-select-ware").select2({
        dropdownParent: $("#wareModal"),
    });
});

$(document).ready(function () {
    $(".custom-select2").select2();
});

$("#truck_id").on("change", function () {
    var selectedOption = $(this).find("option:selected");
    var farmId = selectedOption.data("farm");
    var farmCode = selectedOption.data("fcode");

    $("#name_ui").val(farmCode);
    $("#farm_id").val(farmId);
});

const today = new Date();

const dd = String(today.getDate()).padStart(2, "0");
const mm = String(today.getMonth() + 1).padStart(2, "0");
const yyyy = today.getFullYear();
const todayFormatted = yyyy + "-" + mm + "-" + dd;

const dateInput = document.getElementById("dateInput");
if (dateInput) {
    dateInput.value = todayFormatted;
}

const timeInput = document.getElementById("timeInput");

const now = new Date();
let hours = now.getHours();
let minutes = now.getMinutes();

hours = String(hours).padStart(2, "0");
minutes = String(minutes).padStart(2, "0");

const currentTime = `${hours}:${minutes}`;

if (timeInput) {
    timeInput.value = currentTime;
}

document.addEventListener("DOMContentLoaded", function () {
    const warehouseItems = document.querySelector("#warehouse_id");
    const idToSend = document.querySelector("#id_to_send");
    const close = document.querySelector(".close");
    const stocks = document.querySelectorAll(".stock-wrap .grid-item");

    if (warehouseItems) {
        warehouseItems.addEventListener("click", function () {
            document.querySelector(".stock-wrap").classList.add("active");
        });
    }

    if (close) {
        close.addEventListener("click", function () {
            document.querySelector(".stock-wrap").classList.remove("active");
        });
    }

    if (stocks) {
        stocks.forEach((stock) => {
            stock.addEventListener("click", (event) => {
                if (stock.classList.contains("occupied")) {
                    event.preventDefault();
                    alert(this.getAttribute("data-message"));
                } else {
                    close.click();
                    warehouseItems.value = stock.dataset.code;
                    idToSend.value = stock.id;
                }
            });
        });
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const items = document.querySelectorAll(".wares-stock .grid-item");

    items.forEach((item) => {
        item.addEventListener("dragstart", handleDragStart);
        item.addEventListener("dragover", handleDragOver);
        item.addEventListener("drop", handleDrop);
        item.addEventListener("dragend", handleDragEnd);
    });

    function handleDragStart(event) {
        event.dataTransfer.setData("text/plain", event.target.id);
        event.target.classList.add("dragging");
    }

    function handleDragOver(event) {
        event.preventDefault();
        const targetItem = event.target.closest(".wares-stock .grid-item");

        if (targetItem && targetItem.classList.contains("occupied")) {
            event.dataTransfer.dropEffect = "none";
            event.target.classList.add("drag-over");
            event.target.style.cursor = "not-allowed";

            event.dataTransfer.dropEffect = "move";
            event.target.classList.remove("drag-over");
            event.target.style.cursor = "copy";
        }
    }

    function handleDrop(event) {
        const id = event.dataTransfer.getData("text/plain");
        const draggedItem = document.getElementById(id);
        const targetItem = event.target.closest(".grid-item");

        // console.log("targetItem: ", targetItem);
        if (targetItem && draggedItem !== targetItem) {
            if (targetItem.classList.contains("occupied")) {
                alert("Kho đã có dữ liệu!");
                return;
            }

            const draggedItemId = draggedItem.id;
            const targetItemId = targetItem.id;

            const draggedItemName = draggedItem.dataset.code;
            const targetName = targetItem.dataset.code;

            result = sendData(
                draggedItemId,
                targetItemId,
                draggedItemName,
                targetName
            );

            if (result !== false) {
                if (draggedItem && draggedItem.classList.contains("occupied")) {
                    targetItem.classList.add("occupied");
                }

                const draggedDataContent =
                    draggedItem.querySelector(".data-content").innerHTML;
                const targetDataContent =
                    targetItem.querySelector(".data-content");

                targetDataContent.innerHTML = draggedDataContent;
                draggedItem.querySelector(".data-content").innerHTML = "";

                draggedItem.classList.remove("occupied");
            }
        }

        event.target.classList.remove("drag-over");
    }

    function handleDragEnd(event) {
        document.querySelectorAll(".grid-item").forEach((item) => {
            item.classList.remove("dragging");
            item.classList.remove("drag-over");
            item.style.cursor = "";
        });
    }

    function sendData(draggedItemId, targetItemId, dragName, targetName) {
        const data = {
            draggedItemId: +draggedItemId,
            targetItemId: +targetItemId,
        };

        if (
            confirm(
                `Xác nhận duy chuyển từ kho ${dragName} tới ${targetName}`
            ) == true
        ) {
            fetch("/change-location", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify(data),
            })
                .then((response) => response.json())
                .then((data) => {
                    // window.location.reload();
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        } else {
            return false;
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {
    var occupiedItems = document.querySelectorAll(
        ".stock-wrap .grid-item.occupied"
    );

    if (occupiedItems) {
        occupiedItems.forEach(function (item) {
            item.addEventListener("click", function (event) {
                event.preventDefault();
                alert(this.getAttribute("data-message"));
            });
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    var edits = document.querySelectorAll(".editWare");
    var batch = document.querySelector("#batch_id");
    var update = document.querySelector(".updateWare");
    var slot = document.querySelector("#slot");
    var btnclose = document.querySelector(".modalWare .btn-close");

    if (edits) {
        edits.forEach(function (item) {
            item.addEventListener("click", () => {
                batch.value = item.dataset.id;
            });
        });
    }

    if (update) {
        update.addEventListener("click", () => {
            const slotValue = slot ? slot.value : null;
            const data = {
                batchId: batch.value,
                slotId: slotValue,
            };

            // console.log(data);

            fetch("/store-location", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify(data),
            })
                .then((response) => response.json())
                .then((data) => {
                    btnclose.click();
                    window.location.reload();
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        });
    }
});

$(document).ready(function () {
    $("#curing_house").on("change", function () {
        var selectedHouse = $(this).find("option:selected").text();

        var firstMatchingOption = null;

        $("select[name='rolling_code'] option").each(function () {
            var optionHouse = $(this).data("house");

            if (optionHouse === selectedHouse) {
                $(this).show();

                if (!firstMatchingOption) {
                    firstMatchingOption = $(this);
                }
            } else {
                $(this).hide();
            }
        });

        if (firstMatchingOption) {
            firstMatchingOption.prop("selected", true);
        } else {
            $("select[name='rolling_code']").val("");
        }
    });
});

function isSubset(string1, string2) {
    let array1 = string1.split("");
    let array2 = string2.split("");

    return array2.every((char) => array1.includes(char));
}

$(document).ready(function () {
    $("#areaSelect").on("change", function () {
        var containingValue = $(this).find(":selected").data("containing");
        $("#weight_to_roll").val(containingValue);

        var selectedFarm = $("#areaSelect option:selected").text();

        $("#receivingPlaceSelect option").each(function () {
            var receivingPlace = $(this).text();

            console.log(isSubset(receivingPlace, selectedFarm));

            if (isSubset(receivingPlace, selectedFarm)) {
                $("#receivingPlaceSelect").val($(this).val()).trigger("change");
                return false;
            }
        });
    });
});

$(document).ready(function () {
    let counter = 0;
    $(".add-more").click(function () {
        let newDeliveryDate = `
            <div class="delivery_dates mb-3 row" id="delivery_dates_${counter}">
                <div class="mb-3 fw-bold">Xuất hàng đi </div>
                <div class="mb-3 col-lg-6">
                    <label class="form-label">Loại hàng</label>
                    <input type="text" name="delivery_date[${counter}][type]" class="form-control" required value="CSR10">
                </div>

                <div class="mb-3 col-lg-6">
                    <label class="form-label">Khối lượng (tấn)</label>
                    <input type="number" name="delivery_date[${counter}][amount]" class="form-control" required value="123">
                </div>
                <div class="d-flex justify-content-end align-items-center">
                    <button type="button" class="btn btn-danger btn-sm remove-date">Xóa</button>
                </div>
            </div>
        `;

        $(".delivery_dates_container").append(newDeliveryDate);

        counter++;
    });

    $(document).on("click", ".remove-date", function () {
        $(this).closest(".delivery_dates").remove();
        counter--;
    });
});

$(document).on("click", ".remove-date", function () {
    $(this).closest(".delivery_date").remove();
});

$(document).ready(function () {
    $("#curing_house").on("change", function () {
        var selectedOption = $(this).find("option:selected");

        var containingValue = selectedOption.data("containing");

        $("#weight_to_roll").val(containingValue);
    });
});

// table2

let table2 = new DataTable("#datatable2", {
    fixedHeader: true,
    paging: false,
    // fixedColumns: {
    //     end: 1,
    // },
    scrollCollapse: true,
    scrollY: "100vh",
    columnDefs: [
        {
            orderable: false,
            render: DataTable.render.select(),
            targets: 0,
        },
    ],
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
    select: {
        style: "multi",
    },
    scrollX: true,
    autoWidth: false,
    rowCallback: function (row, data, index) {
        if ($(row).hasClass("no-select")) {
            $(row).addClass("disable-select");
            $(row).off("click");
        }
    },
});

$("#datatable2").on("click", "tr.no-select", function (e) {
    e.stopImmediatePropagation();
});

//end-table-settings

function updateButtons2() {
    let allRows = table2.rows().nodes();

    let selectedRows = Array.from(allRows).filter(
        (row) => $(row).hasClass("selected") && !$(row).hasClass("no-select")
    );

    let values = selectedRows.map((row) => row.id);

    $("#selected-drums").val(values.join(","));
    $("#selected-drums2").val(values.join(","));

    if (values.length > 0) {
        $(".form-delete-items2").removeClass("d-none");
    } else {
        $(".form-delete-items2").addClass("d-none");
    }
}

table2.on("select", updateButtons2);
table2.on("deselect", updateButtons2);

$("#select-all2").on("change", function () {
    let checked = $(this).prop("checked");
    let rows = table2.rows({ search: "applied" }).nodes();

    let selectableRows = $(rows).filter(function () {
        return !$(this).hasClass("no-select");
    });

    if (checked) {
        selectableRows.each(function () {
            if (!$(this).hasClass("selected")) {
                table2.row(this).select();
            }
        });
    } else {
        selectableRows.each(function () {
            if ($(this).hasClass("selected")) {
                table2.row(this).deselect();
            }
        });
    }

    updateButtons2();
});

$("#datatable2 tbody").on("click", "tr", function () {
    $(this).toggleClass("selected");
    updateButtons2();
});

$(document).ready(function () {
    $(".area-item.containing.mac").on("click", function () {
        let code = $(this).find(".code").text().trim();

        let select = $("#curing_house");

        select
            .val(
                select
                    .find("option")
                    .filter(function () {
                        return $(this).text().trim() === code;
                    })
                    .val()
            )
            .trigger("change");
    });
});

$(document).ready(function () {
    $(".area-item.containing.rol").on("click", function () {
        let code = $(this).find(".code").text().trim();
        let select = $("#areaSelect");

        select
            .val(
                select
                    .find("option")
                    .filter(function () {
                        return $(this).text().trim() === code;
                    })
                    .val()
            )
            .trigger("change");
    });
});

let order = new DataTable("#dataOrder", {
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
    fixedColumns: {
        start: 1,
        end: 1,
    },
    scrollX: true,
    autoWidth: false,
});

// giao ca
$(document).ready(function () {
    var table = $("#datatable2").DataTable();
    var selectedDrums = [];

    $(".switch_within_day").on("click", function () {
        var lineFilter = $("#lineFilter").val();
        var totalRows = table.data().length;

        var buttonId = $(this).attr("id");
        $("#typeInput").val(buttonId);

        var rowsToSelect = lineFilter == 3 ? 30 : 32;

        if (totalRows < rowsToSelect) {
            alert("Không đủ thùng");
        } else {
            var rowsData = [];

            for (var i = 0; i < totalRows; i++) {
                var row = table.row(i).node();
                var drumId = parseInt($(row).attr("id"), 10);
                rowsData.push({ row: row, id: drumId });
            }

            rowsData.sort(function (a, b) {
                return b.id - a.id;
            });

            selectedDrums = [];

            for (var i = 0; i < Math.min(rowsToSelect, rowsData.length); i++) {
                var selectedRow = rowsData[i].row;
                $(selectedRow).addClass("selected");
                selectedDrums.push(rowsData[i].id);
            }

            $("#drumsInput").val(selectedDrums.join(","));
            $(".so-thung-giao-ca").text(selectedDrums.length);
            $("#confirmModal").modal("show");
        }
    });

    $(".close-modal").on("click", function () {
        $("#confirmModal").modal("hide");
        table.$("tr.selected").removeClass("selected");
        selectedDrums = [];
        $("#drumsInput").val("");
    });
});

// đổi ca

$(document).ready(function () {
    var table = $("#datatable2").DataTable();
    var selectedDrums = [];

    $(".switch_another_day").on("click", function () {
        var lineFilter = $("#lineFilter").val();
        var totalRows = table.data().length;

        var buttonId = $(this).attr("id");
        $("#typeInput").val(buttonId);

        var rowsToSelect = lineFilter == 3 ? 27 : 28;

        if (totalRows < rowsToSelect) {
            alert("Không đủ thùng");
        } else {
            var rowsData = [];

            for (var i = 0; i < totalRows; i++) {
                var row = table.row(i).node();
                var drumId = parseInt($(row).attr("id"), 10);
                rowsData.push({ row: row, id: drumId });
            }

            rowsData.sort(function (a, b) {
                return b.id - a.id;
            });

            selectedDrums = [];

            for (var i = 0; i < Math.min(rowsToSelect, rowsData.length); i++) {
                var selectedRow = rowsData[i].row;
                $(selectedRow).addClass("selected");
                selectedDrums.push(rowsData[i].id);
            }

            $("#drumsInput").val(selectedDrums.join(","));
            $(".so-thung-giao-ca").text(selectedDrums.length);
            $("#confirmModal").modal("show");
        }
    });

    $(".close-modal").on("click", function () {
        $("#confirmModal").modal("hide");
        table.$("tr.selected").removeClass("selected");
        selectedDrums = [];
        $("#drumsInput").val("");
    });
});

// nhan doi ca

$(document).ready(function () {
    var table = $("#datatable").DataTable();

    var hasThungGiaoCa = table.rows(".thungdoica").count() > 0;

    if (hasThungGiaoCa) {
        $("#doiCaBtn").show();
    }

    $("#doiCaBtn").on("click", function () {
        var selectedDrumIds = [];

        table.rows(".thungdoica").every(function (rowIdx, tableLoop, rowLoop) {
            var row = this.node();
            $(row).addClass("selected");
            var drumId = $(row).attr("id");
            selectedDrumIds.push(drumId);
        });

        if (selectedDrumIds.length === 0) {
            alert("Không có thùng nào được chọn để đổi ca.");
            return;
        }

        $("#drumIdsDoiCa").val(selectedDrumIds.join(","));

        $("#doiCaModal").modal("show");
    });

    $("#gioDoiCa").on("change", function () {
        var gioDoiCa = $(this).val();
        var gio = parseInt(gioDoiCa.split(":")[0]);
        var phut = parseInt(gioDoiCa.split(":")[1]);

        if (gio < 6 || (gio === 6 && phut < 30)) {
            alert("Giờ đổi ca phải lớn hơn 6h30 sáng.");
            $(this).val("");
        }
    });

    $(".close, .closedoica").on("click", function () {
        $("#doiCaModal").modal("hide");
        $("#drumIdsDoiCa").val("");
        table.rows(".thungdoica").every(function () {
            $(this.node()).removeClass("selected");
        });
    });
});

$(document).ready(function () {
    $(".form-machine").hide();

    $(".addBtn").on("click", function () {
        $(".form-machine").slideToggle();
    });
});

$(document).ready(function () {
    var table = $("#datatable").DataTable();
    $("#datatable tbody").on("click", ".editBaleBtn", function (e) {
        e.stopPropagation();

        console.log("Button clicked!");
        var baleId = $(this).data("id");

        var row = $(this).closest("tr");

        $("#baleId").val(baleId);

        $("#bale_count").val(row.find("td").eq(8).text()); // Số bành (thay đổi chỉ số nếu cần)
        $("#sample_cut").val(row.find("td").eq(12).text()); // Số mẫu cắt
        $("#pressing_temp").val(row.find("td").eq(10).text()); // Nhiệt độ ép
        $("#evaluation").val(row.find("td").eq(13).text()); // Đánh giá

        $("#editModal").modal("show");
    });

    $(".btn-close").on("click", function () {
        $("#editModal").modal("hide");
    });
});

//nhận ca

$(document).ready(function () {
    var table = $("#datatable").DataTable();

    var hasThungGiaoCa = table.rows(".thunggiaoca").count() > 0;

    if (hasThungGiaoCa) {
        $("#nhanCaBtn").show();
    }

    $("#nhanCaBtn").on("click", function () {
        var selectedDrumIds = [];

        table.rows(".thunggiaoca").every(function (rowIdx) {
            var row = this.node();
            $(row).addClass("selected");
            var drumId = $(row).attr("id");
            selectedDrumIds.push(drumId);
        });

        if (selectedDrumIds.length === 0) {
            alert("Không có thùng nào được chọn để nhận bàn giao ca.");
            return;
        }

        $("#drumIds").val(selectedDrumIds.join(","));

        $("#quantityDisplay").text(
            "Số lượng thùng nhận: " + selectedDrumIds.length
        );

        $("#nhanCaModal").modal("show");
    });

    $("#gioRaLo").on("change", function () {
        var gioRaLo = $(this).val();
        var gio = parseInt(gioRaLo.split(":")[0]);
        var phut = parseInt(gioRaLo.split(":")[1]);
        var now = new Date();
        var currentDate = now.toISOString().split("T")[0];

        if (gio > 6 || (gio === 6 && phut >= 30)) {
            if (gio < 18 || (gio === 18 && phut < 30)) {
                var nextDay = new Date(now);
                nextDay.setDate(now.getDate() + 1);
                $("#ngayRaLo").val(nextDay.toISOString().split("T")[0]);
            } else {
                $("#ngayRaLo").val(currentDate);
            }
        } else {
            alert("Giờ ra lò phải nằm trong khoảng từ 6h30 sáng trở lên.");
            $("#ngayRaLo").val("");
        }
    });

    $(".close, .closenhanca").on("click", function () {
        $("#nhanCaModal").modal("hide");
        $("#drumIds").val("");
        table.rows(".thunggiaoca").every(function () {
            $(this.node()).removeClass("selected");
        });
    });
});

$(document).ready(function () {
    $(".editDrumBtn").on("click", function () {
        var drumId = $(this).data("id");

        $.ajax({
            url: "/get-drum-details/" + drumId,
            type: "GET",
            success: function (data) {
                $("#editLink").val(data.link);
                $("#editImpurity").val(data.impurity_removing);
                $("#editThickness").val(data.thickness);
                $("#editTrangThaiCom").val(data.trang_thai_com);

                $("#drumId").val(drumId);

                $("#editModal").modal("show");
            },
            error: function (error) {
                console.error("Error fetching drum details:", error);
            },
        });
    });
});

$(document).ready(function () {
    var table = $("#datatable").DataTable();

    $("#datatable tbody").on("click", "tr", function () {
        var rowId = $(this).attr("id");
        console.log("Row ID:", rowId);

        var editLink = "/rubber/:id/edit";
        editLink = editLink.replace(":id", rowId);
        $("#editLink").attr("href", editLink);
    });
});
