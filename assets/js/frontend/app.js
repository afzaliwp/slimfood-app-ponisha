const $ = jQuery;

import Chart from 'chart.js/auto';
import Toastify from 'toastify-js';
import Cart from './cart.js';
import * as dataLabels from 'chartjs-plugin-datalabels';
import html2canvas from 'html2canvas';

Chart.register(dataLabels.default); // Register the plugin

class App {

	// all the selectors required for the app.
	selectors = {
		appWrapper: 'slimfood-app',
		chartWrapper: '#pie-chart',
		itemsWrapper: '.items-wrapper',
		item: '.items-wrapper .item',
		caloriesCount: '#calories-count',
		priceCount: '#price-count',
		quantity: '.quantity',
		categoryItems: '.item.category',
		step: '.step',
		phone: '.phone',
		phoneKeys: '.phone-keys .key',
		phoneNumber: '.phone-number',
		payButton: '#pay-button',
		payForm: '#pay-form',
	};

	// the app wrapper element
	app;

	// the cart class
	cart;

	//Nutrition
	nutrition = {
		calories: 0,
		protein: 0,
		carbohydrate: 0,
		fat: 0,
	};

	//Form data
	formData;

	constructor() {
		this.app = document.getElementById(this.selectors.appWrapper);

		if (!this.app) {
			return;
		}

		this.cart = new Cart();
		this.cart.setPlace(
			this.app.dataset.placeAddress,
			this.app.dataset.placeName,
			this.app.dataset.placePhone,
			this.app.dataset.redirectPath
		);

		this.handleChart();
		this.handlePhone();
		this.handleQuantity();
		this.handleCategoriesSteps();
		this.handleStepNavigators();
		this.handleTimeSelect();
		this.handleAddressForm();
		this.handlePayment();
		this.handleModal();
	}

	handleQuantity() {
		const quantities = this.app.querySelectorAll(this.selectors.quantity);

		quantities.forEach((quantity) => {
			const increaseButton = quantity.querySelector('button.increase');
			const decreaseButton = quantity.querySelector('button.decrease');
			const number = quantity.querySelector('.number');
			const max = quantity.dataset.max;

			increaseButton.addEventListener('click', (e) => {
				decreaseButton.disabled = false;

				if (max === number.innerText) {
					this.toast(`حداکثر مقدار قابل انتخاب ${ max } عدد است.`, 'error');
					increaseButton.disabled = true;
					return;
				}

				this.toast('یک آیتم اضافه شد.');
				this.nutrition = {
					calories: this.nutrition.calories + Number(quantity.dataset.calories),
					carbohydrate: this.nutrition.carbohydrate + Number(quantity.dataset.carbohydrate),
					protein: this.nutrition.protein + Number(quantity.dataset.protein),
					fat: this.nutrition.fat + Number(quantity.dataset.fat),
				};
				const newQuantityValue = Number(number.innerText) + 1;
				this.cart.setProduct(
					quantity.dataset.productId,
					newQuantityValue,
					quantity.dataset.name,
					quantity.dataset.price
				);
				number.innerText = newQuantityValue;

				const newTotal = this.cart.getTotal() + Number(quantity.dataset.price);
				this.cart.setTotal(newTotal);
				this.app.querySelector('#price-count').innerText = this.formatNumber(newTotal);
				this.app.querySelector('#calories-count').innerText = this.nutrition.calories;

				const increaseProductEvent = new Event('slimfood:productincreased');
				this.app.dispatchEvent(increaseProductEvent);
			});

			decreaseButton.addEventListener('click', (e) => {
				if (0 === Number(number.innerText)) {
					decreaseButton.disabled = true;
					return;
				}

				increaseButton.disabled = false;
				this.toast('یک آیتم حذف شد.');
				this.nutrition = {
					calories: this.nutrition.calories - Number(quantity.dataset.calories),
					carbohydrate: this.nutrition.carbohydrate - Number(quantity.dataset.carbohydrate),
					protein: this.nutrition.protein - Number(quantity.dataset.protein),
					fat: this.nutrition.fat - Number(quantity.dataset.fat),
				};
				const newQuantityValue = Number(number.innerText) - 1;
				this.cart.setProduct(
					quantity.dataset.productId,
					newQuantityValue,
					quantity.dataset.name,
					quantity.dataset.price
				);
				number.innerText = newQuantityValue;
				const newTotal = this.cart.getTotal() - Number(quantity.dataset.price);
				this.cart.setTotal(newTotal);
				this.app.querySelector('#price-count').innerText = this.formatNumber(newTotal);
				this.app.querySelector('#calories-count').innerText = this.nutrition.calories;

				const decreaseProductEvent = new Event('slimfood:productdecreased');
				this.app.dispatchEvent(decreaseProductEvent);
			});
		});
	}

