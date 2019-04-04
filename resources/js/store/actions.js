
export default {

	async init ({ commit, dispatch }) {

		const technicians = await dispatch("Technicians/getTechnicians", null, { root: true });
		const settings = await dispatch("AppSettings/getSettings", null, { root: true });
		const currentPayPeriod = await dispatch("PayPeriods/getCurrent", null, { root: true });
		commit("Technicians/SET_TECHNICIANS", technicians, { root: true });
		commit("AppSettings/SET_SETTINGS", settings, { root: true });
		commit("PayPeriods/SET_CURRENT", currentPayPeriod, { root: true });

	},

	setDate ({ commit }, date) {

		commit("SET_DATE", date);

	},

};
