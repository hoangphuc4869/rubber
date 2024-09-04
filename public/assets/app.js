function confirmDelete() {
    return confirm("Bạn có chắc chắn muốn xóa không?");
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

$("#min").on("change", function () {
    table.draw();
    classList.draw();
});

$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    let filterDateStr = $("#min").val();
    let filterDate = filterDateStr
        ? new Date(convertDate(filterDateStr))
        : null;
    let rowDateStr = data[1];
    let rowDate = rowDateStr ? new Date(convertDate(rowDateStr)) : null;

    function convertDate(dateStr) {
        let parts = dateStr.split("/");
        return `${parts[2]}-${parts[1]}-${parts[0]}`;
    }

    if (!filterDate || rowDate.toDateString() === filterDate.toDateString()) {
        return true;
    }
    return false;
});

//end-date-filter

//table-settings
let table = new DataTable("#datatable", {
    columnDefs: [
        {
            orderable: false,
            render: DataTable.render.select(),
            targets: 0,
        },
    ],
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

//end-table-settings

table.on("select", updateButtons);
table.on("deselect", updateButtons);

$("#select-all").on("change", function () {
    let checked = $(this).prop("checked");
    let rows = table.rows({ search: "applied" }).nodes(); // Lấy tất cả các hàng hiện tại trên trang

    // Lọc các hàng có thể chọn (không có lớp 'no-select')
    let selectableRows = $(rows).filter(function () {
        return !$(this).hasClass("no-select");
    });

    // Đặt trạng thái chọn cho các hàng đã lọc
    if (checked) {
        // Chọn các hàng có thể chọn
        selectableRows.each(function () {
            if (!$(this).hasClass("selected")) {
                table.row(this).select();
            }
        });
    } else {
        // Bỏ chọn các hàng có thể chọn
        selectableRows.each(function () {
            if ($(this).hasClass("selected")) {
                table.row(this).deselect();
            }
        });
    }

    updateButtons(); // Cập nhật trạng thái của các nút, nếu cần
});

// Cập nhật nút dựa trên các hàng đã chọn
function updateButtons() {
    // Lấy tất cả các hàng được chọn
    let selectedRows = table.rows(".selected").nodes();

    // Lọc các hàng có thể chọn (không có lớp 'no-select')
    let selectableRows = Array.from(selectedRows).filter(
        (row) => !$(row).hasClass("no-select")
    );

    // Lấy giá trị của các hàng có thể chọn
    let values = selectableRows.map((row) => row.id);

    // Cập nhật giá trị vào các trường input
    document.getElementById("selected-drums").value = values.join(",");
    var batches = document.getElementById("batchesToExport");

    if (batches) {
        batches.value = values.join(",");
    }

    // Hiển thị hoặc ẩn các nút dựa trên số lượng hàng được chọn
    if (values.length > 0) {
        $(".form-delete-items").removeClass("d-none");
        $(".exportButton").removeClass("d-none");
    } else {
        $(".form-delete-items").addClass("d-none");
        $(".exportButton").addClass("d-none");
    }
}

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
                batch.value = item.dataset.warehouseid;
            });
        });
    }

    if (update) {
        update.addEventListener("click", () => {
            const slotValue = slot ? slot.value : null;
            const data = {
                draggedItemId: batch.value,
                targetItemId: slotValue,
            };
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
    $(".rolling-code-select").on("change", function () {
        var selectedOption = $(this).find("option:selected");
        var curingHouse = selectedOption.data("house");
        var curingArea = selectedOption.data("curing");

        $("#rolling-house").val(curingHouse);
        $("#rolling-area").val(curingArea);
    });
});
