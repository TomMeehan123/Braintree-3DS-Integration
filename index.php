<html>
<?php require_once ("braintree_init.php"); ?>
<?php require_once 'lib/Braintree.php'; ?>
<body>
    <div class="wrapper">
        <div class="checkout container">
            <header>
            </header>
            <form method="post" id="payment-form" action="checkout.php">
                <section>
                <label for="amount">
                        <span class="input-label">Amount</span>
                        <div class="input-wrapper amount-wrapper">
                            <input id="amount" name="amount" type="tel" min="1" placeholder="Amount" value="10">
                        </div>
                    </label>
                    <div class="bt-drop-in-wrapper">
                        <div id="bt-dropin"></div>
                    </div>
                </section>
                <input id="nonce" name="payment_method_nonce" type="hidden" />
                <input id="device_data" name="device_data" type="hidden" />
                <button class="button" type="submit"><span>Pay</span></button>
            </form>
        </div>
    </div>
    <script src="https://js.braintreegateway.com/web/dropin/1.31.0/js/dropin.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.79.1/js/data-collector.min.js"></script>
    <script>
        var form = document.querySelector('#payment-form');
        var client_token = "<?php echo($gateway->ClientToken()->generate()); ?>";
        var threeDSecureParameters = {
        amount: '10.00',
        email: 'test@example.com',
        billingAddress: {
          givenName: 'Jill', // ASCII-printable characters required, else will throw a validation error
          surname: 'Doe', // ASCII-printable characters required, else will throw a validation error
          phoneNumber: '8101234567',
          streetAddress: '555 Smith St.',
          extendedAddress: '#5',
          locality: 'Oakland',
          region: 'CA',
          postalCode: '12345',
          countryCodeAlpha2: 'US'
        },
        additionalInformation: {
          workPhoneNumber: '8101234567',
          shippingGivenName: 'Jill',
          shippingSurname: 'Doe',
          shippingPhone: '8101234567',
          shippingAddress: {
            streetAddress: '555 Smith St.',
            extendedAddress: '#5',
            locality: 'Oakland',
            region: 'CA',
            postalCode: '12345',
            countryCodeAlpha2: 'US'
          }
        },
      };
      
         braintree.dropin.create({
          authorization: client_token,
          selector: '#bt-dropin',
          dataCollector: true,
          paypal: {
            flow: 'vault'
          },
		  threeDSecure: true
        }, function (createErr, dropinInstance) {
          if (createErr) {
            console.log('Create Error', createErr);
            return;
          }
          form.addEventListener('submit', function (event) {
             // alert('inside button click');
            event.preventDefault();
            dropinInstance.requestPaymentMethod({
				threeDSecure:threeDSecureParameters
                //console.log(JSON.stringify(payload));
                //alert(payload.nonce);
			},function(err,payload){
              if (err) {
                console.log('Request Payment Method Error', err);
                //return;
              }
              // Add the nonce to the form and submit
              document.querySelector('#nonce').value = payload.nonce;
              document.querySelector('#device_data').value = payload.deviceData;
              form.submit();
            });
          });
        });
    </script>
    <!--<script src="javascript/demo.js"></script>-->
</body>
</html>

