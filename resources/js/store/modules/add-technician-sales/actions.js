import TechnicianSaleServices from "Services/technician-sale-services";

export default {

	init ({ commit, dispatch }) {

		dispatch("Square/getDailyReceipts", null, { root: true });
		dispatch("getTechniciansWithNoSale");
		dispatch("getTechniciansWithSale");

	},
	getTechniciansWithNoSale ({ commit, getters, rootGetters }) {

		const date = rootGetters["date"];
		TechnicianSaleServices.getTechniciansWithNoSale(date)
			.then(response => {

				commit("SET_TECHNICIANS_WITH_NO_SALE", response.data.technicians);

			})
			.catch(errors => {

				console.log(errors.response);

			})
			.then(() => {

			});

	},
	getTechniciansWithSale ({ commit, getters, rootGetters }) {

		const date = rootGetters["date"];
		TechnicianSaleServices.getTechniciansWithSale(date)
			.then(response => {

				commit("SET_TECHNICIANS_WITH_SALE", response.data.technicians);

			})
			.catch(errors => {

				console.log(errors.response);

			})
			.then(() => {

			});

	},

	add ({ commit }, sale) {

		commit("ADD_SALE", sale);

	},

	deletePendingSale ({ commit }, sale) {

		commit("DELETE_PENDING_SALE", sale);

	},

	upload ({ commit, getters, dispatch, rootGetters }) {

		commit("SET_LOADING", true);
		const sales = {

			date: rootGetters["date"],
			sales: getters.sales

		};
		TechnicianSaleServices.upload(sales)
			.then(response => {

				commit("SET_LOADING", true);
				commit("RESET");
				dispatch("getTechniciansWithSale");
				dispatch("getTechniciansWithNoSale");

			})
			.catch(errors => {

				console.log(errors);

			})
			.then(() => {

			});

	},

	setDate ({ commit }, date) {

		commit("SET_DATE", date);

	},

	deleteAllPendingSales ({ commit }) {

		commit("DELETE_PENDING_SALES");

	},





};
