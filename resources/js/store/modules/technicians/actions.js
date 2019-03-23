import Vue from "vue";
import Plugins from "Plugins";

let Services = new Vue();
Vue.use(Plugins);

export default {
	init ({ commit, dispatch }) {

		dispatch("getTechnicians");

	},
	getTechnicians ({ commit }) {

		Services.apiClient("/technicians")
			.then(response => {

				commit("SET_TECHNICIANS", response.data.technicians);

			})
			.catch(errors => {

				console.log(errors.response);

			});

	},



};
