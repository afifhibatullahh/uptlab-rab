const ajax = ({
    url = "",
    data = "",
    processData = false,
    contentType = false,
    dataType = "json",
    type = "GET",
    beforeSend,
    success = function (response) {
        if (response.status >= 200 && response.status < 300) {
            Toast({ title: "Berhasil", message: response.message });
        }
        if (response.status === 403) {
            if ("error" in response) displayValidationError(response.error);
            else
                Toast({
                    title: "Warning",
                    type: "warning",
                    message: response.message,
                });
        }

        if ([404, 500].includes(response.status)) {
            Toast({
                title: "Gagal",
                type: "error",
                message: response.message,
            });
        }
    },
    error = function (event, type, message) {
        Toast({
            title: "Gagal",
            message: message,
            type: "error",
        });
    },
} = {}) => {
    return $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        type: type,
        url: url,
        cache: false,
        data: data,
        processData: processData,
        contentType: contentType,
        dataType: dataType,
        beforeSend: beforeSend,
        success: success,
        error: error,
    });
};
