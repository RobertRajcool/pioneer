*Incident Reports
===========
**Dependency:**

*  node v4.x.x or higher 

*    npm 3.x.x or higher

*    typescript 1.8.x or higher

*    symfony 2.8.x with dependency


**
Installation:** 

 **Step1**: clone this Repo

 **Step2**: move to your project directory(cd  FIReports)

 **Step3**: make php composer.phar install

 **step4**: move web folder(cd web)

 **step5**: npm install (install assets angular2 + typescript)

 **step6**: make apache conf as same as in apache_config.conf(web/apache_config.conf)*1.

**step7**: make doctrine:schema:update --force

**step8**: compile your typescript file by using npm run tsc

**step9**: dump all routes to frontend by using php app/console fos:js-routing:dump