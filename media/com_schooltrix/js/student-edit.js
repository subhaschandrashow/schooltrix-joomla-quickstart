
((document, submitForm) => {

// Selectors used by this script
const buttonDataSelector = 'data-submit-task';
const formId = 'adminForm';

/**
 * Submit the task
 * @param task
 */
const submitTask = task => {
const form = document.getElementById(formId);
if (task === 'student.cancel' || document.formvalidator.isValid(form)) {
    submitForm(task, form);
}
};
    
// Register events
document.addEventListener('DOMContentLoaded', () => {
    const buttons = [].slice.call(document.querySelectorAll(`[${buttonDataSelector}]`));
    buttons.forEach(button => {
        button.addEventListener('click', e => {
        e.preventDefault();
        const task = e.target.getAttribute(buttonDataSelector);
        submitTask(task);
        });
    });
});

})(document, Joomla.submitform);