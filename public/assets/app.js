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

flatpickr("#timeInput", {
    enableTime: true,
    noCalendar: true,
    time_24hr: true,
    minuteIncrement: 1,
    dateFormat: "H:i",
    defaultDate: new Date(),
});

flatpickr("#timeInput2", {
    enableTime: true,
    noCalendar: true,
    time_24hr: true,
    minuteIncrement: 1,
    dateFormat: "H:i",
});

flatpickr("#adjust-time", {
    enableTime: true,
    noCalendar: true,
    time_24hr: true,
    minuteIncrement: 1,
    dateFormat: "H:i",
    allowInput: true,
});

// const now = new Date();
// let hours = now.getHours();
// let minutes = now.getMinutes();

// hours = String(hours).padStart(2, "0");
// minutes = String(minutes).padStart(2, "0");

// const currentTime = `${hours}:${minutes}`;

// if (timeInput) {
//     timeInput.value = currentTime;
// }

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
            updateWeight(firstMatchingOption);
        } else {
            $("select[name='rolling_code']").val("");
            $("#weight").val("");
        }
    });

    $("select[name='rolling_code']").on("change", function () {
        var selectedOption = $(this).find("option:selected");
        updateWeight(selectedOption);
    });

    function updateWeight(selectedOption) {
        var maxVal = selectedOption.data("maxval");

        if (maxVal) {
            var weightInput = $("#weight");
            weightInput.val(maxVal);
            weightInput.attr("max", maxVal);
        } else {
            $("#weight").val("");
        }
    }
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
        const contractId = $(this).data("id");

        let newDeliveryDate = `
        <div class="delivery_dates mb-3 row" id="delivery_dates_${counter}">
            <div class="mb-3 fw-bold">Xuất hàng đi</div>

            <div class="mb-3 col-lg-3">
                <label class="form-label">Số Hợp đồng</label>
                <select name="delivery_date[${counter}][so_hop_dong]" class="form-control contract-select" required>
                    <option value="">Loading...</option>
                </select>
            </div>

            <div class="mb-3 col-lg-3">
                <label class="form-label">Loại hàng</label>
                <input type="text" name="delivery_date[${counter}][type]" class="form-control" required value="CSR10" placeholder="Nhập loại hàng">
            </div>

            <div class="mb-3 col-lg-3">
                <label class="form-label">Khối lượng (tấn)</label>
                <input type="number" name="delivery_date[${counter}][amount]" class="form-control" required placeholder="Nhập khối lượng">
            </div>

            <div class="mb-3 col-lg-3">
                <label class="form-label">Lệnh xuất hàng</label>
                <input type="text" name="delivery_date[${counter}][shipping_order]" class="form-control" placeholder="Nhập lệnh xuất hàng">
            </div>

            <div class="mb-3 col-lg-3">
                <label class="form-label">Ngày đóng cont</label>
                <input type="date" name="delivery_date[${counter}][closing_date]" class="form-control" placeholder="Chọn ngày đóng cont">
            </div>

            <div class="mb-3 col-lg-3">
                <label class="form-label">Ngày xuất hàng</label>
                <input type="date" name="delivery_date[${counter}][shipment_date]" class="form-control" placeholder="Chọn ngày xuất hàng">
            </div>

            <div class="mb-3 col-lg-3">
                <label class="form-label">Ngày nhận hàng</label>
                <input type="date" name="delivery_date[${counter}][receiving_date]" class="form-control" placeholder="Chọn ngày nhận hàng">
            </div>

            

            <div class="mb-3 col-lg-3">
                <label class="form-label">File đính kèm (PDF)</label>
                <input type="file" name="delivery_date[${counter}][file]" class="form-control" accept="application/pdf">
            </div>

            <div class="d-flex justify-content-end align-items-center">
                <button type="button" class="btn btn-danger btn-sm remove-date">Xóa</button>
            </div>
        </div>
    `;

        $(".delivery_dates_container").append(newDeliveryDate);

        fetch(`/get-contracts?code=${contractId}`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then((data) => {
                console.log(data);

                if (data && data.contract) {
                    let contractOptions =
                        '<option value="" disabled>Chọn số hợp đồng</option>';

                    contractOptions += `<option value="${data.contract.contract_number}">${data.contract.contract_number} (HD gốc)</option>`;

                    data.contract_list.forEach((subContract) => {
                        contractOptions += `<option value="${subContract.contract_number}">${subContract.contract_number}</option>`;
                    });

                    $(`.contract-select`).each(function () {
                        $(this).html(contractOptions);
                    });
                } else {
                    $(`#delivery_dates_${counter} .contract-select`).html(
                        '<option value="">Không có hợp đồng</option>'
                    );
                }
            })
            .catch((error) => {
                console.error("Error fetching contracts:", error);
                $(`#delivery_dates_${counter} .contract-select`).html(
                    '<option value="">Lỗi khi tải hợp đồng</option>'
                );
            });

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
    var ngay_dong_cont = $(
        `input[data-id="${shipmentId}"][data-field="ngay_dong_cont"]`
    ).val();
    var so_hop_dong = $(
        `input[data-id="${shipmentId}"][data-field="so_hop_dong"]`
    ).val(); // Get value of so_hop_dong

    var fileInput = $(`input[data-id="${shipmentId}"].shipment-file`)[0];

    var formData = new FormData();
    formData.append("ma_xuat", ma_xuat);
    formData.append("ngay_xuat", ngay_xuat);
    formData.append("ngay_nhan_hang", ngay_nhan_hang);
    formData.append("ngay_dong_cont", ngay_dong_cont);
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

$(".shipment-field").on("change", function () {
    var shipmentId = $(this).data("id");
    updateShipmentFields(this);
});

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
    $(".form-machine").hide();

    $(".addBtn").on("click", function () {
        $(".form-machine").slideToggle();
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
