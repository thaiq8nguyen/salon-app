import Vue from "vue";
import Vuex from "vuex";
import getters from "./getters";
import actions from "./actions";
import mutations from "./mutations";

// Modules

import Authentications from "./modules/authentications";
import Technicians from "./modules/technicians";
import AddTechnicianSales from "./modules/add-technician-sales";
import UpdateTechnicianSales from "./modules/update-technician-sales";
import Square from "./modules/square";
import Accounts from "./modules/accounts";
import AppSettings from "./modules/app-settings";
import PayPeriods from "./modules/pay-periods";
import Users from "./modules/users";
import Plugins from "Plugins";

// Plugins

let Services = new Vue();
Vue.use(Plugins);

const persistStates = (store) => {

	store.subscribe((mutation, state) => {

		Services.persistState.save(state);

	});

};

Vue.use(Vuex);

export default new Vuex.Store({
	modules: {
		Authentications,
		Technicians,
		AddTechnicianSales,
		UpdateTechnicianSales,
		Square,
		Accounts,
		AppSettings,
		PayPeriods,
		Users,
	},
	state: {

		date: new Date(),

	},
	getters,

	actions,

	mutations,

	plugins: [persistStates],

});