	handleChart() {
		let nutritionChart = new Chart(this.app.querySelector(this.selectors.chartWrapper), {
			type: 'pie',
			data: {
				datasets: [{
					label: 'Gr',
					data: [0, 0, 0],
					backgroundColor: [
						'#ff0000',
						'#290ebf',
						'#e4c754'
					],
					hoverOffset: 4
				}]
			},
			tooltips: {
				enabled: false
			},
			options: {
				plugins: {
					datalabels: {
						color: '#ffffff',
						anchor: 'center',
						align: 'right',
						clamp: true,
						display: 'auto',
						font: {
							size: 14,
							weight: 500,
						},
						formatter: (value, context) => {
							let sum = context.dataset.data.reduce((a, b) => a + b, 0);
							let percentage = (value / sum * 100).toFixed(0);
							return Math.round(value) + 'Gr \n' + Math.round(Number(percentage)) + '%';
						}
					}
				}
			}
		});

		const updateChart = () => {
			nutritionChart.data.datasets[0].data = [this.nutrition.protein, this.nutrition.carbohydrate, this.nutrition.fat];
			nutritionChart.update();
		};

		this.app.addEventListener('slimfood:productdecreased', updateChart);
		this.app.addEventListener('slimfood:productincreased', updateChart);
	}

	toast(message, type = 'success') {

		let color = '#485d1f';

		if ('error' === type) {
			color = '#850707';
		}

		if ('info' === type) {
			color = '#066294';
		}

		Toastify({
			text: message,
			rtl: true,
			duration: 1500,
			newWindow: false,
			close: true,
			gravity: 'bottom',
			position: 'right',
			stopOnFocus: true,
			style: {
				background: color,
				direction: 'rtl',
				fontSize: '16px',
			},
			onClick: function () {
			} // Callback after click
		}).showToast();
	}

	handleCategoriesSteps() {
		const categoryItems = this.app.querySelectorAll(this.selectors.categoryItems);

		categoryItems.forEach((item) => {
			item.addEventListener('click', (e) => {
				const subStep = item.dataset.subStep;
				const parentStep = item.closest(this.selectors.step);

				this.app.querySelector(`.step[data-sub-step=${ subStep }]`).style.display = 'flex';
				parentStep.style.display = 'none';
			});
		});
	}

	handleStepNavigators() {
		const navigators = this.app.querySelectorAll('.step-navigator, .skip-step');

		navigators.forEach((navigator) => {
			navigator.addEventListener('click', () => {
				const parentStep = navigator.closest(this.selectors.step);
				const pointsTo = navigator.dataset.stepSelector;

				parentStep.style.display = 'none';
				this.app.querySelector(pointsTo).style.display = 'flex';
				this.app.dataset.current = pointsTo;
			});
		});
	}

	handleAddressForm() {
		let parentElement = this.app.querySelector('.choose-address');
		let onPlaceOrderAddress = Array.from(parentElement.children).find(child => child.innerText.trim() === 'در محل سفارش (رایگان)');
		onPlaceOrderAddress.addEventListener('click', () => {
			this.cart.setIsInPlace(true);
		});

		this.app.querySelector('form#address-form #address').addEventListener('keydown', (e) => {
			this.cart.setAddress(e.target.value);
		});

		this.app.querySelectorAll('.step-6-parent .choose-time button').forEach((button) => {
			button.addEventListener('click', (e) => {

				this.cart.setTime(button.innerText.trim());
				this.handleInvoice();
			});
		});

		this.app.querySelectorAll('.address-form-step .next-step').forEach((button) => {
			button.addEventListener('click', (e) => {
				this.cart.setIsInPlace( false );
				this.cart.setAddress( this.app.querySelector( '#address-form #address' ).value );
				this.cart.setTime('بدون زمان');
				this.handleInvoice();
			});
		});
	}

	handleInvoice() {
		const cartInfo = this.cart.getCartData();
		const invoice = this.app.querySelector('.invoice');
		let totalPrice = 0;
		const self = this;
		Object.entries(cartInfo.products).forEach(function ([key, value]) {
			totalPrice += Number(value.price);
			const formattedPrice = self.formatNumber(value.price);
			invoice.querySelector('.products').innerHTML +=
				`<div class="product"><span class="item-name">${ value.name }</span> <div><span class="item-quantity">${ value.quantity } عدد</span> <span class="price">${ formattedPrice } هزار تومان</span></div></div>`;
		});

		if (this.cart.getIsInPlace()) {
			invoice.querySelector('.item-invoice.shipping').style.display = 'none';
			invoice.querySelector('.total .price span').innerText = this.formatNumber(totalPrice);
		} else {
			invoice.querySelector('.total .price span').innerText = this.formatNumber(totalPrice + 50);
		}
	}

	formatNumber(number) {
		if (number > 999) {
			let str = number.toString();
			return str[0] + ' میلیون و ' + str.slice(1);
		} else {
			return number.toString();
		}
	}

