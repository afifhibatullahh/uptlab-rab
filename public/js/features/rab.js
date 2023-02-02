const menuContext = "Rencana Anggaran Belanja";
const tableId = "#table-rab";
const formId = "#form-status";
const indexAPI = `${site_url_api}/rab`;
const deleteAPI = `${site_url_api}/rab/delete`;
const updateAPI = `${site_url_api}/rab/updatestatus`;
const allItem = new Set();

const modalStatus = "#modal-status";
const modalId = "#modal";
const modalProceedBtnId = "#modalProceedBtnId";

$(document).ready(function () {
    let columns = [
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
                    ${Button({
                        text: "Detail",
                        color: "info btn-sm",
                        onclick: `detail(${id})`,
                    })}
                `;
            },
        },
        { data: "nomor_akun", title: "Nomor Akun" },
    ];
    if (isSuperAdmin) {
        columns.push(
            {
                data: "status",
                title: "Status",
                render: (id, type, item) => {
                    const color = {
                        pending: "info",
                        accepted: "success",
                        rejected: "danger",
                        update: "warning",
                    };
                    return `${Button({
                        text: item.status,
                        color: `${color[item.status]} btn-sm `,
                        onclick: `changeStatus(${item.id})`,
                        dataToggle: "modal",
                        dataTarget: modalId,
                    })}
                `;
                },
            },
            { data: "jenis", title: "Jenis" },
            { data: "waktu_pelaksanaan", title: "Waktu Pelaksanaan " }
        );
    } else {
        columns.push(
            {
                data: "status",
                title: "Status",
            },
            { data: "jenis", title: "Jenis" },
            { data: "waktu_pelaksanaan", title: "Waktu Pelaksanaan " }
        );
    }

    const tableItem = initializeDatatables(tableId, indexAPI, columns, {
        userId: userId,
    });

    $(modalStatus).append(
        `${ModalPlain({
            body: `
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-body">
                                <form id="${formId.slice(1)}">
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
    ${Dropdown({
        title: "Status",
        name: "status",
        dropdownList: [
            {
                label: "Pending",
                value: "pending",
            },
            {
                label: "Accepted",
                value: "accepted",
            },
            {
                label: "Rejected",
                value: "rejected",
            },
            {
                label: "Update",
                value: "update",
            },
        ],
    })}
    ${Button({
        text: "Ubah",
        id: modalProceedBtnId.slice(1),
        onclick: "updateStatus()",
    })}
    ${Button({ text: "Cancel", dataDismiss: "modal", color: "danger" })}
`);
});

const getCurrentStatus = (id) => {
    let currentStatus;

    for (const item of allItem) {
        if (item.id == id) currentStatus = item;
    }

    return currentStatus;
};

const changeStatus = (id) => {
    const currentStatus = getCurrentStatus(id);
    $(formId).attr("action", updateAPI + "/" + id);
    $(`option[value=${currentStatus.status}]`).prop("selected", true);
    clearValidationError();
};

function detail(id) {
    window.location.replace(site_url + "/rab/" + id);
}

function edit(id) {
    location.href = `${site_url}/rab/edit/${id}`;
}

const getCurrentrab = (id) => {
    let currentrab;

    for (const item of allItem) {
        if (item.id == id) currentrab = item;
    }

    return currentrab;
};

const updateStatus = async () => {
    let url = $(formId).attr("action");
    const form = $(formId)[0];
    const requestBody = new FormData(form);

    requestBody.append("_method", "PATCH");
    $(modalProceedBtnId).attr("disabled", true);

    await ajax({
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
                    message: "Update Status Berhasil",
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

    $(modalProceedBtnId).attr("disabled", false);
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
