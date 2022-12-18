const menuContext = "Item";
const tableId = "#table-rabdetail";
const formId = "#form-rabdetail";

const modalId = "#modal";
const modalTitleId = "#modal-title";
const modalProceedBtnId = "#modal-proceed-btn";
const modalContainerId = "#modal-rabdetail";

const dataItem =
    rabdetails.map((item) => {
        return {
            nama_barang: item.nama_barang,
            qty: item.qty,
            satuan: item.satuan,
            harga_satuan: item.harga_satuan,
            jumlah_harga: item.jumlah_harga,
            tax: item.pajak,
            jenis_item: item.jenis_item,
            id: item.id_item,
        };
    }) ?? [];

const product = listItems;

dropdownList = product.map((item) => {
    return {
        label: item.nama_barang,
        value: item.id,
    };
});

let rowData = {
    nama_barang: "",
    qty: "",
    satuan: "",
    harga_satuan: "0",
    jumlah_harga: "",
    tax: "",
    jenis_item: "",
};

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
        { data: "nama_barang", title: "Nama Barang" },
        { data: "qty", title: "Jumlah" },
        { data: "satuan", title: "Satuan" },
        {
            data: "harga_satuan",
            title: "Harga Satuan(Rp)",
            render: $.fn.dataTable.render.number(".", ",", 2),
        },
        {
            data: "jumlah_harga",
            title: "Jumlah Harga",
            render: $.fn.dataTable.render.number(".", ",", 2),
        },
        { data: "jenis_item", title: "Jenis Item" },
        { data: "tax", title: "Pajak (%)" },
    ],
    dataItem
);