	handlePhone() {
		const phone = this.app.querySelector(this.selectors.phone);
		const phoneNumber = phone.querySelector(`${ this.selectors.phoneNumber }`);
		const phoneKeys = phone.querySelectorAll(`${ this.selectors.phoneKeys }`);
		const orderNowButton = this.app.querySelector('.step-phone-parent .step-navigator.next');
		const regex = new RegExp('^(09[0-9]{9}|9[0-9]{8})$');
		phoneKeys.forEach((key) => {
			key.addEventListener('click', () => {
				const value = key.dataset.number;

				if ('clear' === value) {
					phoneNumber.innerText = phoneNumber.innerText.slice(0, -1);
					return;
				}

				phoneNumber.innerText += value;
			});
		});

		orderNowButton.addEventListener('click', (e) => {
			const number = phone.querySelector(`${ this.selectors.phoneNumber }`).innerText.trim();

			if (!regex.test(number)) {
				e.stopImmediatePropagation();
				this.toast('شماره موبایل نامعتبر است.', 'error');
				return;
			}

			this.cart.setPhone(number);
		});
	}

	checkTime() {
		const buttons = document.querySelectorAll('.step-6-parent .step-navigator.next');
		const currentTime = new Date();

		buttons.forEach(function (button) {
			const startTime = parseInt(button.getAttribute('data-start-time'));
			const currentHours = currentTime.getHours() + currentTime.getMinutes() / 60;
			const timeDiff = startTime - currentHours;
			if (timeDiff >= 1.5) {
				button.classList.add('active');
				button.disabled = false;
			} else {
				button.classList.remove('active');
				button.disabled = true;
			}
		});
	}

	handleTimeSelect() {
		this.checkTime();
		setInterval(this.checkTime.bind(this), 30000);
	}

	handlePayment() {
		const payButton = this.app.querySelector(this.selectors.payButton);
		const payForm = this.app.querySelector(this.selectors.payForm);
		const payFormData = [
			{
				input: 'order_time',
				data: 'time',
			},
			{
				input: 'order_is_in_place',
				data: 'isInPlace',
			},
			{
				input: 'redirect_path',
				data: 'place.redirectPath',
			},
			{
				input: 'place_phone',
				data: 'place.phone',
			},
			{
				input: 'billing_first_name',
				data: 'place.name',
			},
			{
				input: 'billing_address_1',
				data: 'address',
			},
			{
				input: 'billing_address_2',
				data: 'place.address',
			},
			{
				input: 'billing_phone',
				data: 'phone',
			},
		];

		const self = this;
		payButton.addEventListener('click', () => {

			let formData = new FormData();
			html2canvas(document.querySelector('#slimfood-app')).then(canvas => {
				canvas.toBlob(blob => {
					formData.append('invoiceImg', blob);
					console.log('blob', blob )
					this.formData = formData;

					self.app.classList.add('loading');
					const cartData = this.cart.getCart();

					payFormData.forEach((item) => {
						const value = getNestedValue(cartData, item.data);
						if (value !== undefined) {
							payForm.querySelector('input[name="' + item.input + '"]').value = value;
						}
					});

					jQuery.ajax({
						url: afzaliwpSfAJAX.ajaxUrl,
						type: 'post',
						dataType: 'json',
						data: {
							action: 'afzaliwp_add_to_cart',
							nonce: afzaliwpSfAJAX.nonce,
							products: this.cart.getProducts(),
						},
						success: function (response) {
							self.toast('سبد خرید شما ساخته شد.', 'info');
							self.goPaymentUrl();
						},
						error: function (error) {
							self.app.classList.remove('loading');
							console.error(error);
							self.toast('خطایی پیش آمده است. لطفا مجددا تلاش کنید.', 'error');
						},
					});
				});
			});
		});

		function getNestedValue(obj, dataKey) {
			let keys = dataKey.split('.');
			for (let i = 0; i < keys.length; i++) {
				if (obj === undefined) {
					return undefined;
				}
				obj = obj[keys[i]];
			}
			return obj;
		}
	}

	goPaymentUrl() {
		const self = this;

		this.formData.append('action', 'afzaliwp_create_order');
		this.formData.append('nonce', afzaliwpSfAJAX.nonce);
		this.formData.append('cart', JSON.stringify(this.cart.getCart()));
		console.log('this.formData')
		this.formData.forEach((value, key) => {
			console.log(`Key: ${key}, Value: ${value}`);
		});

		$.ajax({
			url: afzaliwpSfAJAX.ajaxUrl,
			type: 'post',
			dataType: 'json',
			data: this.formData,
			processData: false,
			contentType: false,
			success: function (response) {
				if (response.success) {
					console.log('Order created successfully. Order ID: ' + response.data.order_id);

					self.toast('در حال انتقال به درگاه پرداخت! لطفا کمی صبر کنید...', 'success');
					// Redirect user to payment link here
					window.location.href = response.data.payment_url_wc;
				} else {
					console.error(response);
					self.toast('مشکلی پیش آمده است. لطفا مجدد تلاش کنید.', 'error');
				}
			},
			error: function (error) {
				console.error(error);
				self.toast('مشکلی پیش آمده است. لطفا مجدد تلاش کنید.', 'error');
			},
		}, 'image/png');

	}

	handleModal() {
		const modal = this.app.querySelector('.afzaliwp-slimfood-modal');

		if (!modal) {
			return;
		}

		modal.querySelector('.close-button').addEventListener('click', () => {
			modal.classList.remove('show');
			modal.classList.add('hide');
		});
	}
}

new App();