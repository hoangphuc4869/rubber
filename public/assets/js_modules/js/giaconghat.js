$("#dateFilterGiaconghat").datepicker({
    dateFormat: "dd-mm-yy",
});
$("#dateFilterGiaconghat").datepicker("setDate", new Date());

let tableGiaconghat = new DataTable("#giaconghatTable", {
    ajax: {
        url: "/get-giaconghat-data",
        type: "GET",
        data: function (d) {
            d.date = $("#dateFilterGiaconghat").val();
            d.status = $("#statusFilterGiaconghat").val();
            d.link = $("#linkFilterGiaconghat").val();
            d.area = $("#areaFilterGiaconghat").val();
        },
    },
    createdRow: function (row, data, dataIndex) {
        $(row).attr("id", data.id);
        $(row).attr("data-status", data.status);
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
                } else if (data === 5) {
                    if (row.bale) {
                        return row.batches.length > 0
                            ? "<span class='text-info'>Đã đóng lô</span>"
                            : "<span class='text-success'>Đã ép kiện</span>";
                    } else {
                        return "<span class='text-success'>Đã xử lý nhiệt</span>";
                    }
                } else {
                    return "<span class='text-success'>Đang xử lý nhiệt</span>";
                }
            },
        },
        { data: "name", name: "name" }, // Tên thùng
        {
            data: "heated_start",
            name: "heated_start",
        },
        {
            data: "rolling_date",
            name: "rolling_date",
        },
        { data: "house_code", name: "curing_house_id" }, // Nhà ủ
        { data: "link", name: "link" }, // Dây chuyền
        { data: "thickness", name: "thickness" }, // Bề dày tờ mủ
        { data: "trang_thai_com", name: "trang_thai_com" }, // Trạng thái cốm
        { data: "impurity_removing", name: "impurity_removing" }, // Tạp chất loại bỏ
        { data: "supervisor", name: "supervisor" }, // Trưởng ca
    ],
    scrollX: true,
    autoWidth: false,
});

//filter date

$("#btnGiaconghatFilter").on("click", function () {
    console.log($("#dateFilterGiaconghat").val());
    tableGiaconghat.ajax.reload();
});

$("#curing_house").on("change", function () {
    var selectedHouse = $("#curing_house option:selected").text();

    var locationOptions = $("#location option");

    locationOptions.each(function () {
        if ($(this).data("house") === selectedHouse) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });

    $("#location").val(null);
});
