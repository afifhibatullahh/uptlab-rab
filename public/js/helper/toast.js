iziToast.settings({
    timeout: 2000,
    resetOnHover: true,
    position: "topRight",
});

const Toast = ({
    title = "",
    message = "",
    type = "success",
    ...parameters
} = {}) => {
    iziToast?.[type]({
        title: title,
        message: message,
        ...parameters,
    });
};
