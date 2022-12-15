function getDataRab() {
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

    return {
        rab: rab,
        rabdetail: rabdetail,
    };
}

function saveRabDetail() {
    const data = getDataRab();

    ajax({
        type: "POST",
        url: `${site_url_api}/rab/store`,
        data: JSON.stringify(data),
        success: function (response) {
            if (response.status >= 200 && response.status < 300) {
                $(modalId).modal("hide");
                Toast({ title: "Berhasil", message: response.message });
                location.href = `${site_url}/rab/${response.id}`;
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

function editRabDetail(id) {
    const data = getDataRab();

    ajax({
        type: "PATCH",
        url: `${site_url_api}/rab/update/${id}`,
        data: JSON.stringify(data),
        success: function (response) {
            if (response.status >= 200 && response.status < 300) {
                $(modalId).modal("hide");
                Toast({ title: "Berhasil", message: response.message });
                location.href = `${site_url}/rab/${response.id}`;
            }

            if (response.status >= 400 && response.status < 500) {
                Toast({
                    title: "Berhasil",
                    message: "RAB gagal diubah",
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
