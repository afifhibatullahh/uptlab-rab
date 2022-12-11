const displayValidationError = (errors) => {
    for (const property in errors) {
        $(`#${property}`).addClass("is-invalid");
        $(`#error-${property}`).text(errors[property]);
        $(`#error-${property}`).removeClass("hidden");
    }
};

const clearValidationError = (input = null) => {
    if (input !== null) {
        const isInputHasValidationError = $(input).hasClass("is-invalid");
        if (isInputHasValidationError) $(input).removeClass("is-invalid");
        return;
    }

    const allInvalidInputs = $(".is-invalid");

    allInvalidInputs.each(function (index, input) {
        $(input).removeClass("is-invalid");
    });
};
