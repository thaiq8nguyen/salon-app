// UPDATE TECHNICIAN SALES

export default {

	techniciansWithSale (state) {

		return state.techniciansWithSale;

	},
	techniciansWithNoSale (state) {

		return state.techniciansWithNoSale;

	},
	loading (state) {

		return state.loading;

	},
	technicianSaleTotal (state) {

		if (state.techniciansWithSale) {

			return state.techniciansWithSale.reduce((sum, technician) => {

				return sum + parseFloat(technician.sale.sale_amount);

			}, 0);

		} else {

			return 0;

		}

	},

};
