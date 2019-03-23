import Vue from "vue";
import Plugins from "Plugins";

let Services = new Vue();
Vue.use(Plugins);

export default {

	date (state) {

		return Services.$moment(state.date).format("YYYY-MM-DD");

	},
	dateTextField (state) {

		return Services.$moment(state.date).format("ddd, MM/DD/YYYY");

	},

};
