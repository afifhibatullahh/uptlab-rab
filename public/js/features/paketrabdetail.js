function getPaketRab() {
    const data = tableItem.rows().data();

    const form = $("#formpaket");

    const requestBody = new FormData(form[0]);

    let paketrabdetail = [];

    data.map((item) => {
        paketrabdetail.push(item);
    });

    let paketrab = {
        title: "",
        nomor_akun: "",
        jenis_pengadaan: "",
        waktu_pelaksanaan: "",
    };
    for (let data of requestBody) {
        paketrab[data[0]] = data[1];
    }

    return {
        paketrab: paketrab,
        paketrabdetail: paketrabdetail,
    };
}

function savePaketRabDetail() {
    const data = getPaketRab();

    ajax({
        type: "POST",
        url: `${site_url_api}/paketrab/store`,
        data: JSON.stringify(data),
        success: function (response) {
            if (response.status >= 200 && response.status < 300) {
                $(modalId).modal("hide");
                Toast({ title: "Berhasil", message: response.message });
                location.href = `${site_url}/paketrab/${response.id}`;
            }

            if (response.status >= 400 && response.status < 500) {
                Toast({
                    title: "Berhasil",
                    message: "Paket RAB gagal ditambakan",
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
    const data = getPaketRab();

    ajax({
        type: "PATCH",
        url: `${site_url_api}/paketrab/update/${id}`,
        data: JSON.stringify(data),
        success: function (response) {
            if (response.status >= 200 && response.status < 300) {
                $(modalId).modal("hide");
                Toast({ title: "Berhasil", message: response.message });
                location.href = `${site_url}/paketrab/${response.id}`;
            }

            if (response.status >= 400 && response.status < 500) {
                Toast({
                    title: "Berhasil",
                    message: "Paket RAB gagal diubah",
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
