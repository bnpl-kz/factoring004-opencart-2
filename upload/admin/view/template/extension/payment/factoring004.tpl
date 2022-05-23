<? echo $header; ?>
<? echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-payment" data-toggle="tooltip" title="<? echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<? echo $cancel; ?>" data-toggle="tooltip" title="<? echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><? echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <? foreach($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <? } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <? if ($error_warning) { ?>
        <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> <? echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <? } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <? echo $text_edit ?></h3>
            </div>
            <div class="panel-body">
                <form action="<? echo $action ?>" method="post" enctype="multipart/form-data" id="form-payment" class="form-horizontal">
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-api-host"><? echo $entry_api_host ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<? echo $payment_factoring004_api_host ?>" name="payment_factoring004_api_host" placeholder="<? echo $entry_api_host; ?>" id="input-api-host" class="form-control" />
                            <? if ($error_api_host) { ?>
                            <div class="text-danger"><? echo $error_api_host; ?></div>
                            <? } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-preapp-token"><? echo $entry_preapp_token; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<? echo $payment_factoring004_preapp_token; ?>" name="payment_factoring004_preapp_token" placeholder="<? echo $entry_preapp_token; ?>" id="input-preapp-token" class="form-control" />
                            <? if ($error_preapp_token) { ?>
                            <div class="text-danger" ><? echo $error_preapp_token; ?></div>
                            <? } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-delivery-token" ><? echo $entry_delivery_token; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<? echo $payment_factoring004_delivery_token; ?>" name="payment_factoring004_delivery_token" placeholder="<? echo $entry_delivery_token; ?>" id="input-delivery-token" class="form-control" />
                            <? if ($error_delivery_token) { ?>
                            <div class="text-danger" ><? echo $error_delivery_token; ?></div>
                            <? } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-partner-name"><? echo $entry_partner_name; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<? echo $payment_factoring004_partner_name; ?>" name="payment_factoring004_partner_name" placeholder="<? echo $entry_partner_name; ?>" id="input-partner-name" class="form-control" />
                            <? if ($error_partner_name) { ?>
                            <div class="text-danger" ><? echo $error_partner_name; ?></div>
                            <? } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-partner-code" ><? echo $entry_partner_code; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<? echo $payment_factoring004_partner_code; ?>" name="payment_factoring004_partner_code" placeholder="<? echo $entry_partner_code; ?>" id="input-partner-code" class="form-control" />
                            <? if ($error_partner_code) { ?>
                            <div class="text-danger" ><? echo $error_partner_code; ?></div>
                            <? } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-point-code"><? echo $entry_point_code; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<? echo $payment_factoring004_point_code; ?>" name="payment_factoring004_point_code" placeholder="<? echo $entry_point_code; ?>" id="input-point-code" class="form-control" />
                            <? if ($error_point_code) { ?>
                            <div class="text-danger" ><? echo $error_point_code; ?></div>
                            <? } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-partner-email" ><? echo $entry_partner_email; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<? echo $payment_factoring004_partner_email; ?>" name="payment_factoring004_partner_email" placeholder="<? echo $entry_partner_email; ?>" id="input-partner-email" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-partner-website" ><? echo $entry_partner_website; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<? echo $payment_factoring004_partner_website; ?>" name="payment_factoring004_partner_website" placeholder="<? echo $entry_partner_website; ?>" id="input-partner-website" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-paid-order-status" ><? echo $entry_paid_order_status; ?></label>
                        <div class="col-sm-10">
                            <select name="payment_factoring004_paid_order_status_id" id="input-paid-order-status" class="form-control">
                                <? foreach ($order_statuses as $order_status) { ?>
                                <? if ($order_status['order_status_id'] == $payment_factoring004_paid_order_status_id) { ?>
                                <option value="<? echo $order_status['order_status_id']; ?>" selected="selected" ><? echo $order_status['name']; ?></option>
                                <? } else { ?>
                                <option value="<? echo $order_status['order_status_id']; ?>" <? if ($order_status['name'] == 'В обработке' || $order_status['name'] == 'Processing') { ?> selected="selected" <? } ?> ><? echo $order_status['name']; ?></option>
                                <? } ?>
                                <? } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-unpaid-order-status"><? echo $entry_unpaid_order_status; ?></label>
                        <div class="col-sm-10">
                            <select name="payment_factoring004_unpaid_order_status_id" id="input-paid-order-status" class="form-control">
                                <? foreach($order_statuses as $order_status) { ?>
                                <? if ($order_status['order_status_id'] == $payment_factoring004_unpaid_order_status_id) { ?>
                                <option value="<? echo $order_status['order_status_id']; ?>" selected="selected" ><? echo $order_status['name']; ?></option>
                                <? } else { ?>
                                <option <? if (in_array($order_status['name'],  ['Неудавшийся', 'Failed'])) { ?> selected="selected" <? } ?> value="<? echo $order_status['order_status_id']; ?>" ><? echo $order_status['name']; ?></option>
                                <? } ?>
                                <? } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-delivery-order-status" ><? echo $entry_delivery_order_status; ?></label>
                        <div class="col-sm-10">
                            <select name="payment_factoring004_delivery_order_status_id" id="input-delivery-order-status" class="form-control">
                                <? foreach ($order_statuses as $order_status) { ?>
                                <? if ($order_status['order_status_id'] == $payment_factoring004_delivery_order_status_id) { ?>
                                <option value=<? echo $order_status['order_status_id']; ?>" selected="selected" ><? echo $order_status['name']; ?></option>
                                <? } else { ?>
                                <option <? if (in_array($order_status['name'], ['Доставлено','Shipped'])) { ?> selected="selected" <? } ?> value="<? echo $order_status['order_status_id']; ?>" ><? echo $order_status['name']; ?></option>
                                <? } ?>
                                <? } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-return-order-status"><? echo $entry_return_order_status; ?></label>
                        <div class="col-sm-10">
                            <select name="payment_factoring004_return_order_status_id" id="input-return-order-status" class="form-control">
                                <? foreach ($order_statuses as $order_status) { ?>
                                <? if ($order_status['order_status_id'] == $payment_factoring004_return_order_status_id) { ?>
                                <option value="<? echo $order_status['order_status_id']; ?>" selected="selected" ><? echo $order_status['name']; ?></option>
                                <? } else { ?>
                                <option <? if (in_array($order_status['name'], ['Возврат','Denied'])) { ?> selected="selected" <? } ?> value="<? echo $order_status['order_status_id']; ?>" ><? echo $order_status['name']; ?></option>
                                <? } ?>
                                <? } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-cancel-order-status" ><? echo $entry_cancel_order_status; ?></label>
                        <div class="col-sm-10">
                            <select name="payment_factoring004_cancel_order_status_id" id="input-cancel-order-status" class="form-control">
                                <? foreach ($order_statuses as $order_status) { ?>
                                <? if ($order_status['order_status_id'] == $payment_factoring004_cancel_order_status_id) { ?>
                                <option value="<? echo $order_status['order_status_id']; ?>" selected="selected" ><? echo $order_status['name']; ?></option>
                                <? } else { ?>
                                <option <? if (in_array($order_status['name'], ['Отменено','Canceled'])) { ?> selected="selected" <? } ?> value="<? echo $order_status['order_status_id']; ?>" ><? echo $order_status['name']; ?></option>
                                <? } ?>
                                <? } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-delivery" ><? echo $entry_delivery_items; ?></label>
                        <div class="col-sm-10">
                            <div class="checkbox">
                                <? foreach ($deliveries as $delivery) { ?>
                                <label style="display:block;">
                                    <input style="position:absolute;" id="input-delivery" <? foreach ($payment_factoring004_delivery as $item) { ?> <? if ($item == $delivery['id']) { ?> checked <? } ?>  <? } ?> type="checkbox" name="payment_factoring004_delivery[]" value="<? echo $delivery['id']; ?>">
                                    <? echo $delivery['name']; ?>
                                </label>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-agreement-file" ><? echo $entry_agreement_file; ?></label>
                        <div class="col-sm-10">
                            <? if (!empty($payment_factoring004_agreement_file)) { ?>
                            <input type="hidden" name="payment_factoring004_agreement_file" value="<? echo $payment_factoring004_agreement_file; ?>">
                            <a class="btn btn-default" target="_blank" href="../image/<? echo $payment_factoring004_agreement_file; ?>"><i class="fa fa-file-pdf-o"></i></a>
                            <button data-loading-text="<? echo $text_loading; ?>" id="payment-factoring004-agreement-button" type="button" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Удалить"><i class="fa fa-close"></i></button>
                            <? } else { ?>
                            <button type="button" class="btn bg-primary" onclick="document.getElementById('get-agreement-file').click()" ><? echo $text_button_agreement_file; ?></button>
                            <input name="payment_factoring004_agreement_file" type="file" id="get-agreement-file" style="display:none">
                            <br><small id="input-agreement-file-help" class="form-text text-muted"<? echo $text_agreement_file; ?></small>
                            <? } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <div class="checkbox">
                                <label>
                                    <? if ($payment_factoring004_debug_mode) { ?>
                                    <input type="checkbox" name="payment_factoring004_debug_mode" checked>
                                    <? } else { ?>
                                    <input type="checkbox" name="payment_factoring004_debug_mode">
                                    <? } ?>
                                    <? echo $entry_debug_mode; ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status" ><? echo $entry_status; ?></label>
                        <div class="col-sm-10">
                            <select name="payment_factoring004_status" id="input-status" class="form-control">
                                <? if ($payment_factoring004_status) { ?>
                                <option value="1" selected="selected" ><? echo $text_enabled; ?></option>
                                <option value="0" ><? echo $text_disabled; ?></option>
                                <? } else { ?>
                                <option value="1" ><? echo $text_enabled; ?></option>
                                <option value="0" selected="selected" ><? echo $text_disabled; ?></option>
                                <? } ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> <? echo $footer; ?>

<script>
    let button = $('#payment-factoring004-agreement-button');
    button.click(function () {
        let filename = button.prev().attr('href').split('/').pop();
        $.ajax({
            url: window.location.href + '&filename=' + filename,
            type: 'DELETE',
            dataType: 'json',
            beforeSend: function () {
                button.button('loading');
            },
            complete: function () {
                button.button('reset');
                location.reload();
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message)
                } else {
                    alert(response.message)
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText)
            }
        })
    })
</script>