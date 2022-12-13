const menuContext = "Item";
const tableId = "#table-rabdetail";
const formId = "#form-rabdetail";

const modalId = "#modal";
const modalTitleId = "#modal-title";
const modalProceedBtnId = "#modal-proceed-btn";
const modalContainerId = "#modal-rabdetail";

const dataItem = [];

const product = [
    {
        item_id: 1,
        nama_barang: "ads",
        harga: 2000,
        unit: "pcs",
        jenis: "Kimia",
    },
    {
        item_id: 2,
        nama_barang: "makan",
        harga: 3000,
        unit: "pcs",
        jenis: "Kimia",
    },
    {
        item_id: 3,
        nama_barang: "pood",
        harga: 50000,
        unit: "pcs",
        jenis: "Kimia",
    },
];

let rowData = {
    nama_barang: "",
    jumlah: "",
    satuan: "",
    price: "0",
    netamount: "",
    tax: "",
    jenis: "",
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
                        onclick: `edit(${item.item_id})`,
                        dataToggle: "modal",
                        dataTarget: modalId,
                    })}
                    ${Button({
                        text: "Hapus",
                        color: "danger btn-sm",
                        onclick: `destroy(${item.item_id})`,
                    })}
                `;
            },
        },
        { data: "nama_barang", title: "Nama Barang" },
        { data: "jumlah", title: "Jumlah" },
        { data: "satuan", title: "Satuan" },
        { data: "price", title: "Harga Satuan(Rp)" },
        { data: "netamount", title: "Jumlah Harga" },
        { data: "jenis", title: "Jenis Barang" },
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
            dropdownList: [
                {
                    label: "ads",
                    value: 1,
                },
                {
                    label: "makan",
                    value: 2,
                },
                {
                    label: "pood",
                    value: 3,
                },
            ],
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
        ${InputField({
            title: "Qty",
            type: "number",
            name: "jumlah",
            id: "purchaseqty",
        })}
        <h6>Harga Barang : <span id="price">0</span></h6>
        <h6>Pembelian : <span id="pembelian">0</span></h6>
        <h6>Pajak : <span id="taxtotal">0</span></h6>
        <h5>Total Harga : <span id="netamount">0</span></h5>
    `);

const totalPajak = $("#taxtotal");
const totalAmount = $("#netamount");
const purchaseQty = $("#purchaseqty");
const pembelian = $("#pembelian");
const taxSelected = $("#tax");

$("#filter_item").on("change", function () {
    let selectedVal = $(this).find(":selected").val();

    const item = product.find((item) => item.item_id == selectedVal);

    const formValues = getFormValues();
    rowData = {
        ...rowData,
        ...formValues,
        nama_barang: item.nama_barang,
        satuan: item.unit,
        price: item.harga,
        jenis: item.jenis,
        item_id: item.item_id,
    };

    rowData = setTotalItem(rowData);
});

purchaseQty.on("input", function (e) {
    const qtyVal = $(this).val();

    rowData = { ...rowData, jumlah: Number(qtyVal) };

    rowData = setTotalItem(rowData);
});

taxSelected.on("change", function () {
    let selectedVal = $(this).find(":selected").val();

    rowData = { ...rowData, tax: Number(selectedVal) };

    rowData = setTotalItem(rowData);
});

const setTotalItem = (datas) => {
    $("#price").html(`${datas.price}`);
    const totalPembelian = Number(datas.price ?? 0) * Number(datas.jumlah);

    pembelian.html(`${totalPembelian}`);

    const pajak =
        datas.tax == 0 ? 0 : (Number(datas.tax) / 100) * totalPembelian;

    totalPajak.html(`${pajak}`);

    const amount = totalPembelian - pajak;

    totalAmount.html(`${amount}`);

    return (datas = {
        ...datas,
        netamount: amount,
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
                message: "Item Gagal ditambahkan",
            };
        }
    }

    dataItem.forEach((item) => {
        if (rowData.item_id == productTemp);
        else if (item.item_id == rowData.item_id) {
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
            objIndex = dataItem.findIndex(
                (obj) => obj.item_id == rowData.item_id
            );
            if (objIndex < 0) return;
            dataItem[objIndex] = rowData;
            tableItem.row(objIndex).data(rowData).draw();
        }
        $(modalId).modal("hide");

        Toast({
            title: "Berhasil",
            message: "Item Berhasil ditambahkan",
        });
        resetRowDataValues();
    } else {
        Toast({
            title: "Gagal",
            type: "error",
            message: validation.message,
        });
    }
    console.log(dataItem);
};

const getCurrentItem = (id) => {
    let currentItem;

    for (const item of dataItem) {
        if (item.item_id == id) currentItem = item;
    }

    return currentItem;
};

const edit = (id) => {
    const currentItem = getCurrentItem(id);

    console.log(currentItem);
    $(modalTitleId).text(`Ubah ${menuContext}`);
    $(modalProceedBtnId).text("Ubah");
    $("#purchaseqty").val(currentItem.jumlah);
    $(`option[value=${currentItem.tax}]`).prop("selected", true);
    $(`option[value=${currentItem.item_id}]`).prop("selected", true);
    const item = product.find((item) => item.item_id == id);
    productTemp = id;
    rowData = {
        ...rowData,
        nama_barang: item.nama_barang,
        satuan: item.unit,
        price: item.harga,
        jumlah: currentItem.jumlah,
        tax: currentItem.tax,
        netamount: currentItem.netamount,
        jenis: item.jenis,
        item_id: item.item_id,
    };

    setTotalItem(rowData);
    console.log(rowData);
    // clearValidationError();
};

const getFormValues = () => {
    const form = $(formId)[0];
    const requestBody = new FormData(form);

    const formValues = {
        nama_barang: requestBody.get("nama_barang"),
        jumlah: requestBody.get("jumlah"),
        tax: requestBody.get("tax"),
    };

    return formValues;
};

const resetRowDataValues = () => {
    rowData = {
        nama_barang: "",
        jumlah: "",
        satuan: "",
        netamount: "",
        tax: "",
        jenis: "",
        price: "0",
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

                    objIndex = dataItem.findIndex((obj) => obj.item_id == id);

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
