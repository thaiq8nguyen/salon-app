import Vue from "vue";
import Plugins from "Plugins";

let Services = new Vue();
Vue.use(Plugins);

export default {

	INITIALIZE_STATE (state) {

		this.replaceState(
			Object.assign(state, Services.persistState.load())
		);

	},

	SET_DATE (state, date) {

		state.date = date;

	}

};
