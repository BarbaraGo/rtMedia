<?php

/**
* Scenario : To set photo large height and width when Crop is enabled.
*/

    use Page\Login as LoginPage;
    use Page\Logout as LogoutPage;
    use Page\DashboardSettings as DashboardSettingsPage;
    use Page\UploadMedia as UploadMediaPage;
    use Page\Constants as ConstantsPage;
    use Page\BuddypressSettings as BuddypressSettingsPage;

    $scrollToDirectUpload = ConstantsPage::$masonaryCheckbox;

    $I = new AcceptanceTester($scenario);
    $I->wantTo( 'To set photo large height and width when Crop is enabled.' );

    $loginPage = new LoginPage( $I );
    $loginPage->loginAsAdmin( ConstantsPage::$userName, ConstantsPage::$password );

    $settings = new DashboardSettingsPage( $I );
    $settings->gotoTab( ConstantsPage::$mediaSizesTab, ConstantsPage::$mediaSizesTabUrl );
    $settings->setMediaSize( ConstantsPage::$photoLargeLabel, ConstantsPage::$largeWidthTextbox, ConstantsPage::$LargeWidth, ConstantsPage::$largeHeightTextbox, ConstantsPage::$LargeHeight );

    $I->scrollTo( ConstantsPage::$topSaveButton );

    $settings->verifyEnableStatus( ConstantsPage::$photoLargeLabel, ConstantsPage::$largeCropChrckbox );

    $I->amOnPage( '/wp-admin/admin.php?page=rtmedia-settings#rtmedia-display' );
    $I->wait( 5 );
    $settings->verifyEnableStatus( ConstantsPage::$strLightboxCheckboxLabel,ConstantsPage::$lightboxCheckbox);
    $settings->verifyDisableStatus( ConstantsPage::$strDirectUplaodCheckboxLabel, ConstantsPage::$directUploadCheckbox, $scrollToDirectUpload );

    $I->amOnPage( '/wp-admin/admin.php?page=rtmedia-settings#rtmedia-types' );
    $I->wait( 5 );
    $settings->verifyEnableStatus( ConstantsPage::$photoLabel, ConstantsPage::$photoCheckbox );

    $buddypress = new BuddypressSettingsPage( $I );
    $buddypress->gotoMedia( ConstantsPage::$userName );

    $uploadmedia = new UploadMediaPage( $I );
    $uploadmedia->uploadMediaUsingStartUploadButton( ConstantsPage::$userName, ConstantsPage::$imageName, ConstantsPage::$photoLink );

    $I->reloadPage();
    $I->waitForElement( ConstantsPage::$profilePicture, 5 );

    $I->scrollTo( ConstantsPage::$mediaPageScrollPos );

    $uploadmedia->fisrtThumbnailMedia();

    echo $I->grabAttributeFrom( ConstantsPage::$thumbnailSelector, 'width' );
    echo $I->grabAttributeFrom( ConstantsPage::$thumbnailSelector, 'height' );

    $logout = new LogoutPage( $I );
    $logout->logout();
?>
