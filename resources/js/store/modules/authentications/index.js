// AUTHENTICATIONS
import getters from "./getters";
import actions from "./actions";
import mutations from "./mutations";

const state = {

	authentication: "",
	errorMessage: "",

};
export default ({
	namespaced: true,
	state,
	getters,
	actions,
	mutations
});
