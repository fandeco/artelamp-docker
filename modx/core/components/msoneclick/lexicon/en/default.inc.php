<?php
include_once 'setting.inc.php';
$_lang['msoneclick'] = 'Quick order';
$_lang['msoc'] = 'Quick order';
$_lang['msoc.button'] = 'Send order';
$_lang['msoc.emailSubject'] = 'Quick order on the site “[[+++ site_name]]”';
$_lang['msoc.successMessage'] = '<p> Thank you, your application has been sent successfully. </ p> <p> In the near future, we will contact you to clarify the details. </ p>';
$_lang['msoc_form_success'] = 'Form received';
$_lang['msoc_message_close_all'] = 'Close message';
$_lang['msoc_btn_one_click'] = 'Buy in 1 click';
$_lang['msoc_form_send_h1'] = 'Order has been sent successfully';
$_lang['msoc_form_send_text'] = 'Our manager will contact you shortly.';
$_lang['msoc_form_send_num'] = 'Order Number';
$_lang['msoc_close_modal'] = 'Close window';
$_lang['msoc_field_city'] = 'City';
$_lang['msoc_field_city_ple'] = 'Moscow';
$_lang['msoc_field_country'] = 'Сountry';
$_lang['msoc_field_country_ple'] = 'USA';
$_lang['msoc_field_receiver'] = 'Full Name';
$_lang['msoc_field_receiver_ple'] = 'Ivan Ivanov Ivan';
$_lang['msoc_field_phone'] = 'Phone';
$_lang['msoc_field_phone_ple'] = 'Phone';
$_lang['msoc_field_email'] = 'E-mail';
$_lang['msoc_field_email_ple'] = 'E-mail';
$_lang['msoc_field_comment'] = 'Comment';
$_lang['msoc_field_comment_ple'] = '';
$_lang['msoc_form_footer_text'] = 'To place an order with delivery and payment, go to the cart and place the order';
$_lang['msoc_errors'] =' An error occurred while sending the order. Fill in required fields!';
$_lang['msoc_err_get_product'] = 'Failed to get the selected product. Product ID not specified or ';
$_lang['msoc_validate_err_name'] = 'Enter your full name';
$_lang['msoc_validate_err_name_strlen'] = 'The number of characters entered must be 2 or more.';
$_lang['msoc_validate_err_name_numeric'] = 'Name must not contain numbers';
$_lang['msoc_validate_err_email'] = 'Enter your E-mail address';
$_lang['msoc_validate_err_email_valid'] = 'E-mail entered incorrectly.';
$_lang['msoc_validate_err_phone'] = 'Enter the phone number.';
$_lang['msoc_validate_err_phone_valid'] = 'Please enter a valid phone number.';
$_lang['msoc_title_send_order'] = 'Order has been sent successfully';
$_lang['msoc_title_send_order_2'] = 'Order has been sent successfully';
$_lang['msoc_title_send_form'] = 'Form submitted successfully';
$_lang['msoc_err_name'] = 'Enter your full name';
$_lang['msoc_err_name_strlen'] = 'The number of entered characters must be 2 or more.';
$_lang['msoc_err_name_numeric'] = 'Full name must not contain digits';
$_lang['msoc_err_email'] = 'Enter your E-mail address';
$_lang['msoc_err_email_invalid'] = 'E-mail entered incorrectly.';
$_lang['msoc_err_phone'] = 'Enter the phone number.';
$_lang['msoc_err_phone_valide'] = 'Enter the phone number.';
$_lang['msoc_success_order_send'] = 'Order has been sent successfully';
$_lang['msoc_success_form_send'] = 'Form successfully submitted';
$_lang['msoc_err_form_chunk'] = 'Could not get the chunk with the form "tplForm"';
$_lang['msoc_err_get_msProduct'] = 'Could not get the product! No ID is specified for the link "data-product" ';
$_lang['msoc_err_get_msPayment_active'] = 'An error has occurred! The specified payment method is active and cannot be used for quick order. This is set by the miniShop2 policy';
$_lang['msoc_err_get_msDelivery_active'] = 'An error has occurred! The specified delivery method is active and cannot be used for quick order. This is set by the miniShop2 policy';
$_lang['msoc_err_not_payments'] = 'Enter the ID of the not active payment method in the setting: msoneclick_payments';
$_lang['msoc_err_not_deliverys'] = 'Specify the ID of the delivery method in the setting: msoneclick_deliverys';
$_lang['msoc_err_not_method'] = 'The specified order sending method was not found: [[+ method]]';
$_lang['msoc_err_all_field'] = 'The field is required!';
$_lang['msoc_err_count'] = 'Enter the quantity of goods!';
$_lang['msoc_err_product_id'] = 'Product ID not specified';
$_lang['msoc_err_could_not_miniShop2'] = 'To use the MS order sending method, you need to install the miniShop2 application';
$_lang['msoc_err_ms2_email_manager'] = 'To send an order using the MAIL method, you must specify the e-mail address in the settings of the "emailsender" "ms2_email_manager" or in the snippet the hair holder "email_method_mail"';
$_lang['msoc_err_ms2_message_tpl'] = 'Could not get the template';
$_lang['msoc_err_ms2_id_product'] = 'Enter the product ID';
$_lang['msoc_err_ms2_id_product_valid'] = 'Product ID not valid: [[+ id]]';
$_lang['msoc_err_ms2_pl'] = 'The floater is not specified: [[+ pl]]';
$_lang['msoc_err_session'] = 'Could not get the form config [[+ hash]]';
$_lang['msoc_err_order_id'] = 'Could not get msorder ID';
$_lang['msoc_err_order_empty'] = 'Could not get the order data to the created one';
$_lang['msoc_err_payment_delivery'] = 'The selected payment method has no delivery method attached';
$_lang['msoc_err_order_empty_orderId'] = 'Could not get order ID from session!';