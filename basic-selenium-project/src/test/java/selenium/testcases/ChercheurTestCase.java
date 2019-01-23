package selenium.testcases;


import static org.junit.Assert.assertTrue;
import static selenium.utils.annotations.browser.Browsers.CHROME;

import org.junit.Before;
import org.junit.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.support.PageFactory;

import selenium.SeleniumTestWrapper;
import selenium.pageobjects.ChercheurPage;
import selenium.pageobjects.HomePage;
import selenium.pageobjects.LoginPage;
import selenium.pageobjects.PluginCodeSourcePage;
import selenium.pageobjects.ProjetPage;
import selenium.pageobjects.StartPage;
import selenium.pageobjects.WpadminPage;
import selenium.utils.annotations.browser.Browser;

//@BrowserDimension(XLARGE)
@Browser(require = CHROME)
public class ChercheurTestCase extends SeleniumTestWrapper {

	StartPage startPage = PageFactory.initElements(getDriver(), StartPage.class);
	HomePage homePage = PageFactory.initElements(getDriver(), HomePage.class);
	ChercheurPage chercheurPage = PageFactory.initElements(getDriver(), ChercheurPage.class);
	LoginPage loginPage = PageFactory.initElements(getDriver(), LoginPage.class);
	WpadminPage wpadminPage = PageFactory.initElements(getDriver(), WpadminPage.class);
	PluginCodeSourcePage pluginCodeSourcePage = PageFactory.initElements(getDriver(), PluginCodeSourcePage.class);
	ProjetPage projetPage = PageFactory.initElements(getDriver(), ProjetPage.class);
	
	@Before
	public void setup() {
		startPage.open();
	}

	@Test
	public void exampleTestMenuProjet() throws InterruptedException {
		assertTrue(homePage.testElementPresent(By.id("menu-item-21")));
		homePage.clickNaviElement("Projet");	
		assertTrue(projetPage.testElementPresent(By.name("equipename")));
		projetPage.initForm("inputTextSearch", "projet 1");
		assertTrue(projetPage.testElementPresent(By.className("submit_search")));
		projetPage.initForm("btnSearch", "click");
		wpadminPage.takeScreenshot("testProjet");
		
	}
	@Test
	public void exampleTestAdmin() {
		assertTrue(homePage.testElementPresent(By.id("menu-item-41")));
		homePage.clickNaviElement("Login");
		assertTrue(loginPage.testElementPresent(By.id("user_login")));
		assertTrue(loginPage.testElementPresent(By.id("user_pass")));
		assertTrue(loginPage.testElementPresent(By.id("wp-submit")));
		
		//initFormLogin(String label, String value) 
		loginPage.initForm("username", "bidaud");
		loginPage.initForm("password", "root");
		loginPage.initForm("btnSubmit", "click");
		
		assertTrue(wpadminPage.testElementPresent(By.id("wp-admin-bar-my-sites")));
		wpadminPage.initForm("mysites", "click");
		
		
		
		//assertTrue(wpadminPage.testElementPresent(By.id("wp-admin-bar-dashboard")));
		//wpadminPage.initForm("dashboard", "click");
		
		assertTrue(wpadminPage.testElementPresent(By.cssSelector("#menu-plugins > a > div.wp-menu-name")));
		wpadminPage.initForm("plugins", "click");
		
		//plugin : Add code source
		assertTrue(wpadminPage.testElementPresent(By.cssSelector("#the-list > tr:nth-child(1) > td.plugin-title.column-primary > div > span")));
		wpadminPage.initForm("addCodeSource", "activate"); //deactivate
		
		//Click menu code source
		assertTrue(wpadminPage.testElementPresent(By.cssSelector("#toplevel_page_add-code-source > a > div.wp-menu-name")));
		wpadminPage.initForm("menuCodeSource", "click");
		
		// search : radio btn by user
		assertTrue(wpadminPage.testElementPresent(By.cssSelector("#group1 > div:nth-child(2) > input[type=\"radio\"]")));
		pluginCodeSourcePage.initForm("radioBtnByUser", "click");
		
		
		// search : init input text search
		assertTrue(wpadminPage.testElementPresent(By.id("q")));
		pluginCodeSourcePage.initForm("inputTextSearch", "test");
		
		// search : click btn search
		assertTrue(wpadminPage.testElementPresent(By.cssSelector("#wpbody-content > form > input[type=\"submit\"]")));
		pluginCodeSourcePage.initForm("btnSearch", "click");
				
		// search : add code source
		assertTrue(wpadminPage.testElementPresent(By.cssSelector("#wpbody-content > table:nth-child(10) > tbody > tr > td:nth-child(3) > form > input[type=\"submit\"]:nth-child(9)")));
		pluginCodeSourcePage.initForm("addCodeSource", "click");
				
	// utilisation des id si on a modifier les rl ou les changement des templates//
		
		//plugin : Add videos
		assertTrue(wpadminPage.testElementPresent(By.cssSelector("#\\39")));
		wpadminPage.initForm("addProjet", "click");
		
		assertTrue(wpadminPage.testElementPresent(By.id("wp-admin-bar-site-name")));
		wpadminPage.initForm("currentUser", "click");
		
		wpadminPage.takeScreenshot("testAdmin");
		/*
		 * 
		 * @FindBy(id = "wp-admin-bar-dashboard")
	private WebElement dashboard;
		 */
		//chercheurPage.takeScreenshot("C:\\screenshot.png");
		//chercheurPage.initNamechercheur("amar");
		//chercheurPage.testChercheur();
		//chercheurPage.takeScreenshot("C:\\screenshot2.png");
		
	}
}
