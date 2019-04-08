import Vue from "vue";
import AuthenticationServices from "Services/authentication-services";
import Plugins from "Plugins";
import Router from "Router";
let Services = new Vue();
Vue.use(Plugins);

export default {

	login ({ commit }, credential) {


		return new Promise((resolve, reject) => {

			return AuthenticationServices.login(credential)
				.then(response => {

					if (response.data.user.approved) {

						commit("SET_AUTHENTICATION", response.data.user);
						resolve(true);

					} else {

						resolve(false);

					}

				})
				.catch(errors => {

					if (errors.response.status === 401) {

						reject(errors.response.data.message);

					}
					Services.persistState.remove();

				});

		});

	},

	logout ({ commit }) {

		return AuthenticationServices.logout()
			.then(response => {

				Router.push("logout");

				commit("RESET_AUTHENTICATION");

				Services.persistState.remove();

			})
			.catch(errors => {

				console.log(errors);

			});

	},

	register ({ commit }, user) {

		return new Promise((resolve, reject) => {

			return AuthenticationServices.register(user)
				.then(response => {

					resolve(response.data.user);

				})
				.catch(errors => {

					reject(errors);

				});

		});

	}
};
