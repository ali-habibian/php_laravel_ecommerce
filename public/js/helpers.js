/**
 * Displays a SweetAlert2 message with a specified type.
 *
 * @param {string} type - The type of alert (e.g., 'success', 'error', 'warning', 'info').
 * @param {string} message - The message to display in the alert.
 * @param {Function} [callback=null] - Optional callback function executed after the alert is dismissed.
 */
function showSwalMessage(type, message, callback = null) {
    Swal.fire({
        text: message,
        icon: type
    }).then((result) => {
        if (callback && typeof callback === 'function') {
            callback(result);
        }
    });
}

/**
 * Displays a SweetAlert2 success message.
 *
 * @function showSwalSuccess
 * @param {string} message - The message to display in the alert.
 * @param {Function} [callback=null] - Optional callback function executed after the alert is dismissed.
 *
 * @example
 * // Simple success alert
 * showSwalSuccess("Operation completed successfully!");
 *
 * @example
 * // Success alert with page reload after dismissal
 * showSwalSuccess("Data saved successfully!", () => {
 *     location.reload();
 * });
 *
 * @example
 * // Success alert with redirection after dismissal
 * showSwalSuccess("Action successful!", () => {
 *     window.location.href = "/dashboard";
 * });
 */
function showSwalSuccess(message, callback = null) {
    showSwalMessage('success', message, callback);
}

/**
 * Displays a SweetAlert2 error message.
 *
 * @function showSwalError
 * @param {string} message - The error message to display.
 * @param {Function} [callback=null] - Optional callback function executed after the alert is dismissed.
 *
 * @example
 * // Simple error alert
 * showSwalError("An error occurred!");
 *
 * @example
 * // Error alert with a console log after dismissal
 * showSwalError("Failed to save data!", () => {
 *     console.log("User acknowledged the error.");
 * });
 *
 * @example
 * // Error alert with navigation after dismissal
 * showSwalError("Session expired! Redirecting to login...", () => {
 *     window.location.href = "/login";
 * });
 */
function showSwalError(message, callback = null) {
    showSwalMessage('error', message, callback);
}
