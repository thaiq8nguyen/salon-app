import Vue from "vue";
import VueRouter from "vue-router";
import routes from "./routes";
import Plugins from "Plugins";

let Services = new Vue();
Vue.use(Plugins);
Vue.use(VueRouter);

const router = new VueRouter({

	routes

});

router.beforeEach((to, from, next) => {

	const state = Services.persistState.load();

	const isAuthenticated = state.Authentications.authentication.accessToken;

	if (to.matched.some(record => record.meta.requiresAuth)) {

		if (isAuthenticated) {

			const role = state.Authentications.authentication.role;

			if (to.matched.some(record => record.meta.isAdmin)) {

				if (role === "admin") {

					next();

				} else {

					next({

						name: "Unauthorized"

					});

				}

			} else if (to.matched.some(record => record.meta.isAssistant)) {

				if (role === "assistant") {

					next();

				} else {

					next({

						name: "Unauthorized"

					});

				}

			}

		}

	} else {

		next();

	}

});

export default router;
