import getters from "./getters";
import actions from "./actions";
import mutations from "./mutations";
import AuthenticationServices from "Services/authentication-services";

const state = {

	authentication: AuthenticationServices.load(),
	isAuthenticating: false,
	errorMessage: "",

};
export default ({
	namespaced: true,
	state,
	getters,
	actions,
	mutations
});
