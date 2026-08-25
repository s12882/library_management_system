import $ from 'jquery';

window.$ = window.jQuery = $;

$(function () {
    const $modal = $('#confirm-modal')
    const $message = $('#confirm-modal-message')
    let pendingForm = null

    function showModal(message) {
        $message.text(message)
        $modal.removeClass('hidden').addClass('flex items-center justify-center')
    }

    function hideModal() {
        $modal.addClass('hidden').removeClass('flex items-center justify-center')
        pendingForm = null
    }

    $(document).on('submit', 'form[data-confirm]', function (event) {
        const $form = $(this)

        if ($form.data('confirmed')) {
            return true
        }

        event.preventDefault()

        pendingForm = $form
        showModal($form.data('confirm'))
    });

    $('#confirm-modal-cancel').on('click', hideModal)

    $('#confirm-modal-confirm').on('click', function () {

        if (pendingForm) {
            pendingForm.data('confirmed', true)
            pendingForm.trigger('submit')
        }

        hideModal()
    })
});

