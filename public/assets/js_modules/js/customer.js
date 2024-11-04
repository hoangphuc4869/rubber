$(document).ready(function () {
    let customerTable = $("#customerTable").DataTable({
        ajax: {
            url: "/get-list-customer",
            type: "GET",
            data: function (d) {
                d.company = $("#companyFilterCustomer").val();
                d.loaiKH = $("#typeFilterCustomer").val();
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
        order: [[0, "desc"]],
        columns: [
            { data: "id", name: "id" },
            { data: "name", name: "name" },
            { data: "description", name: "description" },
            { data: "phone", name: "phone" },
            { data: "email", name: "email" },
            { data: "company", name: "company" },
            { data: "type", name: "type" },
            {
                data: null,
                render: function (data, type, row) {
                    return `<div class="d-flex gap-1">
                        <a href="/customers/${
                            row.id
                        }/edit" class="btn btn-primary">Chỉnh</a>
                        <form action="/customers/${
                            row.id
                        }" method="POST" onsubmit="return confirmDelete();">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="${$(
                                'meta[name="csrf-token"]'
                            ).attr("content")}">
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </form>
                    </div>`;
                },
            },
        ],
        scrollX: true,
        autoWidth: false,
    });

    // Reload data on filter button click
    $("#btnCustomerFilter").on("click", function () {
        customerTable.ajax.reload();
    });
});
