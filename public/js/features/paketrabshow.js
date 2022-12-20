const tableId = "#tabledetailpaketrab";
$(document).ready(function () {
    var groupColumn = 8;
    var table = $(tableId).DataTable({
        rowGroup: true,
        columnDefs: [{ visible: false, targets: groupColumn }],
        order: [[groupColumn, "asc"]],
        displayLength: 10,
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({ page: "current" }).nodes();
            var last = null;

            api.column(groupColumn, { page: "current" })
                .data()
                .each(function (group, i) {
                    if (last !== group) {
                        $(rows)
                            .eq(i)
                            .before(
                                '<tr class="group"><td colspan="12">' +
                                    group +
                                    "</td></tr>"
                            );

                        last = group;
                    }
                });
        },
    });

    // Order by the grouping
    $(`${tableId} tbody`).on("click", "tr.group", function () {
        var currentOrder = table.order()[0];
        if (currentOrder[0] === groupColumn && currentOrder[1] === "asc") {
            table.order([groupColumn, "desc"]).draw();
        } else {
            table.order([groupColumn, "asc"]).draw();
        }
    });
});
