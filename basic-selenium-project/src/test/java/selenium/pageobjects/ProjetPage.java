package selenium.pageobjects;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.How;

import selenium.Pages;

public class ProjetPage extends Pages {

	public ProjetPage(final WebDriver driver) {
		super(driver);
	}
	
	@FindBy(name = "equipename")
	private WebElement nameProjet;
	
	@FindBy(how = How.CLASS_NAME, using = "submit_search")
	private WebElement submitSearch;
	
	public void initForm(String label, String value) {
		if("inputTextSearch".equals(label)) {
			waitForElement(nameProjet, 50);
			nameProjet.sendKeys(value);
		}else if("btnSearch".equals(label)) {
			waitForElement(submitSearch, 50);
			submitSearch.click();
		}
	}
	
	
	public boolean testElementPresent(final By by) {
		return isElementPresent(by);
	}
	
	

}
