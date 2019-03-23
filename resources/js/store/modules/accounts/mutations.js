export default {

	SET_ACCOUNT_TYPES (state, accountTypes) {

		state.accountTypes = accountTypes;

	},
	SET_ACCOUNTS (state, accounts) {

		state.accounts = accounts;

	},
	SET_LOADING (state, value) {

		state.loading = value;

	},
	ADD_ACCOUNT_TO_ACCOUNTS (state, account) {

		state.accounts.push(account);

	}

};
