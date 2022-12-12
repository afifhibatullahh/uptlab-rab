const menuContext = "Item";
const tableId = "#table-rabdetail";
const formId = "#form-rabdetail";

const modalId = "#modal";
const modalTitleId = "#modal-title";
const modalProceedBtnId = "#modal-proceed-btn";
const modalContainerId = "#modal-rabdetail";

const allItem = new Set();

const dataItem = [
    {
        nama_barang: "vasdf",
        jumlah: "2",
        satuan: "sf",
        price: "3434",
        amount_price: "3434",
        jenis: "df",
        tax: "11",
        id: 1,
    },
];

$(document).ready(function () {
    const tableItem = initializeDatatablesFromArray(
        tableId,
        [
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
            { data: "nama_barang", title: "Nama Barang" },
            { data: "jumlah", title: "Jumlah" },
            { data: "satuan", title: "Satuan" },
            { data: "price", title: "Harga Satuan(Rp)" },
            { data: "amount_price", title: "Jumlah Harga" },
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

        console.log(tableItem.row(this).data());
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
                            )}" action="/" enctype="multipart/form-data">
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
            dropdownList: [
                {
                    label: "ads",
                    value: 1,
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
        ${Button({ text: "Cancel", dataDismiss: "modal", color: "danger" })}
    `);

    $("#form-item-right-section").append(`
        ${InputField({
            title: "Qty",
            type: "number",
            name: "jumlah",
        })}
        <h6 id="taxtotal">Pajak : xxx</h6>
        <h5 id="netamount">Total Harga : xxx</h5>
    `);
});

const getCurrentItem = (id) => {
    let currentItem;

    for (const item of allItem) {
        if (item.id == id) currentItem = item;
    }

    return currentItem;
};

const save = () => {
    const form = $(formId)[0];
    const isEdit = $(modalProceedBtnId).text() === "Ubah";
    const requestBody = new FormData(form);
    console.log(requestBody, form);
};

const edit = (id) => {
    const currentItem = getCurrentItem(id);
    $(modalTitleId).text(`Ubah ${menuContext}`);
    $(modalProceedBtnId).text("Ubah");
    $("#nama_barang").val(currentItem.nama_barang);
    $("#jumlah").val(currentItem.jumlah);
    $(`option[value=${currentItem.tax}]`).prop("selected", true);

    clearValidationError();
};
