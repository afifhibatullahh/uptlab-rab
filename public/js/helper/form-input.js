const InputField = ({
    type = "text",
    title = "",
    name = "",
    id = "",
    width = "col-md-12",
    autofocus = false,
    disabled = false,
    onclick = "clearValidationError(this)",
    accept = "image/jpg, image/jpeg, image/png, image/webp, image/gif",
    onchange = "",
} = {}) => {
    return `
        <div class="form-row">
            <div class="form-group ${width}">
                <label for="${name}">${title}</label>
                <input type="${type}" id="${
        id !== "" ? id : name
    }" name="${name}" onchange="${onchange}" onclick="${onclick}" class="form-control ${
        id === "custom-money" ? "input-money" : ""
    }" ${autofocus ? "autofocus" : ""} ${disabled ? "disabled" : ""}
      accept="${type === "file" ? accept : ""}">
                <div id="error-${name}" class="invalid-feedback"></div>
            </div>
        </div>
    `;
};

const Radio = ({ title = "", name = "", radioList = [] } = {}) => {
    return `
        <div class="row mb-3">
            <label class="col-form-label col-sm-4 pt-0">${title}</label>
            <div class="col-sm-8">
                <div class="row">
                ${
                    radioList !== []
                        ? radioList
                              .map(({ label, value }) => {
                                  return `
                                    <div class="form-check mr-3">
                                        <input class="form-check-input" type="radio" name="${name}" value="${value}">
                                        <label class="form-check-label" for="${name}">${label}</label>
                                    </div>
                                `;
                              })
                              .join("")
                        : null
                }
                </div>
            </div>
        </div>
    `;
};

const Dropdown = ({
    title = "",
    name = "",
    width = "",
    dropdownList = [],
    onchange = "",
    onclick = "clearValidationError(this)",
} = {}) => {
    return `
        <div class="form-group ${width}">
            <label for="${name}">${title}</label>
            <select name="${name}" id="${name}" class="form-control" onchange="${onchange}" onclick="${onclick}">
                <option value="" hidden>-- Pilih ${title} --</option>    
                ${
                    dropdownList !== []
                        ? dropdownList
                              .map(({ label, value }) => {
                                  return `
                                    <option value="${value}">${label}</option>
                                `;
                              })
                              .join("")
                        : null
                }
            </select>
            <div id="error-${name}" class="invalid-feedback"></div>
        </div>
    `;
};

const Textarea = ({
    title = "",
    name = "",
    onclick = "clearValidationError(this)",
} = {}) => {
    return `
        <div class="form-group">
            <label for="${name}">${title}</label>
            <textarea class="form-control" name="${name}" id="${name}" onclick="${onclick}" rows="5"></textarea>
            <div id="error-${name}" class="invalid-feedback"></div>
        </div>
    `;
};

const Button = ({
    type = "button",
    id = "",
    text = "",
    color = "primary",
    onclick = "",
    dataToggle = "",
    dataTarget = "",
    dataDismiss = "",
} = {}) => {
    return `<button type="${type}" id="${id}" class="btn btn-${color}" onclick="${onclick}" data-toggle="${dataToggle}" data-target="${dataTarget}" data-dismiss="${dataDismiss}">${text}</button>`;
};

const Badge = ({
    title = "",
    color = "light",
    onclick = "",
    closeIcon = false,
} = {}) => {
    return `<span class="badge badge-pill badge-${color} p-2" onclick="${onclick}" role="button" style="font-size: 12px;">${
        closeIcon ? '<span aria-hidden="true">&times;</span>' : ""
    } ${title}</span>`;
};

const ImagePreview = ({
    id = "image-preview",
    width = "80",
    height = "80",
    folder = "",
    fileName = "default.jpg",
} = {}) => {
    return `<img src="${site_url}/assets/images/${folder}/${fileName}" width="${width}" height="${height}" id="${id}" class="avatar-img rounded-circle mb-3" alt="Gambar ${folder}">`;
};

$(".input-money").mask("#.##0,00", {
    reverse: true,
});
