package selenium.pageobjects;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.How;

import selenium.Pages;

public class WpadminPage extends Pages {
	
	@FindBy(id = "wp-admin-bar-my-sites")
	private WebElement mySites;
	
	@FindBy(id = "wp-admin-bar-site-name")
	private WebElement currentUser;
	
	@FindBy(id = "wp-admin-bar-blog-120-d")
	private WebElement dashboard;
	
	@FindBy(how = How.CSS, using = "#menu-plugins > a > div.wp-menu-name")
	private WebElement plugins;
	
	@FindBy(how = How.CSS, using = "#the-list > tr:nth-child(1) > td.plugin-title.column-primary > div > span")
	private WebElement addCodeSource;
	
	@FindBy(how = How.CSS, using = "#the-list > tr:nth-child(3) > td.plugin-title.column-primary > div > span")
	private WebElement addVideos;
	
	@FindBy(how = How.CSS, using = "#toplevel_page_add-code-source > a > div.wp-menu-name")
	private WebElement menuCodeSource;
	
	@FindBy(how = How.CSS, using = "#\\39")
	private WebElement projet;
	
	

	public WpadminPage(final WebDriver driver) {
		super(driver);
	}


	
	public void initForm(String label, String value) {
		if("mysites".equals(label)) {
			waitForElement(mySites, 50);
			mySites.click();
		}else if("currentUser".equals(label)) {
				waitForElement(currentUser, 50);
				currentUser.click();
		}else if("dashboard".equals(label)) {
			waitForElement(dashboard, 50);
			dashboard.click();
		}else if("plugins".equals(label)) {
			waitForElement(plugins, 50);
			plugins.click();
		}else if("addCodeSource".equals(label)) {
			waitForElement(addCodeSource, 50);
			if(value.equals(addCodeSource.getAttribute("class"))) {
				addCodeSource.click();
			}
		}else if("addVideos".equals(label)) {
			waitForElement(addVideos, 50);
			if(value.equals(addVideos.getAttribute("class"))) {
				addVideos.click();
			}
		}else if("menuCodeSource".equals(label)) {
			waitForElement(menuCodeSource, 50);
			menuCodeSource.click();
		}else if("addProjet".equals(label)) {
			waitForElement(projet, 50);
			if(projet.getAttribute("checked") == null || !"true".equals(projet.getAttribute("checked"))) {
				projet.click();
			}
			
			
		}
		
		
		
		
		
		
		
		
		
		
	}
	
	
	public boolean testElementPresent(final By by) {
		return isElementPresent(by);
	}

}
