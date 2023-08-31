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
            const submitBtn = form.querySelector('[type="submit"]');
            if (submitBtn) submitBtn.disabled = true;

            // Show a loading modal while the request is being processed
            Swal.fire({
                title: "Saving...",
                icon: "info",
                text: "Please wait.",
                allowOutsideClick: false,
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
        error: function (errorData, errorResponse, form) {
            // Handle error response
            let title = errorResponse
                ? `${errorResponse.statusText}:  ${errorResponse.status}`
                : "Error";
            let message = errorData;

            console.log(arguments);

            // Check if errorData is an object
            if (typeof errorData === "object") {
                if (errorResponse) {
                    // errorData is from server
                    title = errorData.title || errorResponse.statusText;
                    message = errorData.message || "";

                    // for validation errors from server
                    const validationErrors = errorData.validation_errors;
                    if (typeof validationErrors === "object") {
                        // Construct error message for display
                        message = "";
                        for (const err in validationErrors) {
                            message += `${validationErrors[err]}<br/>`;
                        }
                    }
                } else {
                    // errorData is an Error/Exception
                    title = errorData.name || title;
                    message = errorData.stack || errorData.message || message;
                }
            }

            // close swal if aborted
            if (title === "AbortError") {
                Swal.close();
                return;
            }

            let html = message;
            let showCancelButton = message ? true : false;
            // making sure that the message is not an html
            if (typeof message === "string") {
                if (message.startsWith("<!DOCTYPE html>")) {
                    html = "";
                    showCancelButton = true;
                }
            }

            // Display error message
            Swal.fire({
                title,
                html,
                icon: "error",
                showCancelButton,
                cancelButtonText: "View Error",
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.cancel) {
                    // Open a new tab to display error details
                    if (typeof message === "string") {
                        var newWindow = window.open();
                        if (newWindow) {
                            if (message.startsWith("<!DOCTYPE html>")) {
                                newWindow.document.write(message);
                                newWindow.stop();
                            } else {
                                newWindow.document.body.outerHTML = message;
                            }
                        }
                    }
                }
            });
        },
        complete: (form) => {
            const submitBtn = form.querySelector('[type="submit"]');
            if (submitBtn) submitBtn.disabled = false;
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
