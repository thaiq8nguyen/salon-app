import Vue from "vue";
import Plugins from "Plugins";

let Services = new Vue();
Vue.use(Plugins);

export default {
	existingTotalSaleAmount (state) {

		return state.techniciansWithSale.reduce((sum, technician) => {

			return sum + parseFloat(technician.sale.sale_amount);

		}, 0);

	},
	sales (state) {

		return state.sales;

	},
	totalSaleAmount (state) {

		return state.sales.reduce((sum, sale) => {

			return sum + parseFloat(sale.amount);

		}, 0);

	},
	totalTipAmount (state) {

		return state.sales.reduce((sum, sale) => {

			return sum + parseFloat(sale.tipAmount);

		}, 0);

	},
	netTotalTechnicianSaleAmount (state, getters, rootState, rootGetters) {

		if (rootGetters["Square/hasReceipts"]) {

			const squareConvenienceFee = rootGetters["Square/convenienceFee"];

			const squareGiftCardRedeem = rootGetters["Square/giftCardRedeem"];

			const squareGiftCardSold = rootGetters["Square/giftCardSold"];

			return getters.totalSaleAmount + getters.existingTotalSaleAmount +
				parseFloat(squareConvenienceFee.amount) - parseFloat(squareGiftCardRedeem.amount) + parseFloat(squareGiftCardSold.amount);

		} else {

			return 0;

		}

	},
	isTechnicianSalesAndSquareMatched (state, getters, rootState, rootGetters) {

		if (rootGetters["Square/hasReceipts"]) {

			const squareTotalCollected = rootGetters["Square/totalCollected"];
			const netTotalTechnicianSaleAmount = getters["netTotalTechnicianSaleAmount"];

			return (netTotalTechnicianSaleAmount - squareTotalCollected) === 0;

		} else {

			return false;

		}

	},
	technicians (state) {

		let technicians = state.techniciansWithNoSale.filter(function (technician) {

			return !state.sales.some(function (sale) {

				return sale.technicianID === technician.id;

			});

		});

		return technicians.sort((a, b) => {

			let firstNameA = a.first_name.toLowerCase();
			let firstNameB = b.first_name.toLowerCase();
			if (firstNameA < firstNameB) {

				return -1;

			}

			if (firstNameA > firstNameB) {

				return 1;

			}
			return 0;

		});

	},
	loading (state) {

		return state.loading;

	},
	hasNoExistingTechnicianSales (state) {

		return state.techniciansWithSale.length === 0;

	},

};
