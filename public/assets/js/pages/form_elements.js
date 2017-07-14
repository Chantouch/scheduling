$(document).ready(function () {
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year
        format: 'You selecte!d: dddd, dd mmm, yyyy',
        formatSubmit: 'd-m-yyyy',
        hiddenPrefix: '',
        hiddenSuffix: ''
    });

    $('.timepicker').pickatime({
        autoclose: true,
        ampmclickable: false,
        twelvehour: false,
        afterDone: function (Element, Time) {
            console.log(Element, Time);
        }
    });

    $('input.autocomplete').autocomplete({
        data: {
            "Apple": null,
            "Microsoft": null,
            "Google": 'assets/images/google.png'
        }
    });
});