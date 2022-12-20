const menuContext = "Jenis RAB";
const tableId = "#table-paketrabdetail";
const formId = "#form-paketrabdetail";
console.log("testes");
const modalId = "#modal";
const modalTitleId = "#modal-title";
const modalProceedBtnId = "#modal-proceed-btn";
const modalContainerId = "#modal-paketrabdetail";

let rowData = {
    title: "",
    jenis_rab: "",
    nomor_akun: "",
    laboratorium: "",
    waktu_pelaksanaan: "",
};

dropdownList = listRabs.map((item) => {
    return {
        label: item.title,
        value: item.id,
    };
});

const dataRab =
    paketrabdetails.map((item) => {
        return {
            ...item,
            tanggal: item.waktu_pelaksanaan,
        };
    }) ?? [];

const tableItem = initializeDatatablesFromArray(
    tableId,
    [
        {
            data: "id",
            title: "Actions",
            searchable: false,
            orderable: false,
            render: function (id, type, item) {
                return `
                        ${Button({
                            text: "Edit",
                            color: "warning btn-sm",
                            onclick: `edit(${item.id})`,
                            dataToggle: "modal",
                            dataTarget: modalId,
                        })}
                        ${Button({
                            text: "Hapus",
                            color: "danger btn-sm",
                            onclick: `destroy(${item.id})`,
                        })}
                    `;
            },
        },
        { data: "title", title: "Judul" },
        { data: "jenis_rab", title: "Jenis" },
        { data: "nomor_akun", title: "Nomor Akun" },
        {
            data: "laboratorium",
            title: "Laboratorium",
        },
        { data: "tanggal", title: "Tanggal" },
    ],
    dataRab
);

tableItem.on("click", "tr", function (event) {
    let itemId = tableItem.row(this).data();
    const isClickedOnActionsButton = $(event.target)
        .parent()
        .hasClass("sorting_1");

    console.log(itemId);
});

const addRab = () => {
    console.log("test");
    $(modalTitleId).text(`Tambah ${menuContext}`);
    $(modalProceedBtnId).text("Tambah");
    $(formId).trigger("reset");
    resetRowDataPaket();
    setRowData(rowData);
};

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
                                <form id="${formId.slice(1)}">
                                    <div class="row">
                                        <div id="form-item-left-section" class="col-md-6"></div>
                                        <div id="form-item-right-section" class="col-md-6"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>`,
        size: "lg",
    })}`
);

$("#form-item-left-section").append(`
        ${Select2K({
            title: "Judul Pengadaan",
            name: "id_rab",
            id: "filter_rab",
            dropdownList: dropdownList,
        })}

        ${Button({
            text: "Tambah",
            id: modalProceedBtnId.slice(1),
            onclick: "save()",
        })}
        ${Button({
            text: "Cancel",
            dataDismiss: "modal",
            color: "danger",
            onclick: "()",
        })}
    `);

$(".select2").select2({
    theme: "bootstrap4",
});

$("#form-item-right-section").append(`
        <p>Jenis : <span id="jenis"></span></p>
        <p>Nomor Akun : <span id="akun"></span></p>
        <p>Laboratorium : <span id="laboratorium"></span></p>
        <p>Tanggal : <span id="tanggal"></span></p>
    `);

$("#filter_rab").on("change", function () {
    let selectedVal = $(this).find(":selected").val();

    const rab = listRabs.find((rab) => rab.id == selectedVal);
    setRowData(rab);
});

let tempRab;

const setRowData = (data) => {
    $("#jenis").text(data.jenis_rab);
    $("#akun").text(data.nomor_akun);
    $("#laboratorium").text(data.laboratorium);
    $("#tanggal").text(data.tanggal);

    rowData = {
        title: data.title,
        jenis_rab: data.jenis_rab,
        nomor_akun: data.nomor_akun,
        laboratorium: data.laboratorium,
        tanggal: data.tanggal,
        id: data.id,
    };
};

const resetRowDataPaket = () => {
    rowData = {
        title: "",
        jenis_rab: "",
        nomor_akun: "",
        laboratorium: "",
        tanggal: "",
        id: "",
    };
};

function getCurrentRab(id) {
    let currentRab;

    for (const item of dataRab) {
        if (item.id == id) currentRab = item;
    }

    return currentRab;
}

$("form").on("submit", function (e) {
    save();
    e.preventDefault();
});

const save = () => {
    let validation = {
        isValidate: true,
        message: "",
    };

    const isEdit = $(modalProceedBtnId).text() === "Ubah";
    dataRab.forEach((item) => {
        if (rowData.id == tempRab) console.log("tes");
        else if (item.id == rowData.id) {
            validation = {
                isValidate: false,
                message: "Rab sudah terdapat dalam list tabel!",
            };
            return;
        }
    });

    if (validation.isValidate) {
        if (!isEdit) {
            dataRab.push(rowData);
            tableItem.rows.add([rowData]).draw();
        } else {
            objIndex = dataRab.findIndex((obj) => obj.id == tempRab);
            // if (objIndex < 0) return;
            dataRab[objIndex] = rowData;
            tableItem.row(objIndex).data(rowData).draw();
        }
        $(modalId).modal("hide");

        Toast({
            title: "Berhasil",
            message: `Item Berhasil ${isEdit ? "diubah" : "ditambahkan"}`,
        });
        resetRowDataPaket();
    } else {
        Toast({
            title: "Gagal",
            type: "error",
            message: validation.message,
        });
    }
};

const edit = (id) => {
    const currentRab = getCurrentRab(id);

    $(modalTitleId).text(`Ubah ${menuContext}`);
    $(modalProceedBtnId).text("Ubah");
    $(`option[value=${currentRab.id}]`).prop("selected", true);
    const rab = listRabs.find((item) => item.id == id);
    tempRab = id;
    setRowData(rab);
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
                    instance.hide(
                        { transitionOut: "fadeOut" },
                        toast,
                        "button"
                    );

                    objIndex = dataRab.findIndex((obj) => obj.id == id);

                    if (objIndex < 0) {
                        Toast({
                            title: "Gagal",
                            type: "error",
                            message: "RAB Gagal dihapus",
                        });
                        return;
                    }

                    dataRab.splice(objIndex, 1);

                    tableItem.row(objIndex).remove().draw();
                    $(modalId).modal("hide");

                    Toast({
                        title: "Berhasil",
                        message: "RAB Berhasil dihapus",
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
