class Cart {

	cartItems = {
		phone: '',
		address: '',
		time: '',
		total: 0,
		products: {},
		isInPlace: false,
		place: {
			redirectPath: '',
			address: '',
			name: '',
			phone: '',
		}
	};

	constructor() {
	}

	getCart() {
		return this.cartItems;
	}

	getProducts() {
		return this.cartItems.products;
	}

	setProduct(productId, quantity, name, price) {
		if (this.cartItems.products[productId] && 0 === Number(quantity)) {
			delete this.cartItems.products[productId];
			return this.cartItems;
		}

		if (this.cartItems.products[productId]) {
			this.cartItems.products[productId].quantity = quantity;
			this.cartItems.products[productId].price = Number(quantity) * Number(price);
			return this.cartItems;
		}

		// For the start that the cart is empty
		if (!this.cartItems.products.length) {
			this.cartItems.products[productId] = {};
		}

		this.cartItems.products[productId].quantity = quantity;
		this.cartItems.products[productId].name = name;
		this.cartItems.products[productId].price = Number(quantity) * Number(price);
		return this.cartItems;
	}

	setPhone(phone) {
		this.cartItems.phone = phone;
		return this.cartItems;
	}

	getPhone() {
		return this.cartItems.phone;
	}

	setAddress(address) {
		this.cartItems.address = address;
		return this.cartItems.address;
	}

	getAddress() {
		return this.cartItems.address;
	}

	setTime(time) {
		this.cartItems.time = time;
		return this.cartItems.time;
	}

	getTime() {
		return this.cartItems.time;
	}

	getTotal() {
		return this.cartItems.total;
	}

	setTotal(total) {
		this.cartItems.total = total;
		return total;
	}

	getCartData() {
		return this.cartItems;
	}

	setPlace(address, name, phone, redirectPath) {
		this.cartItems.place.address = address;
		this.cartItems.place.name = name;
		this.cartItems.place.phone = phone;
		this.cartItems.place.redirectPath = redirectPath;

		return this.cartItems.place;
	}

	getPlace() {
		return this.cartItems.place;
	}

	setIsInPlace(bool) {
		this.cartItems.isInPlace = bool;

		return this.cartItems.isInPlace;
	}

	getIsInPlace() {
		return this.cartItems.isInPlace;
	}
}

export default Cart;