import Swal from "sweetalert2";
import Vts from "vts.js";

Vts.setDefaults({
    class: {
        // form: " ",
        invalid: "v-input--error",
        // valid: " ",
    },
    handlers: {
        invalid: showFeedback,
        valid: showFeedback,
    },
    ajax: {
        request: {
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        },
        beforeSend: (requestInit, abortController, form) => {
            form.querySelector('[type="submit"]').disabled = true;
            Swal.fire({
                title: "Saving...",
                icon: "info",
                text: "Please wait.",
                // allowOutsideClick: false,
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.cancel) {
                    abortController.abort();
                }
            });
        },
        success: (data, response, form) => {
            const isDataObj = typeof data === "object";
            const title = isDataObj
                ? data.title
                : "Server connection: " + response.statusText;
            const message = isDataObj ? data.message : data;
            Swal.fire({
                title: title,
                html: message,
                icon: "success",
            });
            form.classList.remove("was-validated");
            form.reset();
        },
        error: (errorData, errorResponse, form) => {
            let title =
                errorResponse?.statusText ||
                "Oops, sorry about that. An unknown error occurred.";
            let message = errorData;
            let errors = errorData?.validation_errors || {};
            let errMsg = "";
            title = errorData?.title || errorData?.name || title;
            message = errorData?.message || message;

            for (const err in errors) {
                errMsg += `${errors[err]}<br/>`;
            }

            if (title === "AbortError") Swal.close();
            else
                Swal.fire({
                    title: title,
                    html: errMsg,
                    icon: "error",
                    // showCancelButton: true, // for debugging
                    cancelButtonText: "View Error",
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.cancel) {
                        var newWindow = window.open();
                        if (newWindow) {
                            // prints laravel stack error in a new tab
                            if (typeof message === "string")
                                if (message.startsWith("<!DOCTYPE html>")) {
                                    newWindow.document.write(message);
                                    newWindow.stop();
                                }
                                // prints dd() in a new tab
                                else
                                    newWindow.document.body.outerHTML = message;
                        }
                    }
                });
        },
        complete: (form) => {
            form.querySelector('[type="submit"]').disabled = false;
        },
    },
});

function showFeedback(fieldClass, data) {
    for (const key in data) {
        const { field, label, message = " " } = data[key];

        let parent = field.parentElement;
        while (parent && parent.classList.contains("v-input") === false) {
            parent = parent.parentElement;
        }

        if (!parent.classList.contains(fieldClass) && fieldClass)
            parent.classList.add(fieldClass);

        const container = parent
            .querySelector(".v-input__details")
            ?.querySelector(".v-messages");

        if (container) {
            container.textContent = message;
        } else {
            const div = document.createElement("div");
            div.classList.add("v-messages__message");
            div.textContent = message;
            container.append(div);
        }
    }
}
