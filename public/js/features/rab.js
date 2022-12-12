const menuContext = "Rencana Anggaran Belanja";
const tableId = "#table-rab";
const formId = "#form-rab";
const indexAPI = `${site_url_api}/rab`;
const storeAPI = `${site_url_api}/rab/store`;
const deleteAPI = `${site_url_api}/rab/delete`;
const updateAPI = `${site_url_api}/rab/update`;
const allItem = new Set();

$(document).ready(function () {
    const tableItem = initializeDatatables(tableId, indexAPI, [
        {
            data: "id",
            title: "Actions",
            searchable: false,
            orderable: false,
            render: function (id, type, item) {
                allItem.add(item);

                return `
                        ${Button({
                            text: "Edit",
                            color: "warning btn-sm",
                            onclick: `edit(${id})`,
                        })}
                        ${Button({
                            text: "Hapus",
                            color: "danger btn-sm",
                            onclick: `destroy(${id})`,
                        })}
                    `;
            },
        },
        { data: "nomor_akun", title: "Nomor Akun" },
        { data: "status", title: "Status" },
        { data: "jenis", title: "Jenis" },
        { data: "waktu_pelaksanaan", title: "Waktu Pelaksanaan " },
    ]);

    tableItem.on("click", "tr", function (event) {
        let itemId = tableItem.row(this).data().id;
        const isClickedOnActionsButton = $(event.target)
            .parent()
            .hasClass("sorting_1");

        console.log(isClickedOnActionsButton);
        // if (!isClickedOnActionsButton) {
        //     window.location.replace(site_url + "/rab/show/" + itemId);
        // }
    });
});

const getCurrentrab = (id) => {
    let currentrab;

    for (const item of allItem) {
        if (item.id == id) currentrab = item;
    }

    return currentrab;
};

const destroy = (id) => {
    Toast({
        timeout: 5000,
        overlay: true,
        title: "Hapus data rab",
        message: "Apakah anda yakin?",
        position: "center",
        type: "question",
        buttons: [
            [
                "<button><b>YES</b></button>",
                function (instance, toast) {
                    $.ajax({
                        type: "POST",
                        url: deleteAPI + "/" + id,
                        data: {
                            _method: "DELETE",
                        },
                        dataType: "json",
                        success: function (response) {
                            if (response.status === 200) {
                                reloadTable(tableId);
                                instance.hide(
                                    { transitionOut: "fadeOut" },
                                    toast,
                                    "button"
                                );
                                Toast({
                                    title: "Berhasil",
                                    message: response.message,
                                });
                            }

                            if (response.status === 404) {
                                Toast({
                                    title: "Gagal",
                                    type: "warning",
                                    message: response.message,
                                });
                            }
                        },
                        error: function (event, type, message) {
                            Toast({
                                title: "Gagal",
                                message: `Item ${message}`,
                                type: "error",
                            });
                        },
                    });
                },
                true,
            ],
            [
                "<button>NO</button>",
                function (instance, toast) {
                    instance.hide(
                        { transitionOut: "fadeOut" },
                        toast,
                        "button"
                    );
                },
            ],
        ],
    });
};
