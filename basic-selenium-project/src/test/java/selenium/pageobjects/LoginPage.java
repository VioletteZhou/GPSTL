package selenium.pageobjects;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;

import selenium.Pages;

public class LoginPage extends Pages {
	
	@FindBy(id = "user_login")
	private WebElement username;
	
	@FindBy(id = "user_pass")
	private WebElement password;
	
	@FindBy(id = "wp-submit")
	private WebElement btnSubmit;

	public LoginPage(final WebDriver driver) {
		super(driver);
	}


	
	public void initForm(String label, String value) {
		if("username".equals(label)) {
			waitForElement(username, 50);
			username.sendKeys(value);
		}else if("password".equals(label)) {
			waitForElement(password, 50);
			password.sendKeys(value);
		}else if("btnSubmit".equals(label)) {
			waitForElement(btnSubmit, 50);
			btnSubmit.click();
		}
	}
	
	
	public boolean testElementPresent(final By by) {
		return isElementPresent(by);
	}

}
