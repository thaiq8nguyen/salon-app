import getters from "./getters";
import actions from "./actions";
import mutations from "./mutations";

const state = {

	technicians: JSON.parse(localStorage.getItem("technicians")) || "",
	selectedTechnician: "",

};

export default {

	namespaced: true,
	state,
	getters,
	actions,
	mutations

};