tableItem.on("click", "tr", function (event) {
    let itemId = tableItem.row(this).data();
    const isClickedOnActionsButton = $(event.target)
        .parent()
        .hasClass("sorting_1");
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
        ${Dropdown({
            title: "Nama Barang",
            name: "nama_barang",
            id: "filter_item",
            dropdownList: dropdownList,
        })}
      
        ${Dropdown({
            title: "Pajak",
            name: "tax",
            dropdownList: [
                {
                    label: "Non Pajak",
                    value: 0,
                },
                {
                    label: "PPN",
                    value: 11,
                },
            ],
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
            onclick: "resetRowDataValues()",
        })}
    `);

$("#form-item-right-section").append(`
        ${InputFieldAdorment({
            title: "Qty",
            type: "number",
            name: "qty",
            idAdorment: "satuanAdorment",
        })}
        <h6>Harga Barang : <span id="harga_satuan">0</span></h6>
        <h6>Pembelian : <span id="pembelian">0</span></h6>
        <h6>Pajak : <span id="taxtotal">0</span></h6>
        <h5>Total Harga : <span id="jumlah_harga">0</span></h5>
    `);

const totalPajak = $("#taxtotal");
const totalAmount = $("#jumlah_harga");
const qty = $("#qty");
const pembelian = $("#pembelian");
const taxSelected = $("#tax");

$("#filter_item").on("change", function () {
    let selectedVal = $(this).find(":selected").val();

    const item = product.find((item) => item.id == selectedVal);

    const formValues = getFormValues();
    rowData = {
        ...rowData,
        ...formValues,
        nama_barang: item.nama_barang,
        satuan: item.satuan,
        harga_satuan: item.harga_satuan,
        jenis_item: item.jenis,
        id: item.id,
    };

    console.log(rowData);
    rowData = setTotalItem(rowData);
});

qty.on("input", function (e) {
    const qtyVal = $(this).val();

    rowData = { ...rowData, qty: Number(qtyVal) };

    rowData = setTotalItem(rowData);
});

taxSelected.on("change", function () {
    let selectedVal = $(this).find(":selected").val();

    rowData = { ...rowData, tax: Number(selectedVal) };

    rowData = setTotalItem(rowData);
});

const setTotalItem = (datas) => {
    $("#harga_satuan").text(`${datas.harga_satuan}`);
    $("#satuanAdorment").text(`${datas.satuan}`);
    const totalPembelian = Number(datas.harga_satuan ?? 0) * Number(datas.qty);

    pembelian.text(`${totalPembelian}`);

    const pajak =
        datas.tax == 0 ? 0 : (Number(datas.tax) / 100) * totalPembelian;

    totalPajak.text(`${pajak}`);

    const amount = totalPembelian + pajak;

    totalAmount.text(`${amount}`);

    return (datas = {
        ...datas,
        jumlah_harga: amount,
    });
};

let productTemp;

const addItem = () => {
    $(modalTitleId).text(`Tambah ${menuContext}`);
    $(modalProceedBtnId).text("Tambah");
    $(formId).trigger("reset");
    resetRowDataValues();
    setTotalItem(rowData);
};

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

    for (let key in rowData) {
        if (key == "tax") continue;
        if (rowData[key] == "") {
            validation = {
                isValidate: false,
                message: `Item Gagal ${isEdit ? "diubah" : "ditambahkan"}`,
            };
        }
    }

    dataItem.forEach((item) => {
        if (rowData.id == productTemp);
        else if (item.id == rowData.id) {
            validation = {
                isValidate: false,
                message: "Item sudah terdapat dalam list tabel!",
            };
            return;
        }
    });

    if (validation.isValidate) {
        if (!isEdit) {
            dataItem.push(rowData);
            tableItem.rows.add([rowData]).draw();
        } else {
            objIndex = dataItem.findIndex((obj) => obj.id == productTemp);
            // if (objIndex < 0) return;
            dataItem[objIndex] = rowData;
            tableItem.row(objIndex).data(rowData).draw();
        }
        $(modalId).modal("hide");

        Toast({
            title: "Berhasil",
            message: `Item Berhasil ${isEdit ? "diubah" : "ditambahkan"}`,
        });
        resetRowDataValues();
    } else {
        Toast({
            title: "Gagal",
            type: "error",
            message: validation.message,
        });
    }
};

const getCurrentItem = (id) => {
    let currentItem;

    for (const item of dataItem) {
        if (item.id == id) currentItem = item;
    }

    return currentItem;
};

const edit = (id) => {
    const currentItem = getCurrentItem(id);

    $(modalTitleId).text(`Ubah ${menuContext}`);
    $(modalProceedBtnId).text("Ubah");
    $("#qty").val(currentItem.qty);
    $(`option[value=${currentItem.tax}]`).prop("selected", true);
    $(`option[value=${currentItem.id}]`).prop("selected", true);
    const item = product.find((item) => item.id == id);

    productTemp = id;
    rowData = {
        ...rowData,
        nama_barang: item.nama_barang,
        satuan: item.satuan,
        harga_satuan: item.harga_satuan,
        qty: currentItem.qty,
        tax: currentItem.tax,
        jumlah_harga: currentItem.jumlah_harga,
        jenis_item: item.jenis,
        id: item.id,
    };

    setTotalItem(rowData);
    // clearValidationError();
};

const getFormValues = () => {
    const form = $(formId)[0];
    const requestBody = new FormData(form);

    const formValues = {
        nama_barang: requestBody.get("nama_barang"),
        qty: requestBody.get("qty"),
        tax: requestBody.get("tax"),
    };

    return formValues;
};

const resetRowDataValues = () => {
    rowData = {
        nama_barang: "",
        qty: "",
        satuan: "",
        jumlah_harga: "",
        tax: "",
        jenis_item: "",
        harga_satuan: "0",
    };
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

                    objIndex = dataItem.findIndex((obj) => obj.id == id);

                    if (objIndex < 0) {
                        Toast({
                            title: "Gagal",
                            type: "error",
                            message: "Item Gagal ditambahkan",
                        });
                        return;
                    }

                    dataItem.splice(objIndex, 1);

                    tableItem.row(objIndex).remove().draw();
                    $(modalId).modal("hide");

                    Toast({
                        title: "Berhasil",
                        message: "Item Berhasil ditambahkan",
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
