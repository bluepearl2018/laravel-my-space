<?php

return [
    'name' => 'Laravel My Space',
    'description' => 'Laravel My Space is Eutranet\'s 7th core package',
    'tables' => [
        'user_infos',
        'user_payments',
        'user_social_medias',
        'my_space_general_terms',
        'dashboard_menus',
    ],
    /**
     * -------------------------------------------------------------
     * Default migrations for My Space Package
     * -------------------------------------------------------------
     * This array should be used to check if all tables have been migrated
     */
    'migrations' => [
        'add_deletion_specific_fields_to_users_table',
        'add_accepted_general_terms_on_to_users_table',
        'add_has_accepted_my_space_general_terms_on_to_users_table',
        'add_is_locked_to_users_table',
        'add_is_valid_to_users_table',
        'add_profile_specific_fields_to_users_table',
        'create_contactables_table',
        'create_dashboard_menus_table',
        'create_my_space_general_terms_table',
        'create_user_infos_table',
        'create_user_payments_table',
        'create_user_social_medias_table',
    ],
    /**
     * -------------------------------------------------------------
     * Factories used at package installation
     * -------------------------------------------------------------
     *
     */
    'factories' => [
        'DashboardMenuFactory' => [
            'should_create_dummy_items' => 1 // Does create ONE dummy item, which is Install check
        ],
    ],

    /**
     * -------------------------------------------------------------
     * My Space Models
     * -------------------------------------------------------------
     *
     */
    'models' => [
        'DashboardMenu',
        'MySpaceGeneralTerm',
        'MySpaceUser',
        'UserPayment',
        'UserSocialMedia'
    ],
];
