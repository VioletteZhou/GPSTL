package selenium.pageobjects;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;

import selenium.Pages;

public class HomePage extends Pages {

	public HomePage(final WebDriver driver) {
		super(driver);
	}

	@FindBy(css = ".counter")
	private WebElement counter;
	
	@FindBy(id = "menu-item-46")
	private WebElement laboratoire;
	
	@FindBy(id = "menu-item-21")
	private WebElement project;
	
	@FindBy(id = "menu-item-20")
	private WebElement equipe;
	
	@FindBy(id = "menu-item-19")
	private WebElement chercheur;
	
	@FindBy(id = "menu-item-41")
	private WebElement login;
	
	

	public void clickNaviElement(String naviElement) {
		if("Chercheur".equals(naviElement)) {
			waitForElement(chercheur, 50);
			chercheur.click();
		} else if("Login".equals(naviElement)) {
			waitForElement(login, 50);
			login.click();
		}else if("Projet".equals(naviElement)) {
			waitForElement(project, 50);
			project.click();
		}
		
		
		
	}

	public String getMenu(){
		return getTestData("menu.chercheur");
	}
	
	public boolean testElementPresent(final By by) {
		return isElementPresent(by);
	}
}
