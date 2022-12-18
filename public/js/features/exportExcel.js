async function exportExcel() {
    await ajax({
        type: "POST",
        url: `${site_url_api}/rab/exportrab`,
        data: JSON.stringify(rab),
        success: function (response) {
            if (response.status >= 200 && response.status < 300) {
                Toast({ title: "Berhasil", message: response.message });
                location.href = `${site_url}/${response.data}`;
                // console.log(`${site_url}/${response.data}`);
            }

            if (response.status >= 400 && response.status < 500) {
                Toast({
                    title: "Error",
                    message: "Proses export gagal",
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

async function exportPaketExcel() {
    await ajax({
        type: "POST",
        url: `${site_url_api}/paketrab/exportpaketrab`,
        data: JSON.stringify(dataPaket),
        success: function (response) {
            if (response.status >= 200 && response.status < 300) {
                Toast({ title: "Berhasil", message: response.message });
                location.href = `${site_url}/${response.data}`;
                // console.log(`${site_url}/${response.data}`);
            }

            if (response.status >= 400 && response.status < 500) {
                Toast({
                    title: "Error",
                    message: "Proses export gagal",
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
