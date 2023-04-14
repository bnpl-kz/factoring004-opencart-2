<div class="buttons">
    <div class="pull-right">
        <input data-url="<?=$action ?>" data-loading-text="<?=$text_loading ?>" id="factoring004-submit-button" type="button" value="<?=$button_confirm ?>" class="btn btn-primary" />
    </div>
</div>

<? if ($paymentGatewayType == 'modal'): ?>
<div id="factoring004-payment-widget"></div>
<? endif ?>

<script>
    let button = $('#factoring004-submit-button');
    const paymentGatewayType = '<?=$paymentGatewayType ?>';
    let paymentModal = null;
    let redirectLink = null;
    if (paymentGatewayType === 'modal') {
        paymentModal = new BnplKzApi.CPO({
            rootId: 'factoring004-payment-widget',
            callbacks: {
                onEnd: () => window.location.replace('<?=$successRedirect ?>'),
                onError: (err) => {
                    if (err.code === 'clientError') {
                        window.location.replace(redirectLink);
                    }
                },
                onRestart: (_redirectLink) => redirectLink = _redirectLink,
                onDeclined: () => window.location.replace('<?=$failRedirect ?>'),
            },
        });
    }
    button.click(function () {
        if (paymentGatewayType === 'modal' && redirectLink) {
            paymentModal.render({ redirectLink });
            return;
        }
        let url = button.attr('data-url');
        $.ajax({
            url: url,
            dataType: 'json',
            type: 'post',
            contentType: 'application/json',
            beforeSend: function () {
                button.button('loading');
            },
            complete: function () {
                button.button('reset');
            },
            success: function(response) {
                if (!response.success && response.error) {
                    alert(response.error)
                    return;
                }
                if (paymentGatewayType === 'redirect') {
                    window.location.replace(response.redirectLink);
                    return;
                }
                redirectLink = response.redirectLink
                paymentModal.render({ redirectLink });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText)
            }
        })
    })
</script>