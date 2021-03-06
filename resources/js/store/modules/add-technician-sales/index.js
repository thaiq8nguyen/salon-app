import getters from "./getters";
import actions from "./actions";
import mutations from "./mutations";

const state = {

	sales: [],
	technicians: [],
	techniciansWithNoSale: [],
	techniciansWithSale: [],
	technicianSalesByPeriod: [],
	loading: false,

};

export default ({
	namespaced: true,
	state,
	getters,
	actions,
	mutations
});
