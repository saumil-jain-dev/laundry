<?php

return [
    'password' => '123456789',

    // Common Response Messages
    'create' => ':attribute added successfully.',
    'view' => ':attribute get successfully.',
    'update' => ':attribute updated successfully.',
    'deleted' => ':attribute deleted successfully.',
    'load_status' => 'Load :status successfully.',
    'not_found' => ':attribute not found.',
    'quotation' => ':attribute :status successfully.',
    'list' => ':attribute list get successfully.',
    'status' => ':attribute status updated successfully.',
    'required_custom' => 'The :attribute field is required.',
    'delete_role' => "Can't delete role because some user exist in this.",
    'kyc_approved' => "User kyc approved successfully.",
    'kyc_rejected' => "User kyc rejected successfully.",
    'LOAD_ACTION_INVALID' => "Invalid load action.",
    "LOAD_ACTION_NOT_ACCEPT" => "You cannot accept this request because you already have an ongoing booking request.",
    "USER_OFFLINE" => "User is offline.",
    'ASSIGN_DRIVER' => "Load Assigned successfully.",
    'send_notification' => 'Notification send successfully',

    // Response Messages
    'register_success' => 'You are registered successfully.',
    'login_success' => 'You are logged In successfully.',
    'verify_mail_subject' => 'Verify Your Account - One-Time Password',
    'login_invalid' => 'Invalid Credential',
    'otp_sent' => 'OTP sent successfully. Check your mail and enter the code to proceed.',
    'logout_success' => 'You are logged out successfully.',
    'delete_account_success' => 'Account deleted successfully.',
    'load_max_limit' => 'You have reached the maximum number of quotations allowed for this load.',

    'kyc_verify_subject' => 'Congratulations! Your KYC is Complete with Sarthitrans Logistics',
    'kyc_reject_subject' => 'Your KYC is Rejected with Sarthitrans Logistics',
    'payment_subject' => 'Payment Confirmation and Invoice for Your Load with Sarthi Trans Logistic',
    'part_payment_subject' =>'Load Details :load_number and Amount Confirmation with Sarthi Trans Logistic',
    'otp_verify' => 'Your OTP is verified successfully.',
    'photo_uploded' => 'Photo uploaded successfully.',

    'unauthorized' => 'You are not authorized user to access this account.',
    'feedback_message' => 'Thank you for your feedback; we are dedicated to improving based on your input.',
    'help_message' => 'Your message has been received. Our support team will promptly review it and reach out to provide further assistance. Thank you for contacting us.',

    'NOTIFICATIONS_LOAD_REQUEST' => [
        'type' => 'load_request',
        'title' => 'Load Alert!',
        'message' => 'New request. Immediate response needed.',
    ],

    'CHAT_NOTIFICATION' => [
        'type' => 'chat_notification',
    ],

    'NOTIFICATIONS_KYC_APPROVED' => [
        'type' => 'kyc_approved',
        'title' => 'KYC Alert!',
        'message' => 'Your kyc approved by admin.',
    ],

    'NOTIFICATIONS_KYC_APPROVED_OWN' => [
        'type' => 'kyc_approved',
        'title' => 'KYC Alert!',
        'message' => 'Your kyc process completed successsfully..',
    ],

    'GLOBAL_PUSH_NOTIFICATION' => [
        'type' => 'push_notification',
        'title' => 'Alert!'
    ],
];
