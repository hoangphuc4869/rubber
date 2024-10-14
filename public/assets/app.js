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

// $("#min").datepicker("setDate", currentDate);

$("#min").on("change", function () {
    table.draw();
    table5.draw();
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

// $(document).ready(function () {
//     $("#lineFilter").val("3");

//     table.draw();
// });

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
    order: [[1, "desc"]],
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

if (
    $("#datatable thead th").eq(5).text() === "Thời gian ra lò" ||
    $("#datatable thead th").eq(5).text() === "Thời gian ép kiện"
) {
    table.order([[5, "asc"]]).draw();
}

if ($("#datatable thead th").eq(11).text() === "Thời gian ra lò") {
    table.order([[11, "asc"]]).draw();
}

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
            <div class="mb-3 fw-bold">Xuất hàng đi</div>

            <div class="mb-3 col-lg-4">
                <label class="form-label">Số Hợp đồng</label>
                <input type="text" name="delivery_date[${counter}][so_hop_dong]" class="form-control" required placeholder="Số hợp đồng">
            </div>

            <div class="mb-3 col-lg-4">
                <label class="form-label">Loại hàng</label>
                <input type="text" name="delivery_date[${counter}][type]" class="form-control" required value="CSR10" placeholder="Nhập loại hàng">
            </div>

            <div class="mb-3 col-lg-4">
                <label class="form-label">Khối lượng (tấn)</label>
                <input type="number" name="delivery_date[${counter}][amount]" class="form-control" required placeholder="Nhập khối lượng">
            </div>

            <div class="mb-3 col-lg-4">
                <label class="form-label">Ngày đóng cont</label>
                <input type="date" name="delivery_date[${counter}][closing_date]" class="form-control" placeholder="Chọn ngày đóng cont">
            </div>

            <div class="mb-3 col-lg-4">
                <label class="form-label">Ngày nhận hàng</label>
                <input type="date" name="delivery_date[${counter}][receiving_date]" class="form-control" placeholder="Chọn ngày nhận hàng">
            </div>

            <div class="mb-3 col-lg-4">
                <label class="form-label">Lệnh xuất hàng</label>
                <input type="text" name="delivery_date[${counter}][shipping_order]" class="form-control" placeholder="Nhập lệnh xuất hàng">
            </div>

            <div class="mb-3 col-lg-4">
                <label class="form-label">File đính kèm (PDF)</label>
                <input type="file" name="delivery_date[${counter}][file]" class="form-control" accept="application/pdf">
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

function updateShipmentFields(element) {
    var shipmentId = $(element).data("id");
    var ma_xuat = $(
        `input[data-id="${shipmentId}"][data-field="ma_xuat"]`
    ).val();
    var ngay_xuat = $(
        `input[data-id="${shipmentId}"][data-field="ngay_xuat"]`
    ).val();
    var ngay_nhan_hang = $(
        `input[data-id="${shipmentId}"][data-field="ngay_nhan_hang"]`
    ).val();
    var so_hop_dong = $(
        `input[data-id="${shipmentId}"][data-field="so_hop_dong"]`
    ).val(); // Get value of so_hop_dong
    var fileInput = $(`input[data-id="${shipmentId}"].shipment-file`)[0];

    var formData = new FormData();
    formData.append("ma_xuat", ma_xuat);
    formData.append("ngay_xuat", ngay_xuat);
    formData.append("ngay_nhan_hang", ngay_nhan_hang);
    formData.append("so_hop_dong", so_hop_dong);

    if (fileInput.files.length > 0) {
        formData.append("pdf", fileInput.files[0]);
    }

    $.ajax({
        url: `/shipment/${shipmentId}/update`,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log("Updated successfully");
        },
        error: function (xhr) {
            console.error("Error updating:", xhr.responseText);
        },
    });
}

// $(".shipment-field").on("change", function () {
//     var shipmentId = $(this).data("id");
//     updateShipmentFields(this);
// });

// $(".shipment-file").on("change", function () {
//     var shipmentId = $(this).data("id");
//     updateShipmentFields(this);
// });

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
    order: [[6, "asc"]],
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

$(document).ready(function () {
    var table = $("#datatable2").DataTable();
    var selectedDrums = [];

    $(".switch_within_day").on("click", function () {
        var lineFilter = $("#lineFilter2").val();
        var totalRows = table.data().length;

        var buttonId = $(this).attr("id");
        $("#typeInput").val(buttonId);

        var oven1Data = [];
        var oven2Data = [];
        var oven3Data = [];

        for (var i = 0; i < totalRows; i++) {
            var row = table.row(i).node();
            var drumId = parseInt($(row).attr("id"), 10);
            var dataOven = $(row).data("oven");
            var dataLink = $(row).data("link");

            if (dataOven == 1 && dataLink == 6) {
                oven1Data.push({ row: row, id: drumId });
            } else if (dataOven == 2 && dataLink == 6) {
                oven2Data.push({ row: row, id: drumId });
            } else if (dataOven == 1 && dataLink == 3) {
                oven3Data.push({ row: row, id: drumId });
            }
        }

        if (lineFilter == 3) {
            var rowsData = oven3Data;

            if (rowsData.length < 30) {
                alert(
                    `Không đủ thùng: Chỉ có ${rowsData.length} thùng, cần đủ 30 thùng.`
                );
            } else {
                rowsData.sort(function (a, b) {
                    return b.id - a.id;
                });
                rowsData = rowsData.slice(0, 30);

                console.log(rowsData);

                selectedDrums = [];
                rowsData.forEach(function (data) {
                    $(data.row).addClass("selected");
                    selectedDrums.push(data.id);
                });

                // Update hidden input and modal text
                $("#drumsInput").val(selectedDrums.join(","));
                $(".so-thung-giao-ca").text(selectedDrums.length);
                $("#confirmModal").modal("show");
            }
        } else {
            if (oven1Data.length < 32 || oven2Data.length < 32) {
                var missingOven1 = Math.max(32 - oven1Data.length, 0);
                var missingOven2 = Math.max(32 - oven2Data.length, 0);
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

                var selectedOven1 = oven1Data.slice(0, 32);
                var selectedOven2 = oven2Data.slice(0, 32);

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
        // table.$("tr.selected").removeClass("selected");
        selectedDrums = [];
        $("#drumsInput").val("");
    });
});

// đổi ca
$(document).ready(function () {
    var table = $("#datatable2").DataTable();
    var selectedDrums = [];

    $(".switch_another_day").on("click", function () {
        var lineFilter = $("#lineFilter2").val();
        var totalRows = table.data().length;

        var buttonId = $(this).attr("id");
        $("#typeInput").val(buttonId);

        var oven1Data = [];
        var oven2Data = [];
        var oven3Data = [];

        for (var i = 0; i < totalRows; i++) {
            var row = table.row(i).node();
            var drumId = parseInt($(row).attr("id"), 10);
            var dataOven = $(row).data("oven");

            var dataLink = $(row).data("link");

            if (dataOven == 1 && dataLink == 6) {
                oven1Data.push({ row: row, id: drumId });
            } else if (dataOven == 2 && dataLink == 6) {
                oven2Data.push({ row: row, id: drumId });
            } else if (dataOven == 1 && dataLink == 3) {
                oven3Data.push({ row: row, id: drumId });
            }
        }

        if (lineFilter == 3) {
            var rowsData = oven3Data;

            if (rowsData.length < 27) {
                alert(
                    `Không đủ thùng: Cần 27 thùng nhưng chỉ có ${rowsData.length}`
                );
            } else {
                rowsData.sort(function (a, b) {
                    return b.id - a.id;
                });
                selectedDrums = [];

                rowsData.slice(0, 27).forEach(function (data) {
                    $(data.row).addClass("selected");
                    selectedDrums.push(data.id);
                });

                $("#drumsInput").val(selectedDrums.join(","));
                $(".so-thung-giao-ca").text(selectedDrums.length);
                $("#confirmModal").modal("show");
            }
        } else {
            if (oven1Data.length < 28 || oven2Data.length < 28) {
                var missingOven1 = Math.max(28 - oven1Data.length, 0);
                var missingOven2 = Math.max(28 - oven2Data.length, 0);
                alert(
                    `Không đủ thùng: Thiếu ${missingOven1} từ lò 1, và ${missingOven2} từ lò 2.`
                );
            } else {
                oven1Data.sort(function (a, b) {
                    return b.id - a.id;
                });
                oven2Data.sort(function (a, b) {
                    return b.id - a.id;
                });

                var selectedOven1 = oven1Data.slice(0, 28);
                var selectedOven2 = oven2Data.slice(0, 28);

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

        var lineFilter = $("#lineFilter").val();

        table.rows(".thungdoica").every(function (rowIdx, tableLoop, rowLoop) {
            var row = this.node();
            $(row).addClass("selected");
            var drumId = $(row).attr("id");
            var dataLink = $(row).data("link");

            if (lineFilter == 3 && dataLink == 3) {
                $(row).addClass("selected");
                selectedDrumIds.push(drumId);
            } else if (lineFilter == 6 && dataLink == 6) {
                selectedDrumIds.push(drumId);
            }
        });

        if (selectedDrumIds.length === 0) {
            alert("Không có thùng nào được chọn để đổi ca.");
            return;
        } else {
            $("#num3t").text(selectedDrumIds.length);
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
        $("#editModal").modal("show");

        // $.ajax({
        //     url: "/get-drum-details/" + drumId,
        //     type: "GET",
        //     success: function (data) {
        //         $("#editLink").val(data.link);
        //         $("#editImpurity").val(data.impurity_removing);
        //         $("#editThickness").val(data.thickness);
        //         $("#editTrangThaiCom").val(data.trang_thai_com);

        //         $("#drumId").val(drumId);

        //     },
        //     error: function (error) {
        //         console.error("Error fetching drum details:", error);
        //     },
        // });
    });
});

// $(document).ready(function () {
//     var table = $("#datatable").DataTable();

// });

$(document).ready(function () {
    $("#thang_giao_hang").select2();
});

// datatable5

var currentDate = new Date();
currentDate.setHours(currentDate.getHours() - 6);
currentDate.setMinutes(currentDate.getMinutes() - 30);

$("#min5").datepicker({
    dateFormat: "dd/mm/yy",
});

$("#min5").datepicker("setDate", currentDate);

$("#min5").on("change", function () {
    table5.draw();
});

// $("#comFilter").on("change", function () {
//     $("#company").val($("#comFilter").val());
//     table.draw();
// });

$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    if (settings.nTable.id !== "datatable5") {
        return true;
    }

    // Lọc ngày
    let filterDateStr = $("#min5").val();
    let filterDate = filterDateStr
        ? new Date(convertDate(filterDateStr))
        : null;

    let rowDateStr = data[0];
    let rowDate = rowDateStr ? new Date(convertDate(rowDateStr)) : null;

    // console.log("Ngày lọc:", filterDate, "Ngày trong hàng:", rowDate);

    function convertDate(dateStr) {
        if (!dateStr) return null;
        let parts = dateStr.split("/");
        return new Date(parts[2], parts[1] - 1, parts[0]);
    }

    function formatDateToCompare(date) {
        return date ? date.toISOString().split("T")[0] : null;
    }

    let formattedFilterDate = formatDateToCompare(filterDate);
    let formattedRowDate = formatDateToCompare(rowDate);

    if (formattedFilterDate && formattedRowDate !== formattedFilterDate) {
        return false;
    }

    let lineFilter = $("#lineFilter5").val();
    let rowLine = data[7];
    if (lineFilter && rowLine !== lineFilter) {
        return false;
    }

    // Lọc công ty
    let com = $("#comFilter5").val();
    let rowCom = data[1];
    if (com && rowCom !== com) {
        return false;
    }

    return true;
});

$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    if (settings.nTable.id !== "datatable2") {
        return true;
    }

    let filterDateStr = $("#min5").val();
    let filterDate = filterDateStr
        ? new Date(convertDate(filterDateStr))
        : null;

    let rowDateStr = data[1];
    let rowDate = rowDateStr ? new Date(convertDate(rowDateStr)) : null;

    function convertDate(dateStr) {
        if (!dateStr) return null;
        let parts = dateStr.split("/");
        return new Date(parts[2], parts[1] - 1, parts[0]);
    }

    function formatDateToCompare(date) {
        return date ? date.toISOString().split("T")[0] : null;
    }

    let formattedFilterDate = formatDateToCompare(filterDate);
    let formattedRowDate = formatDateToCompare(rowDate);

    if (formattedFilterDate && formattedRowDate !== formattedFilterDate) {
        return false;
    }

    let lineFilter = $("#lineFilter2").val();
    let rowLine = data[12];
    if (lineFilter && rowLine !== lineFilter) {
        return false;
    }

    return true;
});

let table5 = new DataTable("#datatable5", {
    fixedHeader: true,
    paging: true,
    scrollCollapse: true,
    scrollY: "80vh",
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

    scrollX: true,
    autoWidth: false,

    select: {
        style: "multi",
    },
});

$("#min5, #lineFilter5, #comFilter5, #lineFilter2").on("change", function () {
    table5.draw();
    table2.draw();
});

table5.on("select deselect", function () {
    updateSelectedRows();
});

// if ($("#datatable5 thead th").eq(6).text() === "Thời gian tạo lô") {
//     table5.order([[6, "asc"]]).draw();
//     // table5.page.len(-1).draw();
// }

function updateSelectedRows() {
    let selectedRows = table5.rows({ selected: true }).nodes().toArray();

    // Get the 'id' attribute from each <tr>
    let selectedIds = selectedRows.map((row) => $(row).attr("id"));

    if (selectedIds.length > 0) {
        $(".form-delete-items").removeClass("d-none");

        $("#selected-drums").val(selectedIds.join(","));
    } else {
        $(".form-delete-items").addClass("d-none");

        $("#selected-drums").val("");
    }
}

//update DRC

//update bale

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
                    row.find("td").eq(8).text(item.bale_count);
                    row.find("td").eq(9).text(item.bale_count);
                    row.find("td").eq(12).text(item.sample_cut);
                    row.find("td").eq(10).text(item.pressing_temp);
                    row.find("td").eq(13).text(item.evaluation);
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

//filter stat & time start based on oven

$(document).ready(function () {
    var table2 = $("#datatable2").DataTable();
    var initialStartTime = "";

    // $("#stat").val("Đang xử lý nhiệt");
    // var initialValue = $("#stat").val();
    // table2.column(2).search(initialValue, false, false).draw();

    // $("#stat").on("change", function () {
    //     var selectedValue = $(this).val();
    //     table2.column(2).search(selectedValue, false, false).draw();
    // });

    $('select[name="oven"]').on("change", function () {
        var selectedOven = $(this).val();

        var rows = table2.rows().nodes();
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
            var startTime = $(lastRow).find("td:eq(4)").text();

            var extraMinutes = parseInt($(lastRow).find("td:eq(5)").text());

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

    // $('input[name="time_to_dry"]').on("input", function () {
    //     var dryingTime = parseInt($(this).val());

    //     if (!initialStartTime) {
    //         return;
    //     }

    //     var startTimeParts = initialStartTime.split(":");
    //     var startHour = parseInt(startTimeParts[0]);
    //     var startMinutes = parseInt(startTimeParts[1]);
    //     var totalStartMinutes = startHour * 60 + startMinutes;

    //     if (!isNaN(dryingTime)) {
    //         var endTotalMinutes = totalStartMinutes + dryingTime;

    //         var endHour = Math.floor(endTotalMinutes / 60);
    //         var endMinutes = endTotalMinutes % 60;

    //         var formattedEndHour = endHour.toString().padStart(2, "0");
    //         var formattedEndMinutes = endMinutes.toString().padStart(2, "0");

    //         $("#timeInput").val(`${formattedEndHour}:${formattedEndMinutes}`);
    //     } else {
    //         $("#timeInput").val(initialStartTime);
    //     }
    // });
});

$(document).ready(function () {
    var table = $("#datatable").DataTable();

    let totalWeight = 0;
    let maxWeight = parseFloat($("#so_luong").text()) * 1000;
    let selectedBatches = [];

    table.on("change", function () {
        let row = $(this).closest("tr");
        let baleCount = parseFloat(row.data("bale"));
        console.log(baleCount);

        let batchCode = row.data("code");
        let weight = baleCount * 35;

        if (this.checked) {
            totalWeight += weight;
            selectedBatches.push(batchCode);
        } else {
            totalWeight -= weight;
            selectedBatches = selectedBatches.filter(
                (code) => code !== batchCode
            );
        }

        $("#total_weight").text(totalWeight.toFixed(2));

        if (totalWeight > maxWeight) {
            let excess = totalWeight - maxWeight;
            $("#status_message").html(
                `<span class='text-danger'>Đủ khối lượng. Còn dư ${excess.toFixed(
                    2
                )} kg, thuộc mã lô: ${selectedBatches.join(", ")}</span>`
            );
        } else {
            $("#status_message").html(
                `<span class='text-success'>Chưa đạt đủ khối lượng. Còn thiếu: ${(
                    maxWeight - totalWeight
                ).toFixed(2)} kg.</span>`
            );
        }
    });
});
