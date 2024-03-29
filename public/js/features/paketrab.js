const menuContext = "Jenis RAB";
const tableId = "#table-paketrab";
const formId = "#form-paketrab";
const indexAPI = `${site_url_api}/paketrab`;
const storeAPI = `${site_url_api}/paketrab/store`;
const deleteAPI = `${site_url_api}/paketrab/delete`;
const updateAPI = `${site_url_api}/paketrab/update`;
const allItem = new Set();

const modalId = "#modal";
const modalTitleId = "#modal-title";
const modalProceedBtnId = "#modal-proceed-btn";
const modalContainerId = "#modal-paketrab";

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
                            dataToggle: "modal",
                            dataTarget: modalId,
                        })}
                        ${Button({
                            text: "Hapus",
                            color: "danger btn-sm",
                            onclick: `destroy(${id})`,
                        })}
                    `;
            },
        },
        { data: "title", title: "Judul Pengadaan" },
        { data: "jenis_pengadaan", title: "Jenis" },
    ]);

    tableItem.on("click", "tr", function (event) {
        let itemId = tableItem.row(this).data().id;
        const isClickedOnActionsButton = $(event.target)
            .parent()
            .hasClass("sorting_1");

        if (!isClickedOnActionsButton) {
            window.location.replace(site_url + "/paketrab/" + itemId);
        }
    });
});

function edit(id) {
    location.href = `${site_url}/paketrab/edit/${id}`;
}

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
