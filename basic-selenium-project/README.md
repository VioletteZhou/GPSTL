

# basic-selenium-project
This project is written in java and will serve an example of implementing a Selenium test project with Selenium3 and Maven.
Everything is set up and tests can be added straight away.
Used Testrunner is the Failsafe plugin.


## Implemented Browsers
The awesome [webdrivermanager] it supports the following browsers and automatically downloads OS specific binaries for:
* Chrome
* Firefox


#### The Webdriver Setup
The webdriver setup is based on the [WebDriverBuilder]
to have a separation between driver instantiation and browser specific settings.

## Page Objects Pattern
page object pattern is used to have reusable WebElements/small helper methods seperated from actual test classes and give the opportunity to have nice structured and easily readable tests (without the overhead of BDD-Frameworks like Cucumber or JBehave).

## Annotations
Beside a bunch of the basic-selenium-project provides some nice custom annotations to comfortably set some test conditions and/or assumptions


#### @Browser
The `@Browser` annotation includes or excludes certain browsers from the test execution

skip test if browser equals firefox:

The browser require option is working equivalent to the skip option and also supports list of browsers

#### @BrowserDimension
If you want to test a responsive website it can be handy to set the browsers to some specific viewports.
To configure your breakpoints just edit them in the [test_data.properties]

Resizing the browser window for specific tests can be done by e.g.:

#### @UserAgent
UserAgents can be overwritten and give the possibility to emulate the behaviour of an website if special devices visiting it.


