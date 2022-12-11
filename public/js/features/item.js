const menuContext = "Item";
const tableId = "#table-item";
const formId = "#form-item";
const indexAPI = `${site_url_api}/items`;
const allItem = new Set();

const modalId = "#modal";
const modalTitleId = "#modal-title";
const modalProceedBtnId = "#modal-proceed-btn";
const modalContainerId = "#modal-item";

const listSatuan = [
    {
        label: "PCS",
        value: "PCS",
    },
    {
        label: "Box",
        value: "Box",
    },
    {
        label: "LUSIN",
        value: "LUSIN",
    },
];

const listJenis = [
    {
        label: "Bahan Kimia",
        value: "Bahan Kimia",
    },
    {
        label: "Bahan Rumah Tangga",
        value: 2,
    },
    {
        label: "ATK dan Studio",
        value: 3,
    },
    {
        label: "Bahan Elektrikal",
        value: 4,
    },
    {
        label: "Bahan Bangunan",
        value: 5,
    },
];

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
        { data: "nama_barang", title: "Nama" },
        { data: "jenis", title: "Jenis" },
        { data: "satuan", title: "Satuan" },
        { data: "spesifikasi", title: "Spesifikasi" },
    ]);

    tableItem.on("click", "tr", function (event) {
        let itemId = tableItem.row(this).data().id;
        const isClickedOnActionsButton = $(event.target)
            .parent()
            .hasClass("sorting_1");

        console.log(isClickedOnActionsButton);
        if (!isClickedOnActionsButton) {
            window.location.replace(site_url + "/items/show/" + itemId);
        }
    });

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
            size: "xl",
        })}`
    );

    $("#form-item-left-section").append(`
        ${InputField({ title: "Nama", name: "nama_barang" })}
        ${Textarea({ title: "Spesifikasi", name: "spesifikasi" })}
        ${InputField({
            title: "Harga",
            type: "number",
            name: "harga",
            width: "col-md-4",
        })}
        ${Dropdown({
            title: "Satuan",
            name: "satuan",
            dropdownList: listSatuan,
        })}
        ${Button({
            text: "Tambah",
            id: modalProceedBtnId.slice(1),
            onclick: "save()",
        })}
        ${Button({ text: "Cancel", dataDismiss: "modal", color: "danger" })}
    `);

    $("#form-item-right-section").append(`
        ${InputField({
            title: "Sumber",
            name: "sumber",
        })}
        ${Dropdown({
            title: "Jenis",
            name: "jenis",
            dropdownList: listJenis,
        })}
        ${ImagePreview({ folder: "item" })}
        ${InputField({
            title: "Gambar",
            name: "gambar",
            type: "file",
            onchange: "previewImage(this)",
        })}
    `);
});

const getCurrentItem = (id) => {
    let currentItem;

    for (const item of allItem) {
        if (item.id == id) currentItem = item;
    }

    return currentItem;
};

const previewImage = (fileInput) => {
    const image = $(fileInput)[0];
    const imagePreviewContainer = $("#image-preview")[0];
    const fileReader = new FileReader();

    if (image.files[0]) {
        fileReader.readAsDataURL(image.files[0]);
        fileReader.onload = function (event) {
            imagePreviewContainer.src = event.target.result;
        };
    } else {
        imagePreviewContainer.src = "#";
    }
};

const save = () => {
    const url = $(formId).attr("action");
    const form = $(formId)[0];
    const requestBody = new FormData(form);
    const isEdit = $(modalProceedBtnId).text() === "Ubah";

    if (isEdit) requestBody.append("_method", "PATCH");

    ajax({
        type: "POST",
        url: url,
        data: requestBody,
        success: function (response) {
            console.log(response);
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
    $(formId).attr("action", indexAPI);
    $(formId).trigger("reset");
    $("#image-preview").attr(
        "src",
        site_url + "assets/images/item/default.jpg"
    );
    clearValidationError();
    if (listSatuan.length === 0)
        displayValidationError({
            id_satuan: "Data Satuan masih kosong, silahkan isi terlebih dahulu",
        });
};

const edit = (id) => {
    const currentItem = getCurrentItem(id);
    console.log(currentItem);
    $(modalTitleId).text(`Ubah ${menuContext}`);
    $(modalProceedBtnId).text("Ubah");
    $("#nama_barang").val(currentItem.nama_barang);
    $("#spesifikasi").val(currentItem.spesifikasi);
    $("#harga").val(currentItem.harga);
    $("#sumber").val(currentItem.sumber);
    $(`option[value=${currentItem.satuan}]`).prop("selected", true);
    $(`option[value=${currentItem.jenis}]`).prop("selected", true);
    $("#form-item").attr("action", indexAPI + id);
    $("#image-preview").attr(
        "src",
        site_url + "/assets/images/item/" + currentItem.gambar
    );
    console.log(site_url + "/assets/images/item/" + currentItem.gambar);
    clearValidationError();
};

const destroy = (id) => {
    Toast({
        timeout: 5000,
        overlay: true,
        title: "Hapus data item",
        message: "Apakah anda yakin?",
        position: "center",
        type: "question",
        buttons: [
            [
                "<button><b>YES</b></button>",
                function (instance, toast) {
                    $.ajax({
                        type: "POST",
                        url: indexAPI + id,
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
