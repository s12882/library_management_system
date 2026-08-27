import $ from 'jquery'

window.$ = window.jQuery = $

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
})

$(function () {
    // --- Reusable confirmation modal (replaces native confirm()) ---------
    const $confirmModal = $('#confirm-modal')
    const $confirmMessage = $('#confirm-modal-message')
    let pendingConfirmAction = null

    function requestConfirmation(message, onConfirm) {
        pendingConfirmAction = onConfirm
        $confirmMessage.text(message)
        $confirmModal.removeClass('hidden').addClass('flex items-center justify-center')
    }

    function hideConfirmModal() {
        $confirmModal.addClass('hidden').removeClass('flex items-center justify-center')
        pendingConfirmAction = null
    }

    $(document).on('submit', 'form[data-confirm]', function (event) {
        const $form = $(this)

        if ($form.data('confirmed')) {
            return true
        }

        event.preventDefault()

        requestConfirmation($form.data('confirm'), function () {
            $form.data('confirmed', true)
            $form.trigger('submit')
        })
    })

    $('#confirm-modal-cancel').on('click', hideConfirmModal)

    $('#confirm-modal-confirm').on('click', function () {
        const action = pendingConfirmAction
        hideConfirmModal()

        if (action) {
            action()
        }
    })

    // --- Authors: expand/collapse book list -------------------------------
    $(document).on('click', '[data-author-toggle]', function () {
        const id = $(this).data('author-toggle')

        $('#author-books-' + id).toggleClass('hidden')
        $('[data-chevron="' + id + '"]').toggleClass('rotate-90')
    })

    // --- Loans: filter form + pagination, both AJAX-driven -----------------
    const $loansContainer = $('#loans-table-container')
    const $filterForm = $('#loan-filter-form')

    function loadLoans(query) {
        $.get('/loans/data', query, function (html) {
            $loansContainer.html(html)
        })
    }

    $filterForm.on('submit', function (event) {
        event.preventDefault()
        loadLoans($(this).serialize())
    })

    $('#reset-filters').on('click', function () {
        $filterForm[0].reset()
        loadLoans('')
    })

    $(document).on('click', '#loans-table-container nav a', function (event) {
        event.preventDefault()

        const url = new URL($(this).attr('href'))
        loadLoans(url.search.replace(/^\?/, ''))
    })

    // --- Loans: return (delete) a loan, via the confirm modal -------------
    $(document).on('click', '[data-return-loan]', function () {
        const id = $(this).data('return-loan')
        const message = $(this).data('confirm')

        requestConfirmation(message, function () {
            $.ajax({
                url: '/loans/' + id,
                method: 'DELETE',
                dataType: 'json',
                success: function (response) {
                    showMessage(response.message, 'success')
                    loadLoans($filterForm.serialize())
                },
                error: function () {
                    showMessage('Could not return this book. Please try again.', 'error')
                },
            })
        })
    })

    // --- Loans: checkout modal ----------------------------------------
    const $checkoutModal = $('#checkout-modal')
    const $checkoutForm = $('#checkout-form')

    function showCheckoutModal() {
        $checkoutForm[0].reset()
        $checkoutForm.find('[data-error-for]').addClass('hidden').text('')

        const dueDate = new Date()
        dueDate.setDate(dueDate.getDate() + 14)
        $('#checkout-due-at').val(dueDate.toISOString().slice(0, 10))

        $checkoutModal.removeClass('hidden').addClass('flex')
    }

    function hideCheckoutModal() {
        $checkoutModal.addClass('hidden').removeClass('flex')
    }

    $('#open-checkout-modal').on('click', showCheckoutModal)
    $('#close-checkout-modal').on('click', hideCheckoutModal)

    $checkoutForm.on('submit', function (event) {
        event.preventDefault()

        $checkoutForm.find('[data-error-for]').addClass('hidden').text('')

        $.ajax({
            url: '/loans',
            method: 'POST',
            dataType: 'json',
            data: $checkoutForm.serialize(),
            success: function (response) {
                hideCheckoutModal()
                showMessage(response.message, 'success')
                loadLoans($filterForm.serialize())
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors

                    $.each(errors, function (field, messages) {
                        $checkoutForm
                            .find('[data-error-for="' + field + '"]')
                            .text(messages[0])
                            .removeClass('hidden')
                    })
                } else {
                    showMessage('Something went wrong. Please try again.', 'error')
                }
            },
        })
    })

    function showMessage(message, type) {
        const colors =
            type === 'success'
                ? 'border-green-200 bg-green-50 text-green-800'
                : 'border-red-200 bg-red-50 text-red-800'

        const $banner = $(
            '<div class="mb-6 rounded-md border px-4 py-3 text-sm ' + colors + '">' + message + '</div>'
        )

        $('#message').html($banner)
        setTimeout(function () {
            $banner.fadeOut(300, function () {
                $(this).remove()
            })
        }, 4000)
    }
})
