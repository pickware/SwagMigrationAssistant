<?php declare(strict_types=1);

return [
    0 => [
        'id' => '0',
        'password' => '$2y$10$.N0h/Ez04.DBAf3QlwL8ie2/JsslAut3kgtoLE.ZcDZ8ckgmLuQf6',
        'encoder' => 'bcrypt',
        'email' => 'testing@shopware.com',
        'active' => '1',
        'accountmode' => '1',
        'confirmationkey' => '',
        'paymentID' => '3',
        'doubleOptinRegister' => '0',
        'doubleOptinEmailSentDate' => null,
        'doubleOptinConfirmDate' => null,
        'firstlogin' => '2018-10-08',
        'lastlogin' => '2018-10-08 15:48:51',
        'sessionID' => '5vug2qno0dd6n441mle0ht31at',
        'newsletter' => '0',
        'validation' => '',
        'affiliate' => '0',
        'customergroup' => 'EK',
        'paymentpreset' => '0',
        'language' => '1',
        'subshopID' => '1',
        'referer' => '',
        'pricegroupID' => null,
        'internalcomment' => '',
        'failedlogins' => '0',
        'lockeduntil' => null,
        'default_billing_address_id' => '5',
        'default_shipping_address_id' => '5',
        'title' => null,
        'salutation' => 'mr',
        'birthday' => null,
        'customernumber' => '20005',
        'login_token' => '410a6677-85af-4292-8450-af4b2b29bdbc.1',
        'changed' => '2018-10-08 15:48:25',
        '_locale' => 'de-DE',
        'customerGroupId' => '1',
    ],
    1 => [
        'id' => '1',
        'password' => '$2y$10$h6bMe5mAYLQyFqPPOxE/XubVrMsojHmVX00aOkk3y0zIKC/G55hdG',
        'encoder' => 'bcrypt',
        'email' => 'test@example.com',
        'active' => '1',
        'accountmode' => '0',
        'confirmationkey' => '',
        'paymentID' => '5',
        'doubleOptinRegister' => '0',
        'doubleOptinEmailSentDate' => null,
        'doubleOptinConfirmDate' => null,
        'firstlogin' => '2018-08-09',
        'lastlogin' => '2018-08-09 15:12:38',
        'sessionID' => 'rb26jfdp4tlte4kf10cjam7g75',
        'newsletter' => '0',
        'validation' => '',
        'affiliate' => '0',
        'customergroup' => 'EK',
        'paymentpreset' => '0',
        'language' => '1',
        'subshopID' => '1',
        'referer' => '',
        'pricegroupID' => null,
        'internalcomment' => '',
        'failedlogins' => '0',
        'lockeduntil' => null,
        'title' => null,
        'salutation' => 'mr',
        'firstname' => 'Max',
        'lastname' => 'Mustermann',
        'birthday' => null,
        'customernumber' => '20003',
        'login_token' => '04ff9402-39c3-4d5f-a754-b9e323014ab3.1',
        'changed' => '2018-08-09 15:12:33',
        'attributes' => [
            'id' => '1',
            'userID' => '1',
            'test' => 'asdfasdf',
        ],
        'customerGroupId' => '1',
        'defaultpayment' => [
            'id' => '5',
            'name' => 'prepayment',
            'description' => 'Vorkasse',
            'template' => 'prepayment.tpl',
            'class' => 'prepayment.php',
            'table' => '',
            'hide' => '0',
            'additionaldescription' => '',
            'debit_percent' => '0',
            'surcharge' => '0',
            'surchargestring' => '',
            'position' => '1',
            'active' => '1',
            'esdactive' => '0',
            'embediframe' => '',
            'hideprospect' => '0',
            'action' => null,
            'pluginID' => null,
            'source' => null,
            'mobile_inactive' => '0',
        ],
        'customerlanguage' => [
            'id' => '1',
            'locale' => 'de-DE',
            'language' => 'Deutsch',
            'territory' => 'Deutschland',
        ],
        '_locale' => 'de-DE',
        'addresses' => [
            0 => [
                'id' => '1',
                'user_id' => '1',
                'company' => 'Muster GmbH',
                'department' => null,
                'salutation' => 'mr',
                'title' => null,
                'firstname' => 'Max',
                'lastname' => 'Mustermann',
                'street' => 'Musterstr. 55',
                'zipcode' => '55555',
                'city' => 'Musterhausen',
                'country_id' => '2',
                'state_id' => '3',
                'ustid' => null,
                'phone' => '05555 / 555555',
                'additional_address_line1' => null,
                'additional_address_line2' => null,
                'country' => [
                    'id' => '2',
                    'countryname' => 'Deutschland',
                    'countryiso' => 'DE',
                    'areaID' => '1',
                    'countryen' => 'GERMANY',
                    'position' => '1',
                    'notice' => '',
                    'taxfree' => '0',
                    'taxfree_ustid' => '0',
                    'taxfree_ustid_checked' => '0',
                    'active' => '1',
                    'iso3' => 'DEU',
                    'display_state_in_registration' => '0',
                    'force_state_in_registration' => '0',
                ],
                'state' => [
                    'id' => '3',
                    'countryID' => '2',
                    'name' => 'Nordrhein-Westfalen',
                    'shortcode' => 'NW',
                    'position' => '0',
                    'active' => '1',
                ],
            ],
            1 => [
                'id' => '3',
                'user_id' => '1',
                'company' => 'shopware AG',
                'department' => null,
                'salutation' => 'mr',
                'title' => null,
                'firstname' => 'Max',
                'lastname' => 'Mustermann',
                'street' => 'Mustermannstraße 92',
                'zipcode' => '48624',
                'city' => 'Schöppingen',
                'country_id' => '2',
                'state_id' => null,
                'ustid' => null,
                'phone' => null,
                'additional_address_line1' => null,
                'additional_address_line2' => null,
                'country' => [
                    'id' => '2',
                    'countryname' => 'Deutschland',
                    'countryiso' => 'DE',
                    'areaID' => '1',
                    'countryen' => 'GERMANY',
                    'position' => '1',
                    'notice' => '',
                    'taxfree' => '0',
                    'taxfree_ustid' => '0',
                    'taxfree_ustid_checked' => '0',
                    'active' => '1',
                    'iso3' => 'DEU',
                    'display_state_in_registration' => '0',
                    'force_state_in_registration' => '0',
                ],
            ],
            2 => [
                'id' => '4',
                'user_id' => '1',
                'company' => null,
                'department' => null,
                'salutation' => 'mr',
                'title' => null,
                'firstname' => 'Max',
                'lastname' => 'Mustermann',
                'street' => 'Musterstraße 3',
                'zipcode' => '48624',
                'city' => 'Schöppingen',
                'country_id' => '2',
                'state_id' => null,
                'ustid' => null,
                'phone' => null,
                'additional_address_line1' => null,
                'additional_address_line2' => null,
                'country' => [
                    'id' => '2',
                    'countryname' => 'Deutschland',
                    'countryiso' => 'DE',
                    'areaID' => '1',
                    'countryen' => 'GERMANY',
                    'position' => '1',
                    'notice' => '',
                    'taxfree' => '0',
                    'taxfree_ustid' => '0',
                    'taxfree_ustid_checked' => '0',
                    'active' => '1',
                    'iso3' => 'DEU',
                    'display_state_in_registration' => '0',
                    'force_state_in_registration' => '0',
                ],
            ],
        ],
    ],
    2 => [
        'id' => '2',
        'password' => '$2y$10$h6bMe5mAYLQyFqPPOxE/XubVrMsojHmVX00aOkk3y0zIKC/G55hdG',
        'encoder' => 'bcrypt',
        'email' => 'testing@example.com1',
        'active' => '1',
        'accountmode' => '1',
        'confirmationkey' => '',
        'paymentID' => '5',
        'doubleOptinRegister' => '0',
        'doubleOptinEmailSentDate' => null,
        'doubleOptinConfirmDate' => null,
        'firstlogin' => '2018-08-09',
        'lastlogin' => '2018-08-09 15:12:38',
        'sessionID' => 'rb26jfdp4tlte4kf10cjam7g75',
        'newsletter' => '0',
        'validation' => '',
        'affiliate' => '0',
        'customergroup' => 'EK',
        'paymentpreset' => '0',
        'language' => '1',
        'subshopID' => '1',
        'referer' => '',
        'pricegroupID' => null,
        'internalcomment' => '',
        'failedlogins' => '0',
        'lockeduntil' => null,
        'default_billing_address_id' => '3',
        'default_shipping_address_id' => '1',
        'title' => null,
        'salutation' => 'mr',
        'firstname' => 'Max',
        'lastname' => 'Mustermann',
        'birthday' => null,
        'customernumber' => '20003',
        'login_token' => '04ff9402-39c3-4d5f-a754-b9e323014ab3.1',
        'changed' => '2018-08-09 15:12:33',
        'attributes' => [
            'id' => '1',
            'userID' => '1',
            'test' => 'asdfasdf',
        ],
        'customerGroupId' => '1',
        'defaultpayment' => [
            'id' => '5',
            'name' => 'prepayment',
            'description' => 'Vorkasse',
            'template' => 'prepayment.tpl',
            'class' => 'prepayment.php',
            'table' => '',
            'hide' => '0',
            'additionaldescription' => '',
            'debit_percent' => '0',
            'surcharge' => '0',
            'surchargestring' => '',
            'position' => '1',
            'active' => '1',
            'esdactive' => '0',
            'embediframe' => '',
            'hideprospect' => '0',
            'action' => null,
            'pluginID' => null,
            'source' => null,
            'mobile_inactive' => '0',
        ],
        'customerlanguage' => [
            'id' => '1',
            'locale' => 'de-DE',
            'language' => 'Deutsch',
            'territory' => 'Deutschland',
        ],
        '_locale' => 'de-DE',
        'addresses' => [
            0 => [
                'id' => '1',
                'user_id' => '1',
                'company' => 'Muster GmbH',
                'department' => null,
                'salutation' => 'mr',
                'title' => null,
                'street' => 'Musterstr. 55',
                'zipcode' => '55555',
                'city' => 'Musterhausen',
                'country_id' => '2',
                'state_id' => '3',
                'ustid' => null,
                'phone' => '05555 / 555555',
                'additional_address_line1' => null,
                'additional_address_line2' => null,
                'country' => [
                    'id' => '2',
                    'countryname' => 'Deutschland',
                    'countryiso' => 'DE',
                    'areaID' => '1',
                    'countryen' => 'GERMANY',
                    'position' => '1',
                    'notice' => '',
                    'taxfree' => '0',
                    'taxfree_ustid' => '0',
                    'taxfree_ustid_checked' => '0',
                    'active' => '1',
                    'iso3' => 'DEU',
                    'display_state_in_registration' => '0',
                    'force_state_in_registration' => '0',
                ],
                'state' => [
                    'id' => '3',
                    'countryID' => '2',
                    'name' => 'Nordrhein-Westfalen',
                    'shortcode' => 'NW',
                    'position' => '0',
                    'active' => '1',
                ],
            ],
            1 => [
                'id' => '3',
                'user_id' => '1',
                'company' => 'shopware AG',
                'department' => null,
                'salutation' => 'mr',
                'title' => null,
                'firstname' => 'Max',
                'lastname' => 'Mustermann',
                'street' => 'Mustermannstraße 92',
                'zipcode' => '48624',
                'city' => 'Schöppingen',
                'country_id' => '2',
                'state_id' => null,
                'ustid' => null,
                'phone' => null,
                'additional_address_line1' => null,
                'additional_address_line2' => null,
                'country' => [
                    'id' => '2',
                    'countryname' => 'Deutschland',
                    'countryiso' => 'DE',
                    'areaID' => '1',
                    'countryen' => 'GERMANY',
                    'position' => '1',
                    'notice' => '',
                    'taxfree' => '0',
                    'taxfree_ustid' => '0',
                    'taxfree_ustid_checked' => '0',
                    'active' => '1',
                    'iso3' => 'DEU',
                    'display_state_in_registration' => '0',
                    'force_state_in_registration' => '0',
                ],
            ],
            2 => [
                'id' => '4',
                'user_id' => '1',
                'company' => null,
                'department' => null,
                'salutation' => 'mr',
                'title' => null,
                'firstname' => 'Max',
                'lastname' => 'Mustermann',
                'street' => 'Musterstraße 3',
                'zipcode' => '48624',
                'city' => 'Schöppingen',
                'country_id' => '2',
                'state_id' => null,
                'ustid' => null,
                'phone' => null,
                'additional_address_line1' => null,
                'additional_address_line2' => null,
                'country' => [
                    'id' => '2',
                    'countryname' => 'Deutschland',
                    'countryiso' => 'DE',
                    'areaID' => '1',
                    'countryen' => 'GERMANY',
                    'position' => '1',
                    'notice' => '',
                    'taxfree' => '0',
                    'taxfree_ustid' => '0',
                    'taxfree_ustid_checked' => '0',
                    'active' => '1',
                    'iso3' => 'DEU',
                    'display_state_in_registration' => '0',
                    'force_state_in_registration' => '0',
                ],
            ],
        ],
    ],
    3 => [
        'id' => '3',
        'password' => '$2y$10$h6bMe5mAYLQyFqPPOxE/XubVrMsojHmVX00aOkk3y0zIKC/G55hdG',
        'encoder' => 'bcrypt',
        'email' => 'testing@example.com2',
        'active' => '1',
        'accountmode' => '1',
        'confirmationkey' => '',
        'paymentID' => '5',
        'doubleOptinRegister' => '0',
        'doubleOptinEmailSentDate' => null,
        'doubleOptinConfirmDate' => null,
        'firstlogin' => '2018-08-09',
        'lastlogin' => '2018-08-09 15:12:38',
        'sessionID' => 'rb26jfdp4tlte4kf10cjam7g75',
        'newsletter' => '0',
        'validation' => '',
        'affiliate' => '0',
        'customergroup' => 'EK',
        'paymentpreset' => '0',
        'language' => '1',
        'subshopID' => '1',
        'referer' => '',
        'pricegroupID' => null,
        'internalcomment' => '',
        'failedlogins' => '0',
        'lockeduntil' => null,
        'default_billing_address_id' => '3',
        'default_shipping_address_id' => '1',
        'title' => null,
        'salutation' => 'mr',
        'firstname' => 'Max',
        'lastname' => 'Mustermann',
        'birthday' => null,
        'customernumber' => '20003',
        'login_token' => '04ff9402-39c3-4d5f-a754-b9e323014ab3.1',
        'changed' => '2018-08-09 15:12:33',
        'attributes' => [
            'id' => '1',
            'userID' => '1',
            'test' => 'asdfasdf',
        ],
        'customerGroupId' => '1',
        'defaultpayment' => [
            'id' => '5',
            'name' => 'prepayment',
            'description' => 'Vorkasse',
            'template' => 'prepayment.tpl',
            'class' => 'prepayment.php',
            'table' => '',
            'hide' => '0',
            'additionaldescription' => '',
            'debit_percent' => '0',
            'surcharge' => '0',
            'surchargestring' => '',
            'position' => '1',
            'active' => '1',
            'esdactive' => '0',
            'embediframe' => '',
            'hideprospect' => '0',
            'action' => null,
            'pluginID' => null,
            'source' => null,
            'mobile_inactive' => '0',
        ],
        'customerlanguage' => [
            'id' => '1',
            'locale' => 'de-DE',
            'language' => 'Deutsch',
            'territory' => 'Deutschland',
        ],
        '_locale' => 'de-DE',
    ],
];
