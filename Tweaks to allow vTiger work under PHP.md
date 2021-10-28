# Tweaks to allow vTiger work under PHP 5.4/5.6

* {WEB_ROOT}/vtiger/include/utils/CommonUtils.php on line 1630
  * change `$FILES_global` to something like `$FILES_global` in the SaveImage function's parameter list
* {WEB_ROOT}/vtiger/modules/Users/Authenticate.php on line 70
  * `session_unregister('variable') => unset($_SESSION['variable'])`
* {WEB_ROOT}/vtiger/include/php_writeexcel/class.writeexcel_formula.inc.php on line 169
  * change initial declaration of `$this->_ext_sheets` to stdClass() on/around line 

