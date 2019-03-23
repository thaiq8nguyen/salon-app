import Square from "Services/square-services";

export default {

	getDailyReceipts ({ commit, rootGetters }) {

		const date = rootGetters["date"];

		return Square.getDailyReceipts(date)
			.then(response => {

				commit("SET_RECEIPTS", response.data.receipts);

			})
			.catch(errors => {

				console.log(errors);

			});

	},
	redeemGiftCard ({ commit, dispatch }, redeem) {

		return Square.redeemGiftCard(redeem)
			.then(response => {

				dispatch("getDailyReceipts");

			})
			.catch(errors => {
			});

	}
};
