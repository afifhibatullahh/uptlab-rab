const initializeDatatables = (tableId, ajaxUrl, columns, ajaxData = {}) => {
    return $(tableId).DataTable({
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, 99999],
            [10, 25, 50, "All"],
        ],
        ajax: {
            url: ajaxUrl,
            data: ajaxData,
        },
        columns: columns,
        oLanguage: {
            sEmptyTable: "Data masih kosong",
        },
    });
};

const initializeDatatablesFromArray = (tableId, columns, ajaxData = []) => {
    return $(tableId).DataTable({
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, 99999],
            [10, 25, 50, "All"],
        ],
        data: ajaxData,
        columns: columns,
        oLanguage: {
            sEmptyTable: "Data masih kosong",
        },
    });
};

const reloadTable = (tableId) => {
    $(tableId).DataTable().ajax.reload(null, false);
};
