import TechnicianSaleServices from "Services/technician-sale-services";

export default {
	init ({ commit, dispatch }) {

		dispatch("getTechniciansWithSale");
		dispatch("getTechniciansWithNoSale");
		dispatch("Square/getDailyReceipts", null, { root: true });

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
	setDate ({ commit }, date) {

		commit("SET_DATE", date);

	},
	updateExistingSale ({ commit, dispatch }, updatedSale) {

		commit("SET_LOADING", true);
		return new Promise((resolve, reject) => {

			return TechnicianSaleServices.updateExistingSale(updatedSale)
				.then(response => {

					resolve(response.data.success);
					dispatch("getTechniciansWithSale");

				})
				.catch(errors => {

					reject(errors.response.status);
					console.log(errors);

				})
				.then(() => {

					commit("SET_LOADING", false);

				});

		});

	},
	deleteExistingSale ({ commit, dispatch }, saleID) {

		commit("SET_LOADING", true);
		return TechnicianSaleServices.deleteExistingSale(saleID)
			.then(response => {

				dispatch("getTechniciansWithSale");
				dispatch("getTechniciansWithNoSale");

			})
			.catch(errors => {

				console.log(errors);

			})
			.then(() => {

				commit("SET_LOADING", false);

			});

	},

}
