import AccountTypeServices from "Services/account-type-services";
import AccountServices from "Services/account-services";

export default {
	async init ({ commit, dispatch }) {

		commit("SET_ACCOUNT_TYPES", await dispatch("getAccountTypes"));
		commit("SET_ACCOUNTS", await dispatch("getAccounts"));

	},
	getAccountTypes () {

		return new Promise((resolve, reject) => {

			return AccountTypeServices.get()
				.then((response) => {

					resolve(response.data.accountTypes);

				})
				.catch((errors) => {

					reject(errors.response);

				});

		});

	},
	getAccounts () {

		return new Promise((resolve, reject) => {

			return AccountServices.get()
				.then((response) => {

					resolve(response.data.accounts);

				})
				.catch((errors) => {

					reject(errors.response);

				});

		});

	},
	addAccount ({ commit }, account) {

		commit("SET_LOADING", true);
		return AccountServices.add(account)
			.then((response) => {

				commit("ADD_ACCOUNT_TO_ACCOUNTS", response.data.accounts);

			})
			.catch((errors) => {

				console.log(errors.response);

			})
			.then(() => {

				commit("SET_LOADING", false);

			});

	},

};
