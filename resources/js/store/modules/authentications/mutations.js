export default {

	SET_IS_AUTHENTICATING (state, value) {

		state.isAuthenticating = value;

	},

	SET_AUTHENTICATION (state, authentication) {

		state.authentication = authentication;

	},

	SET_ERROR_MESSAGE (state, message) {

		state.errorMessage = message;

	},

	RESET_AUTHENTICATION (state) {

		state.authentication = "";

	},
};
