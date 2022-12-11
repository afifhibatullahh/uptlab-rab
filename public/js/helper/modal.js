const Modal = ({
    title = "",
    body = "Content goes here",
    id = "modal",
    size = "md",
    footer = {
        close: "Cancel",
        proceed: "Save",
    },
} = {}) => {
    return `
        <div>
            <div class="modal fade" id="${id}" tabindex="-1" role="dialog" aria-labelledby="${id}Title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-${size}" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="${id}Title">${title}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">${body}</div>
                        <div class="modal-footer">
                            <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">${footer.close}</button>
                            <button type="button" class="btn mb-2 btn-primary">${footer.proceed}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
};

const ModalPlain = ({
    body = "Content goes here",
    id = "modal",
    size = "md",
} = {}) => {
    return `
       <div class="modal fade" id="${id}" tabindex="-1" role="dialog" aria-labelledby="${id}Title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-${size}" role="document">
                <div class="modal-content">
                    <div class="modal-body">${body}</div>
                </div>
            </div>
        </div>
    `;
};
