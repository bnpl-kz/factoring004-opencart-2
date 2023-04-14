<?=$header; ?>
<?=$column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-payment" data-toggle="tooltip" title="<?=$button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?=$cancel; ?>" data-toggle="tooltip" title="<?=$button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><?=$heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?=$breadcrumb['href']; ?>"><?=$breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> <?=$error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?=$text_edit ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?=$action ?>" method="post" enctype="multipart/form-data" id="form-payment" class="form-horizontal">
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-api-host"><?=$entry_api_host ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<?=$factoring004_api_host ?>" name="factoring004_api_host" placeholder="<?=$entry_api_host; ?>" id="input-api-host" class="form-control" />
                            <?php if ($error_api_host) { ?>
                            <div class="text-danger"><?=$error_api_host; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-oauth-login"><?=$entry_oauth_login; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<?=$factoring004_oauth_login; ?>" name="factoring004_oauth_login" placeholder="<?=$entry_oauth_login; ?>" id="input-oauth-login" class="form-control" />
                            <?php if ($error_oauth_login) { ?>
                            <div class="text-danger" ><?=$error_oauth_login; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-oauth-password" ><?=$entry_oauth_password; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<?=$factoring004_oauth_password; ?>" name="factoring004_oauth_password" placeholder="<?=$entry_oauth_password; ?>" id="input-oauth-password" class="form-control" />
                            <?php if ($error_oauth_password) { ?>
                            <div class="text-danger" ><?=$error_oauth_password; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-partner-name"><?=$entry_partner_name; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<?=$factoring004_partner_name; ?>" name="factoring004_partner_name" placeholder="<?=$entry_partner_name; ?>" id="input-partner-name" class="form-control" />
                            <?php if ($error_partner_name) { ?>
                            <div class="text-danger" ><?=$error_partner_name; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-partner-code" ><?=$entry_partner_code; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<?=$factoring004_partner_code; ?>" name="factoring004_partner_code" placeholder="<?=$entry_partner_code; ?>" id="input-partner-code" class="form-control" />
                            <?php if ($error_partner_code) { ?>
                            <div class="text-danger" ><?=$error_partner_code; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-point-code"><?=$entry_point_code; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<?=$factoring004_point_code; ?>" name="factoring004_point_code" placeholder="<?=$entry_point_code; ?>" id="input-point-code" class="form-control" />
                            <?php if ($error_point_code) { ?>
                            <div class="text-danger" ><?=$error_point_code; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-paid-order-status" ><?=$entry_paid_order_status; ?></label>
                        <div class="col-sm-10">
                            <select name="factoring004_paid_order_status_id" id="input-paid-order-status" class="form-control">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $factoring004_paid_order_status_id) { ?>
                                <option value="<?=$order_status['order_status_id']; ?>" selected="selected" ><?=$order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?=$order_status['order_status_id']; ?>" <?php if ($order_status['name'] == 'В обработке' || $order_status['name'] == 'Processing') { ?> selected="selected" <?php } ?> ><?=$order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-unpaid-order-status"><?=$entry_unpaid_order_status; ?></label>
                        <div class="col-sm-10">
                            <select name="factoring004_unpaid_order_status_id" id="input-paid-order-status" class="form-control">
                                <?php foreach($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $factoring004_unpaid_order_status_id) { ?>
                                <option value="<?=$order_status['order_status_id']; ?>" selected="selected" ><?=$order_status['name']; ?></option>
                                <?php } else { ?>
                                <option <?php if (in_array($order_status['name'],  ['Неудавшийся', 'Failed'])) { ?> selected="selected" <?php } ?> value="<?=$order_status['order_status_id']; ?>" ><?=$order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
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
                                    <?=$entry_debug_mode; ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status" ><?=$entry_status; ?></label>
                        <div class="col-sm-10">
                            <select name="factoring004_status" id="input-status" class="form-control">
                                <?php if ($factoring004_status) { ?>
                                <option value="1" selected="selected" ><?=$text_enabled; ?></option>
                                <option value="0" ><?=$text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1" ><?=$text_enabled; ?></option>
                                <option value="0" selected="selected" ><?=$text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> <?=$footer; ?>