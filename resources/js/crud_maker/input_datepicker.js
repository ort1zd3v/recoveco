$(function() {
	window.loadDateTimePicker = () => {
		$('.datepicker2').datetimepicker({
			locale: 'es',
			format: 'DD-MM-YYYY'
		});
		$('.datetimepicker2').datetimepicker({
			locale: 'es',
			format: 'DD-MM-YYYY H:mm'
		});
	}

	window.loadDateTimePickerFilters = () => {
		$('.datepicker-start').datetimepicker({
			locale: 'es',
			format: 'DD-MM-YYYY',
			ignoreReadonly: true
		});

		$('.datepicker-end').datetimepicker({
			useCurrent: false,
			locale: 'es',
			format: 'DD-MM-YYYY',
			ignoreReadonly: true
		});

		$('.timepicker-start').datetimepicker({
			locale: 'es',
			format: 'HH:mm',
			ignoreReadonly: true
		});

		$('.timepicker-end').datetimepicker({
			useCurrent: false,
			locale: 'es',
			format: 'HH:mm',
			ignoreReadonly: true
		});
	}

	loadDateTimePicker();
	loadDateTimePickerFilters();
});
