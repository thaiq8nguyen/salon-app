
export default {

	isAuthenticating (state) {

		return state.isAuthenticating;

	},

	isAuthenticated (state) {

		return state.authentication.accessToken !== "";

	},

	userFullName (state) {

		return state.authentication.userFullName;

	},

	accessToken (state) {

		return state.authentication.accessToken;

	},

	errorMessage (state) {

		return state.errorMessage;

	}
};
