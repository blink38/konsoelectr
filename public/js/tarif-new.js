var datepicker;

window.addEventListener('load', () => {

    // https://github.com/uxsolutions/bootstrap-datepicker
    // doc https://bootstrap-datepicker.readthedocs.io/en/stable/

    datepicker = $('#tarif_days').datepicker({
        multidate: true,
        format: 'dd-mm-yyyy',
        defaultViewDate: 'year',
        language: 'fr'
      });
});
