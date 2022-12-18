const menuContext = "Jenis RAB";
const tableId = "#table-jenisrab";
const formId = "#form-jenisrab";
const indexAPI = `${site_url_api}/jenisrab`;
const storeAPI = `${site_url_api}/jenisrab/store`;
const deleteAPI = `${site_url_api}/jenisrab/delete`;
const updateAPI = `${site_url_api}/jenisrab/update`;
const allItem = new Set();

const modalId = "#modal";
const modalTitleId = "#modal-title";
const modalProceedBtnId = "#modal-proceed-btn";
const modalContainerId = "#modal-jenisrab";

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
        { data: "jenis", title: "Jenis RAB" },
    ]);

    // tableItem.on("click", "tr", function (event) {
    //     let itemId = tableItem.row(this).data().id;
    //     const isClickedOnActionsButton = $(event.target)
    //         .parent()
    //         .hasClass("sorting_1");

    //     if (!isClickedOnActionsButton) {
    //         window.location.replace(site_url + "/jenisrab/show/" + itemId);
    //     }
    // });

    $(modalContainerId).append(
        `${ModalPlain({
            body: `
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-header">
                            <strong class="card-title" id="${modalTitleId.slice(
                                1
                            )}"></strong>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <form id="${formId.slice(
                                1
                            )}" action="{{route('${indexAPI}')}}" enctype="multipart/form-data">
                                <div class="row">
                                    <div id="form-item-left-section" class="col-md-6"></div>
                                    <div id="form-item-right-section" class="col-md-6"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>`,
            size: "sm",
        })}`
    );

    $(formId).append(`
        ${InputField({ title: "Jenis RAB", name: "jenis" })}
        ${Button({
            text: "Tambah",
            id: modalProceedBtnId.slice(1),
            onclick: "save()",
        })}
        ${Button({ text: "Cancel", dataDismiss: "modal", color: "danger" })}
    `);
});

const getCurrentjenisrab = (id) => {
    let currentjenisrab;

    for (const item of allItem) {
        if (item.id == id) currentjenisrab = item;
    }

    return currentjenisrab;
};

const save = () => {
    let url = $(formId).attr("action");
    const form = $(formId)[0];
    const requestBody = new FormData(form);
    const isEdit = $(modalProceedBtnId).text() === "Ubah";

    if (isEdit) requestBody.append("_method", "PATCH");

    ajax({
        type: "POST",
        url: url,
        data: requestBody,
        success: function (response) {
            if (response.status >= 200 && response.status < 300) {
                reloadTable(tableId);
                $(modalId).modal("hide");
                Toast({ title: "Berhasil", message: response.message });
            }

            if (response.status >= 400 && response.status < 500) {
                Toast({
                    title: "Berhasil",
                    message: "Data item gagal ditambakan",
                });
            }

            if (response.status === 500) {
                Toast({
                    title: "Gagal",
                    type: "error",
                    message: response.message,
                });
            }
        },
    });
};

const create = () => {
    $(modalTitleId).text(`Tambah ${menuContext}`);
    $(modalProceedBtnId).text("Tambah");
    $(formId).attr("action", storeAPI);
    $(formId).trigger("reset");
    clearValidationError();
};

const edit = (id) => {
    const currentjenisrab = getCurrentjenisrab(id);
    console.log(currentjenisrab);
    $(modalTitleId).text(`Ubah ${menuContext}`);
    $(modalProceedBtnId).text("Ubah");
    $(formId).attr("action", updateAPI + "/" + id);
    $("#jenis").val(currentjenisrab.jenis);
    clearValidationError();
};

const destroy = (id) => {
    Toast({
        timeout: 5000,
        overlay: true,
        title: "Hapus data jenisrab",
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
