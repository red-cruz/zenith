import Swal from "sweetalert2";
import Vts from "vts.js";

Vts.setDefaults({
    class: {
        invalid: "v-input--error",
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
            // Disable the submit button to prevent the user from submitting the form multiple times.
            form.querySelector('[type="submit"]').disabled = true;
            // Show a loading modal while the request is being processed
            Swal.fire({
                title: "Saving...",
                icon: "info",
                text: "Please wait.",
                // allowOutsideClick: false,
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonText: "Cancel",
            }).then((result) => {
                // If the user cancels the request, abort the Ajax request.
                if (result.dismiss === Swal.DismissReason.cancel) {
                    abortController.abort();
                }
            });
        },
        success: (data, response, form) => {
            // Handle successful response

            const isDataObj = typeof data === "object";
            const title = isDataObj
                ? data.title || "Success" // Fallback to default title if not provided
                : "Server Connection: " + response.statusText;
            const message = isDataObj
                ? data.message || "Request successful" // Fallback to default message if not provided
                : data;

            // Display success message
            Swal.fire({
                title: title,
                html: message,
                icon: "success",
            });

            // Reset form validation and clear form inputs
            form.classList.remove("was-validated");
            form.reset();
        },
        error: (errorData, errorResponse, form) => {
            let title =
                errorResponse?.statusText ||
                "Oops, sorry about that. An unknown error occurred.";
            let message = errorData;
            let errors =
                errorData?.validation_errors || // can come from the response json from server
                {};
            let errMsg = "";
            title =
                errorData?.title || // can come from the response json from server
                errorData?.name || // can be whatever the name of error that was thrown from the submit function
                title;
            message =
                errorData?.message || // can come from the response json from server
                message;

            for (const err in errors) {
                errMsg += `${errors[err]}<br/>`;
            }

            if (title === "AbortError")
                Swal.close(); // Close loading modal if request was aborted
            else
                Swal.fire({
                    title: title,
                    html: errMsg,
                    icon: "error",
                    // showCancelButton: true, // for debugging
                    cancelButtonText: "View Error",
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.cancel) {
                        // Open a new tab to display error details
                        var newWindow = window.open();
                        if (newWindow) {
                            // Display error details in the new tab
                            if (typeof message === "string")
                                if (message.startsWith("<!DOCTYPE html>")) {
                                    newWindow.document.write(message);
                                    newWindow.stop();
                                } else
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
