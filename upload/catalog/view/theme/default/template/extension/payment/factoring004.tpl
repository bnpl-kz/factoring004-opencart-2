<div class="buttons">
    <div class="pull-right">
        <? if (!empty($factoring004_agreement_filename)) { ?>
        <? echo $text_checkbox_factoring004_condition ?> <a target="_blank" href="../image/<? echo $factoring004_agreement_filename ?>"><? echo $text_checkbox_factoring004_condition_link ?></a>
        <input type="checkbox" name="factoring004-agreement-check">&nbsp;&nbsp;&nbsp;
        <? } ?>
        <input data-url="<? echo $action ?>" data-loading-text="<? echo $text_loading ?>" id="factoring004-submit-button" type="button" value="<? echo $button_confirm ?>" class="btn btn-primary" />
    </div>
</div>

<script>
    let button = $('#factoring004-submit-button');
    button.click(function () {
        let checkbox = $('input[name="factoring004-agreement-check"]');
        if (checkbox.length && !checkbox.is(':checked')) {
            alert('Вам необходимо согласиться с условиями!');
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
                if (!response.success) {
                    alert(response.error)
                    return;
                }
                window.location.replace(response.redirectLink)
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText)
            }
        })
    })
</script>