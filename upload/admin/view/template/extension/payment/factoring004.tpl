<?php =$header; ?>
<?php =$column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-payment" data-toggle="tooltip" title="<?php =$button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php =$cancel; ?>" data-toggle="tooltip" title="<?php =$button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><?php =$heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php =$breadcrumb['href']; ?>"><?php =$breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> <?php =$error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php =$text_edit ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php =$action ?>" method="post" enctype="multipart/form-data" id="form-payment" class="form-horizontal">
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-api-host"><?php =$entry_api_host ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<?php =$factoring004_api_host ?>" name="factoring004_api_host" placeholder="<?php =$entry_api_host; ?>" id="input-api-host" class="form-control" />
                            <?php if ($error_api_host) { ?>
                            <div class="text-danger"><?php =$error_api_host; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-preapp-token"><?php =$entry_preapp_token; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<?php =$factoring004_preapp_token; ?>" name="factoring004_preapp_token" placeholder="<?php =$entry_preapp_token; ?>" id="input-preapp-token" class="form-control" />
                            <?php if ($error_preapp_token) { ?>
                            <div class="text-danger" ><?php =$error_preapp_token; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-delivery-token" ><?php =$entry_delivery_token; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<?php =$factoring004_delivery_token; ?>" name="factoring004_delivery_token" placeholder="<?php =$entry_delivery_token; ?>" id="input-delivery-token" class="form-control" />
                            <?php if ($error_delivery_token) { ?>
                            <div class="text-danger" ><?php =$error_delivery_token; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-partner-name"><?php =$entry_partner_name; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<?php =$factoring004_partner_name; ?>" name="factoring004_partner_name" placeholder="<?php =$entry_partner_name; ?>" id="input-partner-name" class="form-control" />
                            <?php if ($error_partner_name) { ?>
                            <div class="text-danger" ><?php =$error_partner_name; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-partner-code" ><?php =$entry_partner_code; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<?php =$factoring004_partner_code; ?>" name="factoring004_partner_code" placeholder="<?php =$entry_partner_code; ?>" id="input-partner-code" class="form-control" />
                            <?php if ($error_partner_code) { ?>
                            <div class="text-danger" ><?php =$error_partner_code; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-point-code"><?php =$entry_point_code; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<?php =$factoring004_point_code; ?>" name="factoring004_point_code" placeholder="<?php =$entry_point_code; ?>" id="input-point-code" class="form-control" />
                            <?php if ($error_point_code) { ?>
                            <div class="text-danger" ><?php =$error_point_code; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-partner-email" ><?php =$entry_partner_email; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<?php =$factoring004_partner_email; ?>" name="factoring004_partner_email" placeholder="<?php =$entry_partner_email; ?>" id="input-partner-email" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-partner-website" ><?php =$entry_partner_website; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<?php =$factoring004_partner_website; ?>" name="factoring004_partner_website" placeholder="<?php =$entry_partner_website; ?>" id="input-partner-website" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-paid-order-status" ><?php =$entry_paid_order_status; ?></label>
                        <div class="col-sm-10">
                            <select name="factoring004_paid_order_status_id" id="input-paid-order-status" class="form-control">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $factoring004_paid_order_status_id) { ?>
                                <option value="<?php =$order_status['order_status_id']; ?>" selected="selected" ><?php =$order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php =$order_status['order_status_id']; ?>" <?php if ($order_status['name'] == 'В обработке' || $order_status['name'] == 'Processing') { ?> selected="selected" <?php } ?> ><?php =$order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-unpaid-order-status"><?php =$entry_unpaid_order_status; ?></label>
                        <div class="col-sm-10">
                            <select name="factoring004_unpaid_order_status_id" id="input-paid-order-status" class="form-control">
                                <?php foreach($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $factoring004_unpaid_order_status_id) { ?>
                                <option value="<?php =$order_status['order_status_id']; ?>" selected="selected" ><?php =$order_status['name']; ?></option>
                                <?php } else { ?>
                                <option <?php if (in_array($order_status['name'],  ['Неудавшийся', 'Failed'])) { ?> selected="selected" <?php } ?> value="<?php =$order_status['order_status_id']; ?>" ><?php =$order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-delivery-order-status" ><?php =$entry_delivery_order_status; ?></label>
                        <div class="col-sm-10">
                            <select name="factoring004_delivery_order_status_id" id="input-delivery-order-status" class="form-control">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $factoring004_delivery_order_status_id) { ?>
                                <option value=<?php =$order_status['order_status_id']; ?>" selected="selected" ><?php =$order_status['name']; ?></option>
                                <?php } else { ?>
                                <option <?php if (in_array($order_status['name'], ['Доставлено','Shipped'])) { ?> selected="selected" <?php } ?> value="<?php =$order_status['order_status_id']; ?>" ><?php =$order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-return-order-status"><?php =$entry_return_order_status; ?></label>
                        <div class="col-sm-10">
                            <select name="factoring004_return_order_status_id" id="input-return-order-status" class="form-control">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $factoring004_return_order_status_id) { ?>
                                <option value="<?php =$order_status['order_status_id']; ?>" selected="selected" ><?php =$order_status['name']; ?></option>
                                <?php } else { ?>
                                <option <?php if (in_array($order_status['name'], ['Возврат','Denied'])) { ?> selected="selected" <?php } ?> value="<?php =$order_status['order_status_id']; ?>" ><?php =$order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-cancel-order-status" ><?php =$entry_cancel_order_status; ?></label>
                        <div class="col-sm-10">
                            <select name="factoring004_cancel_order_status_id" id="input-cancel-order-status" class="form-control">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $factoring004_cancel_order_status_id) { ?>
                                <option value="<?php =$order_status['order_status_id']; ?>" selected="selected" ><?php =$order_status['name']; ?></option>
                                <?php } else { ?>
                                <option <?php if (in_array($order_status['name'], ['Отменено','Canceled'])) { ?> selected="selected" <?php } ?> value="<?php =$order_status['order_status_id']; ?>" ><?php =$order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-delivery" ><?php =$entry_delivery_items; ?></label>
                        <div class="col-sm-10">
                            <div class="checkbox">
                                <?php foreach ($deliveries as $delivery) { ?>
                                <label style="display:block;">
                                    <input style="position:absolute;" id="input-delivery" <?php foreach ($factoring004_delivery as $item) { ?> <?php if ($item == $delivery['id']) { ?> checked <?php } ?>  <?php } ?> type="checkbox" name="factoring004_delivery[]" value="<?php =$delivery['id']; ?>">
                                    <?php =$delivery['name']; ?>
                                </label>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-agreement-file" ><?php =$entry_agreement_file; ?></label>
                        <div class="col-sm-10">
                            <?php if (!empty($factoring004_agreement_file)) { ?>
                            <input type="hidden" name="factoring004_agreement_file" value="<?php =$factoring004_agreement_file; ?>">
                            <a class="btn btn-default" target="_blank" href="../image/<?php =$factoring004_agreement_file; ?>"><i class="fa fa-file-pdf-o"></i></a>
                            <button data-loading-text="<?php =$text_loading; ?>" id="payment-factoring004-agreement-button" type="button" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Удалить"><i class="fa fa-close"></i></button>
                            <?php } else { ?>
                            <button type="button" class="btn bg-primary" onclick="document.getElementById('get-agreement-file').click()" ><?php =$text_button_agreement_file; ?></button>
                            <input name="factoring004_agreement_file" type="file" id="get-agreement-file" style="display:none">
                            <br><small id="input-agreement-file-help" class="form-text text-muted"<?php =$text_agreement_file; ?></small>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <div class="checkbox">
                                <label>
                                    <?php if ($factoring004_debug_mode) { ?>
                                    <input type="checkbox" name="factoring004_debug_mode" checked>
                                    <?php } else { ?>
                                    <input type="checkbox" name="factoring004_debug_mode">
                                    <?php } ?>
                                    <?php =$entry_debug_mode; ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status" ><?php =$entry_status; ?></label>
                        <div class="col-sm-10">
                            <select name="factoring004_status" id="input-status" class="form-control">
                                <?php if ($factoring004_status) { ?>
                                <option value="1" selected="selected" ><?php =$text_enabled; ?></option>
                                <option value="0" ><?php =$text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1" ><?php =$text_enabled; ?></option>
                                <option value="0" selected="selected" ><?php =$text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> <?php =$footer; ?>

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