$("#dateFilterKho").datepicker({
    dateFormat: "dd-mm-yy",
});
// $("#dateFilterKho").datepicker("setDate", new Date());

var onShipmentPage = window.location.pathname.includes("shipments");

let columns = [
    {
        data: "date",
        name: "date",
        render: function (data, type, row) {
            return moment(data).format("DD/MM/YYYY");
        },
    },
    {
        data: "warehouse.code",
        name: "warehouse.code",
        render: function (data, type, row) {
            return data
                ? `<span class="fw-bold" style="color: #000a8d">${data}</span>`
                : `<span class="text-danger">Trống</span>`;
        },
    },
    !onShipmentPage
        ? {
              data: null,
              orderable: false,
              searchable: false,
              render: function (data, type, row) {
                  return `
                    <button type="button" class="editWare" data-bs-toggle="modal" data-bs-target="#modalCenter"
                        data-id="${data.id}" data-warehouseId='${data.warehouse_id}'>
                        Sắp xếp
                    </button>
                  `;
              },
          }
        : null,
    !onShipmentPage
        ? {
              data: "company.code",
              name: "company.code",
          }
        : null,
    {
        data: "batch_code",
        name: "batch_code",
    },
    {
        data: "so_banh",
        name: "so_banh",
        render: function (data, type, row) {
            return data == 144
                ? `<span class="text-dark">${data}</span>`
                : `<span class="text-danger">${data}</span>`;
        },
    },
    {
        data: "checked",
        name: "checked",
        render: function (data, type, row) {
            return data == 0
                ? `<span class="text-danger">Chưa</span>`
                : `<span class="text-success">Đã kiểm nghiệm</span>`;
        },
    },
    {
        data: "exported",
        name: "exported",
        render: function (data, type, row) {
            return data == 0
                ? `<span class="text-danger">Chưa xuất kho</span>`
                : `<span class="text-dark">Đã xuất kho</span>`;
        },
    },
    {
        data: "expected_grade",
        name: "expected_grade",
    },
    {
        data: "sample_cut_number",
        name: "sample_cut_number",
    },
    {
        data: "packaging_type",
        name: "packaging_type",
    },
];

columns = columns.filter((col) => col !== null);

let tableKho = new DataTable("#tableKho", {
    ajax: {
        url: "/get-kho-data",
        type: "GET",
        data: function (d) {
            d.date = $("#dateFilterKho").val();
            d.checked = $("#checkedFilterKho").val();
            d.grade = $("#gradeFilterKho").val();
            d.kho = $("#FilterKho").val();
            d.nongtruong = $("#nongtruongFilterList").val();
            d.company = $("#company_id").val();
            d.farm = $("#nongtruongFilterList").val();
            if (onShipmentPage) {
                d.checked = 1;
                // d.exported = 0;
            }
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
        oPaginate: {
            sFirst: "Đầu tiên",
            sPrevious: "Trước",
            sNext: "Tiếp theo",
            sLast: "Cuối cùng",
        },
    },
    paging: false,
    processing: true,
    serverSide: true,
    order: [],
    columns: columns,
    scrollX: true,
    scrollCollapse: true,
    scrollY: "100vh",
    autoWidth: false,
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

//filter date

$("#btnKhoFilter").on("click", function () {
    tableKho.ajax.reload();
});

// tableNguyenLieu.on("select", updateNguyenLieuButtons);
// tableNguyenLieu.on("deselect", updateNguyenLieuButtons);

$(document).ready(function () {
    var $batch = $("#batch_id"); // input hidden
    var $update = $(".updateWare");
    var $slot = $("#slot");
    var $btnClose = $(".modalWare .btn-close");

    $("#tableKho tbody").on("click", "tr", function () {
        var batchId = $(this).attr("id");
        $batch.val(batchId);
    });

    if ($update.length) {
        $update.on("click", function () {
            const slotValue = $slot ? $slot.val() : null;
            const data = {
                batchId: $batch.val(),
                slotId: slotValue,
            };

            console.log(data);

            $.ajax({
                url: "/store-location",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                contentType: "application/json",
                data: JSON.stringify(data),
                success: function (response) {
                    $btnClose.click();
                    window.location.reload();
                },
                error: function (error) {
                    console.error("Error:", error);
                },
            });
        });
    }
});

$(document).ready(function () {
    var table = $("#tableKho").DataTable();
    var selectedCount = 0;
    var totalWeight = 0;
    var maxWeight = +$("#maxWeight").text();

    function updateBatchAndBale() {
        var batchData = [];

        $(".box-batch > div").each(function () {
            var batchId = $(this).attr("id");
            var baleCount =
                parseInt($(this).find(".bale-input").val(), 10) || 0;

            batchData.push({
                batch_id: batchId,
                bale_count: baleCount,
            });
        });

        $("#batch_and_bale").val(JSON.stringify(batchData));
    }

    function updateTotals() {
        selectedCount = $(".box-batch").children().length;
        totalWeight = 0;
        $(".box-batch .bale-input").each(function () {
            var baleCount = parseInt($(this).val(), 10) || 0;
            totalWeight += baleCount * 35;
        });
        $(".card-header .fw-bold span").eq(0).text(selectedCount);
        $(".card-header .fw-bold span").eq(1).text(totalWeight);

        // Cập nhật giá trị vào `batch_and_bale`
        updateBatchAndBale();
    }

    $("#tableKho tbody").on("click", "tr", function () {
        var col2 = $(this).find("td").eq(2).text();
        var col3 = $(this).find("td").eq(3).text();
        var baleCount = parseInt(col3, 10);

        var batchId = col2.replace(/\s+/g, "-");

        var existingBatchInfo = $(".box-batch").find("#" + batchId);

        if (existingBatchInfo.length) {
            existingBatchInfo.remove();
        } else {
            var batchInfo = $("<div>")
                .attr("id", batchId)
                .css({
                    "max-width": "200px",
                    display: "inline-block",
                    marginBottom: "15px",
                    position: "relative",
                })
                .append(
                    $("<div class='bg-dark text-white p-3 rounded'>")
                        .append(
                            $(
                                "<button class='close-btn text-danger'>&times;</button>"
                            ).css({
                                position: "absolute",
                                top: "-7px",
                                right: "12px",
                                background: "none",
                                border: "none",
                                fontSize: "25px",
                                cursor: "pointer",
                            })
                        )
                        .append(
                            "<div class='text-center mb-1 fw-bold text-warning'>" +
                                col2 +
                                "</div>"
                        )
                        .append(
                            $("<div class='d-flex align-items-center gap-2'>")
                                .append(
                                    "<label><strong class='text-nowrap'>Số bành:</strong> </label> "
                                )
                                .append(
                                    '<input type="number" min="1" max="144" class="form-control d-inline w-100 bale-input" value="' +
                                        col3 +
                                        '" oninput="this.value = Math.min(this.value, 144);">'
                                )
                        )
                );

            $(".box-batch").append(batchInfo);
        }

        updateTotals();
    });

    $(".box-batch").on("input", ".bale-input", function () {
        updateTotals();
    });

    $(".box-batch").on("click", ".close-btn", function () {
        $(this).closest("div[id]").remove();
        updateTotals();
    });

    $("#exportFormB").on("submit", function (e) {
        if (totalWeight !== maxWeight) {
            e.preventDefault();
            console.log(totalWeight, maxWeight);
            alert("Vui lòng kiểm tra lại khối lượng.");
        } else {
            if (!confirm("Xác nhận xuất hàng?")) {
                e.preventDefault();
            }
        }
    });
});

// $(document).ready(function () {
//     $('[data-bs-toggle="tooltip"]').tooltip();
// });
