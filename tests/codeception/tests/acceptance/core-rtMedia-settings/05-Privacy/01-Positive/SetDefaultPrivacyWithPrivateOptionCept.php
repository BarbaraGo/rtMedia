<?php

/**
* Scenario : To set default privacy with private option.
*/

    use Page\Login as LoginPage;
    use Page\Logout as LogoutPage;
    use Page\Constants as ConstantsPage;
    use Page\UploadMedia as UploadMediaPage;
    use Page\DashboardSettings as DashboardSettingsPage;
    use Page\BuddypressSettings as BuddypressSettingsPage;

    $I = new AcceptanceTester( $scenario );
    $I->wantTo( 'To set default privacy with private option' );

    $loginPage = new LoginPage( $I );
    $loginPage->loginAsAdmin( ConstantsPage::$userName, ConstantsPage::$password );

    $settings = new DashboardSettingsPage( $I );
    $settings->gotoTab( ConstantsPage::$privacyTab, ConstantsPage::$privacyTabUrl );
    $settings->verifyEnableStatus( ConstantsPage::$privacyLabel, ConstantsPage::$privacyCheckbox );
    $settings->verifyEnableStatus( ConstantsPage::$privacyUserOverrideLabel, ConstantsPage::$privacyUserOverrideCheckbox );
    $settings->verifySelectOption( ConstantsPage::$defaultPrivacyLabel, ConstantsPage::$privateRadioButton );

    $I->amOnPage( '/wp-admin/admin.php?page=rtmedia-settings#rtmedia-bp' );
    $I->wait( 5 );
    $settings->verifyEnableStatus( ConstantsPage::$strEnableMediaInProLabel, ConstantsPage::$enableMediaInProCheckbox );
    $settings->verifyEnableStatus( ConstantsPage::$strMediaUploadFromActivityLabel, ConstantsPage::$mediaUploadFromActivityCheckbox );

    $buddypress = new BuddypressSettingsPage( $I );
    $buddypress->gotoActivityPage( ConstantsPage::$userName );

    $uploadmedia = new UploadMediaPage( $I );
    $uploadmedia->addStatus();

    $I->seeElement( ConstantsPage::$privacyDropdown );

    if($I->grabValueFrom( ConstantsPage::$privacyDropdown) == '60' ){
        echo nl2br( "Default Privacy --> Private \n" );
    }else{
        echo nl2br( "Test Failed \n" );
    }

    $logout = new LogoutPage( $I );
    $logout->logout();

?>
