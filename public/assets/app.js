function confirmDelete() {
    return confirm("Bạn có chắc chắn muốn xóa không?");
}

new DataTable("#example", {
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
    autoWidth: true,
});

let table = new DataTable("#material", {
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

let table2 = new DataTable("#material-heating", {
    layout: {
        topStart: {
            buttons: [
                {
                    text: "Tất cả",
                    className: "btn btn-primary",
                    action: function () {
                        table2.rows().select();
                    },
                },
                {
                    text: "Bỏ chọn",
                    className: "btn btn-danger",
                    action: function () {
                        table2.rows().deselect();
                    },
                },
                {
                    text: "Xuất kho",
                    className: "ml-3 btn btn-info",
                    action: function () {
                        alert("Custom button clicked!");
                    },
                },
                {
                    text: "Xóa tất cả",
                    className: "btn btn-warning",
                    action: function (e, dt, node, config) {
                        if (
                            confirm(
                                "Bạn có chắc chắn muốn xóa tất cả các hàng?"
                            )
                        ) {
                            dt.clear().draw();
                        }
                    },
                },
            ],
        },
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
    select: {
        style: "multi",
    },
    scrollX: true,
    autoWidth: false,
});

let table3 = new DataTable("#material-heating2", {
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

table2.on("click", "tbody tr", function (e) {
    e.currentTarget.classList.toggle("selected");

    let selectedRows = table2.rows(".selected").nodes();

    let values = Array.from(selectedRows).map((row) => {
        return row.id;
    });

    document.getElementById("selected-drums").value = values.join(",");
});

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
                    window.location.reload();
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

// $(document).ready(function () {
//     // Checkbox chọn tất cả
//     $(".select-all-checkbox").on("click", function () {
//         let isChecked = $(this).is(":checked");
//         if (isChecked) {
//             table2.rows().select(); // Chọn tất cả các hàng
//         } else {
//             table2.rows().deselect(); // Bỏ chọn tất cả các hàng
//         }
//     });

//     // Checkbox trong các hàng
//     $("#material-heating tbody").on(
//         "click",
//         'input[type="checkbox"]',
//         function () {
//             let row = $(this).closest("tr");
//             if (this.checked) {
//                 table.row(row).select(); // Chọn hàng tương ứng
//             } else {
//                 table.row(row).deselect(); // Bỏ chọn hàng tương ứng
//             }
//         }
//     );
// });
