<?php

/**
* Scenario : Enable Show Album description.
*/

    use Page\Login as LoginPage;
    use Page\Constants as ConstantsPage;
    use Page\DashboardSettings as DashboardSettingsPage;
    use Page\BuddypressSettings as BuddypressSettingsPage;

    $I = new AcceptanceTester( $scenario );
    $I->wantTo( 'Enable Show Album description.' );

    $loginPage = new LoginPage( $I );
    $loginPage->loginAsAdmin( ConstantsPage::$userName, ConstantsPage::$password );

    $settings = new DashboardSettingsPage( $I );
    $settings->gotoTab( ConstantsPage::$buddypressTab, ConstantsPage::$buddypressTabUrl );
    $settings->verifyEnableStatus( ConstantsPage::$strEnableAlbumLabel, ConstantsPage::$enableAlbumCheckbox );
    $settings->verifyDisableStatus( ConstantsPage::$strShowAlbumDescLabel, ConstantsPage::$albumDescCheckbox );

    $buddypress = new BuddypressSettingsPage( $I );

    $buddypress->createNewAlbum();

    $buddypress->editAlbumDesc();

    $buddypress->gotoAlubmPage();

    $I->scrollTo( ConstantsPage::$mediaPageScrollPos );

    $I->seeElement( ConstantsPage::$firstAlbum );
    $I->click( ConstantsPage::$firstAlbum );

    $I->scrollTo( ConstantsPage::$scrollSelector );

    $I->dontSeeElement( ConstantsPage::$albumDescSelector );

?>
