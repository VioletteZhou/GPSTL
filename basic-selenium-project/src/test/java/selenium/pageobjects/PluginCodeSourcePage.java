package selenium.pageobjects;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.How;

import selenium.Pages;

public class PluginCodeSourcePage extends Pages {
	
	@FindBy(how = How.CSS, using = "#group1 > div:nth-child(2) > input[type=\"radio\"]")
	private WebElement radioBtnByUser;
	
	@FindBy(id = "q")
	private WebElement inputTextSearch;
	
	@FindBy(how = How.CSS, using = "#wpbody-content > form > input[type=\"submit\"]")
	private WebElement btnSearch;
	
	@FindBy(how = How.CSS, using = "#wpbody-content > table:nth-child(10) > tbody > tr > td:nth-child(3) > form > input[type=\"submit\"]:nth-child(9)")
	private WebElement addCodeSource;
	
	
	
	public PluginCodeSourcePage(final WebDriver driver) {
		super(driver);
	}


	
	public void initForm(String label, String value) {
		if("radioBtnByUser".equals(label)) {
			waitForElement(radioBtnByUser, 50);
			radioBtnByUser.click();
		}else if("inputTextSearch".equals(label)) {
			waitForElement(inputTextSearch, 50);
			inputTextSearch.sendKeys(value);
		}else if("btnSearch".equals(label)) {
			waitForElement(btnSearch, 50);
			btnSearch.click();
		}else if("addCodeSource".equals(label)) {
			waitForElement(addCodeSource, 50);
			if("submit".equals(addCodeSource.getAttribute("type"))) {
				addCodeSource.click();
			}
		}
		
		

	}
	
	
	public boolean testElementPresent(final By by) {
		return isElementPresent(by);
	}

}
