import Vue from "vue";
import Plugins from "Plugins";

let Services = new Vue();
Vue.use(Plugins);

export default {

	getTechnicians () {

		return new Promise((resolve, reject) => {

			return Services.apiClient.get("/technicians")
				.then((response) => {

					resolve(response.data.technicians);

				})
				.catch((errors) => {

					reject(errors);

				});

		});

	},




};
