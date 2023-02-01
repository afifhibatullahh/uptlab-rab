const tableId = "#table-user";
const indexAPI = `${site_url_api}/users`;
const deleteAPI = `${site_url_api}/users/delete`;
const alluser = new Set();

$(document).ready(function () {
    let columns = [
        { data: "name", title: "Nama", width: "20%" },
        {
            data: "email",
            title: "Email",
        },
        { data: "role", title: "Role", width: "30%" },
    ];

    if (isSuperAdmin) {
        columns.push({
            data: "id",
            title: "Action",
            width: "20%",
            searchable: false,
            orderable: false,
            render: function (id, type, user) {
                alluser.add(user);

                return `
                  ${Button({
                      text: "Hapus",
                      color: "danger btn-sm",
                      onclick: `destroy(${id})`,
                  })}
              `;
            },
        });
    }
    const tableuser = initializeDatatables(tableId, indexAPI, columns);
});

const getCurrentuser = (id) => {
    let currentuser;

    for (const user of alluser) {
        if (user.id == id) currentuser = user;
    }

    return currentuser;
};

const destroy = (id) => {
    Toast({
        timeout: 5000,
        overlay: true,
        title: "Hapus data user",
        message: "Apakah anda yakin?",
        position: "center",
        type: "question",
        buttons: [
            [
                "<button><b>YES</b></button>",
                function (instance, toast) {
                    $.ajax({
                        type: "POST",
                        url: deleteAPI + "/" + id,
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
                                message: `user ${message}`,
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
