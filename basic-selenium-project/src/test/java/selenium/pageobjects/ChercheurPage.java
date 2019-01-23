package selenium.pageobjects;

import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.How;

import selenium.Pages;

public class ChercheurPage extends Pages {

	public ChercheurPage(final WebDriver driver) {
		super(driver);
	}
	
	@FindBy(how = How.CLASS_NAME, using = "project_feature_img")
	private List<WebElement> chercheurs;
	
	@FindBy(id = "myTabContent")
	private WebElement myTabContent;
	
	@FindBy(name = "namechercheur")
	private WebElement namechercheur;
	
	@FindBy(how = How.CLASS_NAME, using = "submit_search")
	private WebElement submitSearch;
	
	
	public void initNamechercheur(String name) {
		waitForElement(namechercheur, 50);
		namechercheur.sendKeys(name);
		submitSearch.click();
	}
	
	public boolean testElementPresent(final By by) {
		return isElementPresent(by);
	}
	
	public void testChercheur() {
		waitForElement(myTabContent, 50);
		int i = 0;
		for (WebElement item : chercheurs) {
			if (i == 0){
				item.click();
			}
			i++;
		}
	}
	
	

}
