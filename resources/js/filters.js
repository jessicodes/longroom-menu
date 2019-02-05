// converts 0.00 to price to display.
// ie. 6.00 = $6
// ie. 6.50 = $6.5
Vue.filter('toCurrency', function (value) {
    if (typeof value !== "number") {
        value = parseFloat(value);
    }
    var formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 0
    });
    return formatter.format(value);
});