class OrderPay {

	constructor() {
		if (document.body.classList.contains('woocommerce-order-pay')) {
			this.handlePayment();
		}
	}

	handlePayment() {
		document.querySelector( '#place_order' ).click();
	}
}

new OrderPay();