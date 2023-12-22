

jQuery(document).ready(function($) {
  let publishableKey = pluginData.publishableKey;
var handler = StripeCheckout.configure({
  key: publishableKey,
  image: $('.customButton').data('image'),
  locale: 'auto',
  token: function(token) {    
    let pluginBaseUrl = pluginData.baseUrl;
    let  endPoint = 'process-payment.php';
    $.ajax({
      type: 'POST',
      url: pluginBaseUrl+endPoint,
      data: {
       currency:$('.customButton').data('currency'),
       token_id: token.id,
       description:$('.customButton').data('description'),
       amount:  $('.customButton').data('amount'),
       secret_key:pluginData.secretKey,
      },
      success: function(response) {
        // Handle the success response from your server
        console.log(response);
        if ($.trim(pluginData.thankYouPageUrl) !== '') {
        window.location.href = pluginData.thankYouPageUrl;}
      },
      error: function(error) {
        // Handle the error response from your server
        console.error(error);
        if ($.trim(pluginData.cancelPageUrl) !== '') {
          window.location.href = pluginData.cancelPageUrl;}
      }
    });
  }
});


$('.customButton').click(function() {
  // Retrieve data-amount attribute value
  var amount = $(this).data('amount');
  var currency = $(this).data('currency');
  var name = $(this).data('name');
  var description = $(this).data('description');
  popup(amount, currency, name, description);
});

function popup(amount, currency, name, description) {
  // Open Checkout with further options:
  handler.open({
      name: name,
      description: description,
      zipCode: true,
      currency: currency,
      amount: amount,
      closed: function() {
          // Handle the case when the popup is closed without completing the payment
      }
  });
}
// Close Checkout on page navigation:
window.addEventListener('popstate', function() {
  handler.close();
});
});