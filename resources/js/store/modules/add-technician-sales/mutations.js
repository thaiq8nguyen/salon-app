export default {

	ADD_SALE (state, sale) {

		state.sales.push(sale);

	},
	DELETE_PENDING_SALE (state, sale) {

		state.sales = state.sales.filter(element => element !== sale);

	},
	SET_TECHNICIANS_WITH_SALE (state, technicians) {

		state.techniciansWithSale = technicians;

	},
	SET_TECHNICIANS_WITH_NO_SALE (state, technicians) {

		state.techniciansWithNoSale = technicians;

	},
	DELETE_PENDING_SALES (state) {

		state.sales = [];

	},
	SET_LOADING (state, value) {

		state.loading = value;

	},
	RESET (state) {

		state.sales = [];

	}

};
