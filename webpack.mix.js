const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
	/** Scripts */
		//Jquery
		.scripts('node_modules/jquery/dist/jquery.js', 'public/js/jquery/jquery.js')
		//Jquery UI
		.scripts('node_modules/jquery-ui-dist/jquery-ui.js', 'public/js/jquery/jquery-ui.js')
		//Bootstrap
		.scripts('node_modules/@popperjs/core/dist/umd/popper.js', 'public/js/popperjs/popper.js')
		.copy('node_modules/@popperjs/core/dist/umd/popper.js.map', 'public/js/popperjs/popper.js.map')
		.scripts('node_modules/bootstrap/dist/js/bootstrap.js', 'public/js/bootstrap/bootstrap.js')
		.copy('node_modules/bootstrap/dist/js/bootstrap.js.map', 'public/js/bootstrap/bootstrap.js.map')
		
		//Highcharts
		.scripts('node_modules/highcharts/highcharts.js', 'public/js/highcharts/highcharts.js')
		.copy('node_modules/highcharts/highcharts.js.map', 'public/js/highcharts/highcharts.js.map')
		.scripts('node_modules/highcharts/modules/exporting.js', 'public/js/highcharts/exporting.js')
		.copy('node_modules/highcharts/modules/exporting.js.map', 'public/js/highcharts/exporting.js.map')
		.scripts('node_modules/highcharts/highcharts-more.js', 'public/js/highcharts/highcharts-more.js')
		.copy('node_modules/highcharts/highcharts-more.js.map', 'public/js/highcharts/highcharts-more.js.map')
		.scripts('node_modules/highcharts/modules/accessibility.js', 'public/js/highcharts/accessibility.js')
		.copy('node_modules/highcharts/modules/accessibility.js.map', 'public/js/highcharts/accessibility.js.map')
		.scripts('node_modules/highcharts/modules/export-data.js', 'public/js/highcharts/export-data.js')
		.copy('node_modules/highcharts/modules/export-data.js.map', 'public/js/highcharts/export-data.js.map')

		//Datatables
		.scripts('node_modules/datatables.net/js/jquery.dataTables.js', 'public/js/datatables/jquery.dataTables.js')
		
		//Datatables buttons
		.scripts('node_modules/datatables.net-buttons/js/dataTables.buttons.js', 'public/js/datatables/dataTables.buttons.js')
		.scripts('node_modules/datatables.net-buttons/js/buttons.colVis.js', 'public/js/datatables/buttons.colVis.js')
		.scripts('node_modules/datatables.net-buttons/js/buttons.flash.js', 'public/js/datatables/buttons.flash.js')
		.scripts('node_modules/datatables.net-buttons/js/buttons.html5.js', 'public/js/datatables/buttons.html5.js')
		.scripts('node_modules/datatables.net-buttons/js/buttons.print.js', 'public/js/datatables/buttons.print.js')
		.scripts('node_modules/datatables.net-buttons-bs5/js/buttons.bootstrap5.js', 'public/js/datatables/buttons.bootstrap5.js')

		.scripts('vendor/yajra/laravel-datatables-buttons/src/resources/assets/buttons.server-side.js', 'public/js/datatables/buttons.server-side.js')

		.copy('resources/js/datatables_Spanish.json', 'public/js/datatables/datatables_Spanish.json')

		//Datatables responsive
		.scripts('node_modules/datatables.net-responsive/js/dataTables.responsive.min.js', 'public/js/datatables/dataTables.responsive.min.js')
		
		//Moment
		.scripts('node_modules/moment/min/moment-with-locales.js', 'public/js/moment/moment-with-locales.js')
		.scripts('node_modules/moment/min/moment-with-locales.min.js.map', 'public/js/moment/moment-with-locales.js.map')

		//Calendar
		.scripts('resources/js/tempusdominus-bootstrap-4.min.js', 'public/js/tempusdominus-bootstrap-4.js')
		.scripts('node_modules/jszip/dist/jszip.js', 'public/js/datatables/jszip.js')

		.scripts('node_modules/metismenu/dist/metisMenu.js', 'public/js/metismenu/dist/metisMenu.js')
		.copy('node_modules/metismenu/dist/metisMenu.js.map', 'public/js/metismenu/dist/metisMenu.js.map')
		.scripts('node_modules/simplebar/dist/simplebar.js', 'public/js/simplebar/dist/simplebar.js')
		.scripts('node_modules/node-waves/dist/waves.js', 'public/js/node-waves/dist/waves.js')

		.scripts('resources/js/configuration/config_general.js', 'public/js/configuration/config_general.js')
		.scripts('resources/js/configuration/config_tables.js', 'public/js/configuration/config_tables.js')
		.scripts('resources/js/configuration/config_pos.js', 'public/js/configuration/config_pos.js')

		//Owl carousel
		.scripts('node_modules/owl.carousel/dist/owl.carousel.min.js', 'public/js/owl-carousel/owl.carousel.min.js')

		//Tinymce
		.copy('vendor/tinymce/tinymce', 'public/js/tinymce')

		//Products
		.scripts('resources/js/products/table.js', 'public/js/products/table.js')
		.scripts('resources/js/products/create.js', 'public/js/products/create.js')
		.scripts('resources/js/products/ingredient.js', 'public/js/products/ingredient.js')

		//POS
		//.js('resources/js/pos/pos_functions.js', 'public/js/pos/pos_functions.js')

		//SweetAlerts2
		.scripts('node_modules/sweetalert2/dist/sweetalert2.min.js', 'public/js/sweetalert2/sweetalert2.min.js')
		
		.scripts('resources/js/chart-js/chart-report_payment_types.js', 'public/js/echarts/chart-report_payment_types.js')
        .scripts('node_modules/echarts/dist/echarts.min.js', 'public/js/echarts/echarts.min.js')

	.js('resources/js/app.js', 'public/js')
	/** Scripts */
	
	/** CSS */
		//Bootstrap
		//.styles('node_modules/bootstrap/dist/css/bootstrap.css', 'public/css/bootstrap/bootstrap.css')
		//.copy('node_modules/bootstrap/dist/css/bootstrap.css.map', 'public/css/bootstrap/bootstrap.css.map')
		//Jquery UI
		.styles('node_modules/jquery-ui-dist/jquery-ui.min.css', 'public/css/jquery/jquery-ui.css')
		//Font awesome
		//.styles('node_modules/@fortawesome/fontawesome-free/css/fontawesome.css', 'public/css/fontawesome/fontawesome.css')
		//.styles('node_modules/@fortawesome/fontawesome-free/css/all.css', 'public/css/fontawesome/all.css')
		//Datatables bootstrap
		.styles('node_modules/datatables.net-bs5/css/dataTables.bootstrap5.css', 'public/css/datatables/dataTables.bootstrap5.css')
		.styles('node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.css', 'public/css/datatables/buttons.bootstrap5.css')
		.styles('node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css', 'public/css/datatables/responsive.bootstrap5.min.css')
		/*.postCss('resources/css/app.css', 'public/css', [
			require('postcss-import'),
			require('tailwindcss'),
			require('autoprefixer'),
		])*/
		//Owl carousel
		.styles('node_modules/owl.carousel/dist/assets/owl.carousel.min.css', 'public/css/owl-carousel/owl.carousel.min.css')
		.styles('node_modules/owl.carousel/dist/assets/owl.theme.default.min.css', 'public/css/owl-carousel/owl.theme.default.min.css')

		//SweetAlerts2
		.styles('node_modules/sweetalert2/dist/sweetalert2.min.css', 'public/css/sweetalert2/sweetalert2.min.css')


		.sass('resources/scss/bootstrap.scss', 'public/css/bootstrap/bootstrap.css')
		.sass('resources/scss/icons.scss', 'public/css/icons.css')
		.sass('resources/scss/app.scss', 'public/css/app.css')
		
	/** CSS */

	/** Directories */
	.copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/css/webfonts')
	.copy('resources/fonts', 'public/fonts')
	.copy('resources/images', 'public/images')

/** Directories */

	/**
	* processCssUrls por default busca las urls definidas en el css y las procesa
	* lo ponemos false para que no cambie la url definida y copiamos directorio de images de resources a public
	*/
	.options({ processCssUrls: false });
