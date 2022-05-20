# Tweaks to allow vTiger work under PHP 5.4/5.6

* {WEB_ROOT}/vtiger/include/utils/CommonUtils.php on line 1630
  * change `$FILES_global` to something like `$FILES_global` in the SaveImage function's parameter list
* {WEB_ROOT}/vtiger/modules/Users/Authenticate.php on line 70
  * `session_unregister('variable') => unset($_SESSION['variable'])`
* {WEB_ROOT}/vtiger/include/php_writeexcel/class.writeexcel_formula.inc.php on line 169
  * change initial declaration of `$this->_ext_sheets` to stdClass() on/around line 
* {WEB_ROOT}/vtiger/modules/Accounts/Accounts.js around line 118
  * in the `set_return_contact_address` function, change `window.opener.document.QcEditView` to `window.opener.document.EditView`
  * Not necessarily a PHP 5.4/5.6 fix, but probably more of a compatibility issue with newer browsers… 🤔
