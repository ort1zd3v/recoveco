// require('./bootstrap');
// import Alpine from 'alpinejs';
// window.Alpine = Alpine;
// Alpine.start();

//Layout
require('./theme.js');
require('./layout/cookie.js');
require('./layout/image_preview.js');
require('./layout/sidebar');
require('./layout/var.js');

//Auth
require('./auth/login.js');

//Mod permissions
require('./mod_permissions/roles_permissions.js');

//Mod Crud maker
require('./crud_maker/functions.js');
require('./crud_maker/filters_datatables.js');
require('./crud_maker/input_autocomplete.js');
require('./crud_maker/input_datepicker.js');
require('./crud_maker/multirow_functions.js');
require('./crud_maker/dropdown_fill_child.js');
require('./crud_maker/modal_quick_add.js');
require('./crud_maker/modal_delete.js');
require('./crud_maker/datatables_customize.js');

//Dashboard
require('./dashboard/collapse_functions.js');

//pos
require('./pos/products_functions.js');
require('./pos/cart_functions.js');
require('./pos/payment_functions.js');
require('./pos/client_functions.js');

require('./reports/export_excel_suppliers.js');
require('./inventories/inventories_functions.js');
require('./reports/export_excel_sellings.js');


//lang files
require('./lang.js');
window.i18n.es = require('./../../lang/es.json');