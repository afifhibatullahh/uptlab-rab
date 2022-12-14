function saveRabDetail() {
    const data = tableItem.rows().data();

    const form = $("#formrab");

    const requestBody = new FormData(form[0]);

    let rabdetail = [],
        jumlah = 0;
    data.map((item) => {
        rabdetail.push(item);
        jumlah += Number(item.netamount);
    });

    let rab = {
        title: "",
        nomor_akun: "",
        jenis: "",
        waktu_pelaksanaan: "",
        jumlah: jumlah,
    };
    for (let data of requestBody) {
        rab[data[0]] = data[1];
    }

    ajax({
        type: "POST",
        url: `${site_url_api}/rab/store`,
        data: JSON.stringify({
            rab: rab,
            rabdetail: rabdetail,
        }),
        success: function (response) {
            if (response.status >= 200 && response.status < 300) {
                reloadTable(tableId);
                $(modalId).modal("hide");
                Toast({ title: "Berhasil", message: response.message });
            }

            if (response.status >= 400 && response.status < 500) {
                Toast({
                    title: "Berhasil",
                    message: "RAB gagal ditambakan",
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
}
