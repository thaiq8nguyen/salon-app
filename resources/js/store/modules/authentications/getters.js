
export default {

	isAuthenticated (state) {

		return !!state.authentication.accessToken;

	},
	userFullName (state) {

		return state.authentication.userFullName;

	},
	accessToken (state) {

		return state.authentication.accessToken;

	},
	tokenExpiration (state) {

		return state.authentication.expiration;

	},
	isApproved (state) {

		return !!state.authentication.approved;

	},
	errorMessage (state) {

		return state.errorMessage;

	}
};
